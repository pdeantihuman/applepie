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
    }
    /**
     * @return bool
     * 1， 检查是否为微信端进入
     * 2， 如果是微信端用户，获取openid 到session
     */
    private function checkopenid(){
        if(!$this->session->openid){
            $accessToken = $this->ci_wechat->getOauthAccessToken();
            if($accessToken['openid'] === null){
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
     *报修主界面
     */
    public function index(){
        if(!$this->checkopenid()){
            exit;
        }
        if($this->_checkuser()){
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
        $oderinfo=$this->Wxfixorder_model->getNeworder($this->session->openid);
        $data['orderinfo'] = $oderinfo;
        $this->load->view('weixin/fixinfo',$data);
    }

    /**
     * @param $id
     * 查询单条维修记录的信息
     */
    public function fixinfobyid($id){
        if(!$this->_checkuser()){
            exit;
        }
        $data['info']=$this->Wxfixorder_model->getfixlistbyid($id,$this->session->openid);
        if(!$data['info']){
            show_404();
            exit;
        }
        $data['JS']=$this->ci_wechat->getJsSign('http://weixin.smell.ren/');
        $data['fixorderfollow']=$this->Wxfixorderfollow_model->getinfobyfoid($id);
        $this->load->view('weixin/fixinfobyid',$data);
    }

    /**
     * @param $id
     *  维修人员获取到的报修信息
     */
    public function fixer($id){
        if(!$this->_checkuser()){
            exit;
        }
        if($this->Wxfixorderfollow_model->getresult($id)){
            echo '已经处理过了';
            exit;
        }
        $data['fixuser']=$this->Wxfixuser_model->getallfixusername();
        $data['info']=$this->Wxfixorder_model->getfixlistbyid($id,$this->Wxfixorder_model->getfixopenidbyid($id));
        if(!$data['info']){
            show_404();
            exit;
        }
        $data['id']=$id;
        $data['fixorderfollow']=$this->Wxfixorderfollow_model->getinfobyfoid($id);
        $data['address']=$this->Wxuserinfo_model->getuerinfobyopenid($this->Wxfixorder_model->getfixopenidbyid($id))['U_dormitory'];
        $this->load->view('weixin/fixinfoforfix',$data);

    }
    public function success(){
        $this->load->view('success');
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

        switch ($key){
            case 'fix':
                if(!$this->Wxnetinfo_model->get_net_state($this->session->openid)){
                    $return=[
                        'state'=> 'error',
                        'message' =>'你没有申请开通网络，不可进行报修操作'
                    ];
                }elseif($this->Wxfixorder_model->getNewestorder($this->session->openid)){
                    $return=[
                        'state'=> 'success',
                        'link' =>'/fix/addfix'
                    ];
                } else{
                    $return=[
                        'state'=> 'error',
                        'message' =>'你还有没有处理完的报修订单'
                    ];
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
                if($this->Wxfixorder_model->getNewestorder($this->session->openid)){
                    $data =[
                        'Fo_openid' => $this->session->openid,
                        'Fo_type' => $this->input->post('type'),
                        'Fo_content' => $this->input->post('content'),
                        'Fo_time'=>time(),
                        'Fo_state' => '1'
                    ];
                    if($this->Wxfixorder_model->add($data)){
                        $return=[
                            'state'=> 'success',
                            'link' =>'/fix/newfix'
                        ];
                        echo json_encode($return);
                    }

                }else{
                    $return=[
                        'state'=> 'error',
                        'message' =>'你的报修信息已提交，请不要重复提交'
                    ];
                    echo json_encode($return);
                }

                break;
            case 'addfollow':
                //获取当前这条数据是否已经被处理过
                $id=$this->input->post('foid');
                if($this->Wxfixorderfollow_model->getstatebyfoid($id,$this->session->openid)){
                    $return=[
                        'state'=> 'error',
                        'message' =>'你已经处理过这条数据了'
                    ];
                    echo json_encode($return);
                }else{
                    $data = [
                        'Fof_foid' => $id,
                        'Fof_fuopenid' =>$this->Wxfixuser_model->getopenidbyname($this->input->post('fixname')),
                        'Fof_time' =>time(),
                        'Fof_message'=>$this->input->post('message'),
                        'Fof_state' =>1
                    ];
                    if($this->Wxfixorderfollow_model->addfixorderfollow($data)){
                        $url = "http://weixin.smell.ren/fix/fixer/".$data['Fof_foid'];
                        $fixinfo = $this->Wxfixorder_model->getfixinfobyid($data['Fof_foid']);
                        $address = $this->Wxuserinfo_model->getuerinfobyopenid($fixinfo['Fo_openid'])['U_dormitory'];
                        $datatmp = [
                            "touser"=>$data['Fof_fuopenid'],
                            "template_id"=>'NrYxmqf5YqLKOH1KflBZV5TSs6AZcUjPXINKRCM7Lao',
                            "url"=>$url,
                            "topcolor"=>"#FF0000",
                            "data"=>[
                                'message'=>[
                                    'value'=>$fixinfo['Fo_content'],
                                    "color"=>"#173177"
                                ],
                                'time'=>[
                                    'value'=>date("Y-m-d H:i:s",$fixinfo['Fo_time']),
                                    "color"=>"#173177"
                                ],
                                'address'=>[
                                    'value'=>$address,
                                    "color"=>"#173177"
                                ],
                            ]
                        ];
                        $this->ci_wechat->sendTemplateMessage($datatmp);
                        $return=[
                            'state'=> 'success',
                            'link' =>"/fix/success"
                        ];
                        echo json_encode($return);
                    }
                }
                break;
            case 'overfollow':
                $id=$this->input->post('foid');
                if($this->Wxfixorderfollow_model->getstatebyfoid($id,$this->session->openid)){
                    $return=[
                        'state'=> 'error',
                        'message' =>'你已经处理过这条数据了'
                    ];
                    echo json_encode($return);
                }else{
                    $data = [
                        'Fof_foid' => $id,
                        'Fof_fuopenid' =>$this->session->openid,
                        'Fof_time' =>time(),
                        'Fof_message'=>'完成',
                        'Fof_state' =>2,
                        'Fof_result' =>2
                    ];
                    if($this->Wxfixorderfollow_model->addfixorderfollow($data)){
                        $this->Wxfixorder_model->updatestate($id,3);
                        $return=[
                            'state'=> 'success',
                            'link' =>"/fix/success"
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