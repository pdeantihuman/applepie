<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User: 张昱
 * Date: 2017/5/24
 * Time: 23:39
 * Email: henbf@vip.qq.com
 */
class Weixin extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('Wxuserinfo_model');
        $this->load->library('CI_Wechat');
        $this->load->model('Wxnetinfo_model');
        $this->load->model('Wxmenu_model');
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

    public function mass(){
        if ($this->check_is_adminer()){
            exit;
        }else{
            $this->load->view('admin/mass');
        }
    }

    public function domass(){
        if ($this->check_is_adminer()){
            exit;
        }else{
            $data = $this->input->post('content');
            if($data == ''){
                $return = [
                    'state' => 2,
                    'message' => "内容不能为空",
                ];
                $return = json_encode($return);
                echo $return;
                exit;
            }
            $weixin = [
                'filter' => [
                    'is_to_all' =>True
                ],
                'msgtype' =>'text',
                'text'=>[
                    'content'=>"$data"
                ]
            ];
            if($this->ci_wechat->sendGroupMassMessage($weixin)){
                $return = [
                    'state' => 1,
                    'message' => "群发成功",
                ];
                $return = json_encode($return);
                echo $return;
                exit;
            }
        }
    }

    /**
     *给微信设置菜单
     */
    public function setmenu(){
        if($this->check_is_adminer()){
            exit;
        }else{
            $menu = $this->Wxmenu_model->get();
            $data = array(
                "button"=> array(
                    array(
                        "name"=>"服务中心",
                        "sub_button"=> $menu

//                            array(
//                            array('type'=>'view','name'=>'校园VR','url'=>'http://weixin.smell.ren/url/vr'),
//                        array('type'=>'view','name'=>'电费查询','url'=>'http://weixin.smell.ren/url/power'),
//                            array('type'=>'click','name'=>'电费查询','key'=>'df'),
//                            array('type'=>'view','name'=>'校历查询','url'=>'http://weixin.smell.ren/url/calenday'),
//                            array('type'=>'view','name'=>'图书查询','url'=>'http://weixin.smell.ren/url/book')
//                        )
                    ),
                    array(
                        "name"=>"网络服务",
                        "sub_button"=> array(
                            array('type'=>'view','name'=>'申请开网','url'=>'http://weixin.smell.ren/url/net'),
                            array('type'=>'view','name'=>'网络报修','url'=>'http://weixin.smell.ren/url/repair'),
                            array('type'=>'view','name'=>'帮助手册','url'=>'http://weixin.smell.ren/news/news/')
                        )
                    ),

                    array('type'=>'view','name'=>'个人中心','url'=>'http://weixin.smell.ren/url/ucenter')
                )
            );
            $result = $this->ci_wechat->createMenu($data);
            if($result){
                $return = [
                    'state' => 1,
                    'message' => "成功",
                ];
                $return = json_encode($return);
                echo $return;
                exit;
            }else{
                $return = [
                    'state' => 2,
                    'message' => "失败",
                ];
                $return = json_encode($return);
                echo $return;
                exit;
            }
        }
    }
    public function menu(){
        if($this->check_is_adminer()){
            exit;
        }else{
            $data['menu'] = $this->Wxmenu_model->getall();
            $this->load->view('admin/menu',$data);
        }
    }
    public function delmenu(){
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
            $check=$this->Wxmenu_model->del($id);
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
    public function addmenu(){
        if($this->check_is_adminer()){
            exit;
        }else{

            $name = $this->input->post('name');
            $url = $this->input->post('url');

            if($name==""){
                $return = [
                    'state' => 2,
                    'message' => "标题不能为空",
                ];
                $return = json_encode($return);
                echo $return;
                exit;
            }
            if($url==""){
                $return = [
                    'state' => 2,
                    'message' => "地址不能为空",
                ];
                $return = json_encode($return);
                echo $return;
                exit;
            }
            $data=[

                'type'=>'view',
                'name' =>"$name",
                'url'=>"$url"
            ];
            if($this->Wxmenu_model->add($data)){
                $return = [
                    'state' => 1,
                    'message' => "成功",
                ];
                $return = json_encode($return);
                echo $return;
            }else{
                $return = [
                    'state' => 2,
                    'message' => "失败",
                ];
                $return = json_encode($return);
                echo $return;
            }
        }
    }
}