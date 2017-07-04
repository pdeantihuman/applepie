<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: henbf
 * Date: 2017/5/21
 * Time: 13:40
 * 个人中心控制器
 */
class Ucenter extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->library('CI_Wechat');
        $this->load->model('Wxuserinfo_model');
        $this->load->model('Wxnetinfo_model');

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
     *用户个人中心主界面
     */
    public function index(){
        if(!$this->checkopenid()){
            exit;
        }
        if($this->_checkuser()){
            $data['userinfo'] = $this->Wxuserinfo_model->getuerinfobyopenid($this->session->openid);
            $data['netinfo'] = $this->Wxnetinfo_model->getstate($this->session->openid);
            $data['url'] =$this->ci_wechat->getUserInfo($this->session->openid)['headimgurl'];
            $this->load->view('weixin/ucenter',$data);
        }else{
            $url=$this->ci_wechat->getOauthRedirect("http://weixin.smell.ren/bind");
            header("location:$url");
        }

    }



}