<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: henbf
 * Date: 2017/5/8
 * Time: 9:16
 * 微信绑定学生学号控制器控制器
 */
class Bind extends CI_Controller{

    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->library('CI_Wechat');
        $this->load->model('Wxuserinfo_model');
        $this->load->model('Sysconfig_model');
        echo $this->session->openid;
        exit;

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
     *微信用户学号绑定
     */
    public function index(){
        if(!$this->checkopenid()){
            exit;
        }
        if($this->Wxuserinfo_model->checkuseropenid($this->session->openid)){
            $data['userinfo']=$this->Wxuserinfo_model->getuerinfobyopenid($this->session->openid);
            $this->load->model('Wxnetinfo_model');
            $data['netstate']= $this->Wxnetinfo_model->getstate($this->session->openid);
            $data['JS']=$this->ci_wechat->getJsSign('http://weixin.smell.ren/ur/bind');
            $this->load->view('weixin/userinfo',$data);
        }else{
            $data['profession']=$this->Sysconfig_model->getProfession();
            $data['instructor']=$this->Sysconfig_model->getInstructor();
            $this->load->view('weixin/bind',$data);
        }
    }

    /**
     *学校日历
     */
    public function calenday(){
        if(!$this->checkopenid()){
            exit;
        }
        $data['JS']=$this->ci_wechat->getJsSign('http://weixin.smell.ren/ur/calenday');
        $this->load->view('weixin/calenday',$data);
    }
}