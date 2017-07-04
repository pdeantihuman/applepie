<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User: 张昱
 * Date: 2017/5/30
 * Time: 19:29
 * Email: henbf@vip.qq.com
 */
class Fix extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('CI_Wechat');
        $this->load->helper('url');
        $this->load->model('Wxfixorder_model');
        $this->load->model('Wxuserinfo_model');
        $this->load->model('Wxfixuser_model');
        $this->load->model('Wxfixorderfollow_model');
    }

    /**
     * @return bool
     * 检查用户是否登录
     */
    private function check_is_adminer()
    {
        $admin = $this->session->admin;
        if (is_null($admin)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     *查看没有处理的订单列表
     */
    public function nothandlelist(){
        if($this->check_is_adminer()){
            exit;
        }else{
            if(!$data['list'] = $this->Wxfixorder_model->getfixlistbystate('1')){
                echo "没有需要处理的数据";
                exit;
            }
            for($i=0;$i<count($data['list']);$i++){
                $userinfo = $this->Wxuserinfo_model->getuerinfobyopenid($data['list'][$i]['Fo_openid']);
                $data['list'][$i]['userinfo']=$userinfo;
            }
//            print_r($data['list'][0]['userinfo']);
//            exit;
            $this->load->view('admin/nohandlelist',$data);
        }
    }

    /**
     *查看正在进行中的维修订单列表
     */
    public function handleinglist(){
        if($this->check_is_adminer()){
            exit;
        }else{
            if(!$data['list'] = $this->Wxfixorder_model->getfixlistbystate('2')){
                echo "没有需要处理的数据";
                exit;
            }
            for($i=0;$i<count($data['list']);$i++){
                $userinfo = $this->Wxuserinfo_model->getuerinfobyopenid($data['list'][$i]['Fo_openid']);
                $data['list'][$i]['userinfo']=$userinfo;
            }
        }$this->load->view('admin/handleinglist',$data);
    }

    /**
     * @param int $page
     * 按照页数来查看已经完成的订单信息列表
     */
    public function handleedlist($page = 1){
        if($this->check_is_adminer()){
            exit;
        }else{
            $data['list'] = $this->Wxfixorder_model->getfixlistbystatepage('3',$page);
            $data['count']=$this->Wxfixorder_model->count('3');
            $data['curr']=$page;
            for($i=0;$i<count($data['list']);$i++){
                $userinfo = $this->Wxuserinfo_model->getuerinfobyopenid($data['list'][$i]['Fo_openid']);
                $data['list'][$i]['userinfo']=$userinfo;
            }
        }$this->load->view('admin/handleedlist',$data);
        }


    /**
     * @param $id
     * 根据订单id查看该订单的维修记录
     */
    public function listlog($id){
        if($this->check_is_adminer()){
            exit;
        }else{
            $data['log']=$this->Wxfixorderfollow_model->getinfobyfoid($id);
            $this->load->view('admin/listlog',$data);
        }
    }

    /**
     *删除
     */
    public function del(){
        if ($this->check_is_adminer()) {
            exit;
        } else {
            $id=$this->input->post('id');
            if($id==""){
                $return = [
                    'state' => 2,
                    'message' => "不能为空",
                ];
                $return = json_encode($return);
                echo $return;
                exit;
            }
            $check=$this->Wxfixorder_model->del($id);
            if ($check) {
                $return = [
                    'state' => 1,
                    'message' => "删除成功",
                ];
                $return = json_encode($return);
                echo $return;
            }else{
                $return = [
                    'state' => 2,
                    'message' => "删除失败",
                ];
                $return = json_encode($return);
                echo $return;
            }
        }
    }

    /**
     * @param $id
     * 根据维修人员的id来确定谁去进行维修
     */
    public function choosefixer($id){
        if($this->check_is_adminer()){
            exit;
        }else{
            $data['user']=$this->Wxfixuser_model->getallfixuserinfo();
            $data['id']=$id;
            $this->load->view('admin/choosefixer',$data);
        }
    }

    /**
     *确认维修人，参数包括维修人id和需要维修的订单
     */
    public function dochoose(){
        if($this->check_is_adminer()){
            exit;
        }else{
            $Fuid=$this->input->post('id');
            $Foid=$this->input->post('fid');
            $data = [
                'Fof_foid' => $Foid,
                'Fof_fuopenid' =>$this->Wxfixuser_model->getfixuseopenidbyfuid($Fuid),
                'Fof_time' =>time(),
                'Fof_message'=>'管理员分配维修人员',
                'Fof_state' =>1,
                'Fof_result' =>1
            ];
            if($this->Wxfixorderfollow_model->addfixorderfollow($data)){
                $this->Wxfixorder_model->updatestate($Foid,'2');
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
                $return = [
                    'state' => 1,
                    'message' => "成功",
                ];
                $return = json_encode($return);
                echo $return;
            }
        }

    }
}