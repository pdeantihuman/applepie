<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: henbf
 * Date: 2017/5/11
 * Time: 19:35
 * 维修订单控制器
 */
class Fix extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->library('CI_Wechat');
        $this->load->model('Wxfixorder_model');
        $this->load->model('Wxuserinfo_model');
        $this->load->model('Wxnetinfo_model');
        $this->load->model('Wxfixuser_model');
        $this->load->model('Wxfixorderfollow_model');
        $this->load->model('WxWeChatFunction_model');
    }

    /**
     * @return bool
     * 1， 检查是否为微信端进入
     * 2， 如果是微信端用户，获取openid 到session
     */
    private function checkopenid()
    {
        if (!$this->session->openid) {
            $accessToken = $this->ci_wechat->getOauthAccessToken();
            if (!isset($accessToken['openid'])) {
                echo "你想干嘛想干嘛想干嘛。这里不给你看(*@ο@*) 哇～";
                return false;
            } else{
                $userInfo = [
                    'openid' => $accessToken['openid']
                ];
                $this->session->set_userdata($userInfo);
                return true;
            }
        }
        return true;
    }

    /**
     *检查用户是否绑定了微信
     */
    private function _checkuser(){
        if($this->Wxuserinfo_model->checkuseropenid($this->session->openid)) {
            return true;
        }else{
            return false;
        }
    }


    /**
     * 判断用户是否是维修人员
     * @return bool
     */
    private function isFixUser(){
        return $this->Wxfixuser_model->checkFixUserByOpenId($this->session->openid);
    }

    /**
     *报修主界面
     */
    public function index(){
        if(!$this->checkopenid()){
            exit;
        }
        if($this->_checkuser()){
//            if ($this->isFixUser())
//                $this->load->view('weixin/fixinfoforfix'); //TODO:需要一个维修人员的页面
//            else
                $this->load->view('weixin/netfix');
        }else{
            $url=$this->ci_wechat->getOauthRedirect("http://weixin.smell.ren/bind");
            header("location:$url");
        }

    }

    /**
     *添加维修订单
     */
    public function addfix(){
        if(!$this->_checkuser()){
            exit;
        }
        $this->load->view('weixin/addfix');
    }


    /**
     *根据用户列出该用户所有的维修订单
     */
    public function fixlist(){
        if(!$this->_checkuser()){
            exit;
        }
        $listinfo=$this->Wxfixorder_model->getorderlist($this->session->openid);
        $data['list']=$listinfo;
        $data['JS']=$this->ci_wechat->getJsSign('http://weixin.smell.ren/');
        $this->load->view('weixin/fixlist',$data);
    }

    /**
     *查看最新提交的报修详情
     */
    public function newfix(){
        if(!$this->_checkuser()){
            exit;
        }
        $oderinfo=$this->Wxfixorder_model->getLatestOrder($this->session->openid);
        $data['orderinfo'] = $oderinfo;
        $this->load->view('weixin/fixinfo',$data);
    }

    /**
     * @param $id
     * 查询单条维修记录的信息
     */
    public function fixinfobyid($id)
    {
        if(!$this->_checkuser()){//TODO：需要按照查看订单施工
            exit;
        }
        $data['info']=$this->Wxfixorder_model->getfixlistbyid($id,$this->session->openid);
        if(!$data['info']){
            show_404();
            exit;
        }
        $data['JS']=$this->ci_wechat->getJsSign('http://weixin.smell.ren/');
        $data['fixOrderFollow']=$this->Wxfixorderfollow_model->getinfobyfoid($id);
        $this->load->view('weixin/fixinfobyid',$data);
    }
    private function transfer($id,$message ,$OutOpenId, $InOpenId){
        $return1= $this->Wxfixorderfollow_model->tranasferOut($id,$message,$OutOpenId);
        $return2= $this->Wxfixorderfollow_model->transferIn($id,$InOpenId);
        return $return1 and $return2;
    }

    /**
     * @param $id
     *  维修人员获取到的报修信息
     */
    public function fixer($id){
        if(!$this->_checkuser()){
            exit;
        }
        $openid = $this->session->openid;
        if($this->Wxfixorderfollow_model->accessToRead($id,$openid)){
            if ($this->Wxfixorderfollow_model->accessToControl($id,$openid)){
                $data['fixUser']=$this->Wxfixuser_model->getAllUserNameExceptSelf($this->session->openid);
                $data['info']=$this->Wxfixorder_model->getfixlistbyid($id,$this->Wxfixorder_model->getfixopenidbyid($id));
                if(!$data['info']){
                    show_404();
                    exit;
                }
                $data['id']=$id;
                $data['fixOrderFollow']=$this->Wxfixorderfollow_model->getinfobyfoid($id);
                $data['address']=$this->Wxuserinfo_model->getuerinfobyopenid($this->Wxfixorder_model->getfixopenidbyid($id))['U_dormitory'];
                $this->load->view('weixin/fixinfoforfix',$data);
            }else{
                $this->fixinfobyid($id);
            }
        }else{
            $this->load->view('weixin/success');
        }

    }

    public function success(){
        $this->load->view('weixin/success');//TODO:需要一个提示成功的页面
    }


    /**
     *维修订单api接口调用
     */
    public function api(){
        if(!$this->checkopenid()){
            exit;
        }
        if(!$this->_checkuser()){
            exit;
        }
        $key = $this->input->post('key');
        if(is_null($key)){
            show_404();
        }
        $state=$this->Wxnetinfo_model->getStateByOpenId($this->session->openid);
        switch ($key){
            case 'fix':
                switch ($state){
                    case '1':
                        $return=[
                            'state' => 'error',
                            'message' => '你未申请开通网络，不可进行报修操作。'
                        ];
                        break;
                    case '3':
                        $return=[
                            'state' => 'error',
                            'message' => '你的账户已被冻结，不可进行报修操作。'
                        ];
                        break;
                    case '4':
                        $return=[
                            'state' => 'error',
                            'message' => '你还未开通网络，不可进行报修操作。'
                        ];
                        break;
                    default:
                        if($this->Wxfixorder_model->hasUnfinishedOrder($this->session->openid)){
                            $return=[
                                'state'=> 'error',
                                'message' =>'你仍有未完成的报修'
                            ];
                        } else{
                            $return=[
                                'state'=> 'success',
                                'link' =>'/fix/addfix'
                            ];
                        }
                        break;
                }
                echo json_encode($return);
                break;
            case 'fixlist':
                $return=[
                    'state'=> 'success',
                    'link' =>'/fix/fixlist'
                ];
                echo json_encode($return);
                break;
            case 'addfix':

                if($this->Wxfixorder_model->hasUnfinishedOrder($this->session->openid)){
                    $return=[
                        'state'=> 'error',
                        'message' =>'你的报修信息已提交，请不要重复提交'
                    ];
                    echo json_encode($return);
                }else{
                    $data =[
                        'Fo_openid' => $this->session->openid,
                        'Fo_type' => $this->input->post('type'),
                        'Fo_comment' => $this->input->post('content')
                    ];
                    if($this->Wxfixorder_model->add($data)){
                        $return=[
                            'state'=> 'success',
                            'link' =>'/fix/newfix'
                        ];
                        echo json_encode($return);
                    }else{
                        $return=[
                            'state' => 'error',
                            'message'=> '添加订单失败'
                        ];
                    }
                }

                break;
            case 'addfollow':
                //获取当前这条数据是否已经被处理过
                $id=$this->input->post('foid');
                if(!$this->Wxfixorderfollow_model->accessToControl($id,$this->session->openid)){
                    $return=[
                        'state'=> 'error',
                        'message' =>'你已经处理过这条数据了'
                    ];
                    echo json_encode($return);
                }else{
                    $Fu_openid = $this->Wxfixuser_model->getOpenIdByName($this->input->post('fixname'));
                    $return =$this->transfer($id,$this->input->post('message') ,$this->session->openid,$Fu_openid);
                    if($return){
                        $fixinfo = $this->Wxfixorder_model->getfixinfobyid($id);
                        $address = $this->Wxuserinfo_model->getuerinfobyopenid($fixinfo['Fo_openid'])['U_dormitory'];
                        $this->WxWeChatFunction_model->sendFixInfoForFixUser($id,$Fu_openid,$fixinfo['Fo_comment'],$fixinfo['Fo_time'],$address);
                        $return=[
                            'state'=> 'success',
                            'link' =>"/fix/success"
                        ];
                        echo json_encode($return);
                    }else{
                        show_404();
                    }
                }
                break;
            case 'overfollow':
                $id=$this->input->post('foid');
                if(!$this->Wxfixorderfollow_model->accessToControl($id,$this->session->openid)){
                    $return=[
                        'state'=> 'error',
                        'message' =>'你已经处理过这条数据了'
                    ];
                    echo json_encode($return);
                }else{
                    if($this->Wxfixorderfollow_model->finishOrder($id,"暂且完成",$this->session->openid)){
                        $this->Wxfixorder_model->updatestate($id,'3');
                        $return=[
                            'state'=> 'success',
                            'link' =>"/fix/success"//TODO：转操作成功
                        ];
                        echo json_encode($return);
                    }
                }
                break;
            default:
                break;
        }

    }

}