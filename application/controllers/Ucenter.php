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
        $this->load->model('WxUserInfo_model');
        $this->load->model('WxNetInfo_model');

    }

    private function denyAccess()
    {
        $this->load->view('accessDenied');
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
                return false;
            } else {
                $data = [
                    'openid' => $accessToken['openid']
                ];
                $this->session->set_userdata($data);
                return isset($this->session->openid);
            }
        } else
            return true;
    }

    /**
     *检查用户是否绑定了微信
     */
    private function _checkuser()
    {
        return $this->WxUserInfo_model->checkuseropenid($this->session->openid);
    }

    /**
     *用户个人中心主界面
     */
    public function index()
    {
        if (!$this->checkopenid()) {
            $this->denyAccess();
        } else {
            if ($this->_checkuser()) {
                $data['userinfo'] = $this->WxUserInfo_model->getInfoByOpenId($this->session->openid);
                $data['netinfo'] = $this->WxNetInfo_model->getInfoByOpenId($this->session->openid);
                unset($data['netinfo']['Nid']);
                $data['url'] = $this->ci_wechat->getUserInfo($this->session->openid)['headimgurl'];
                $this->load->view('weixin/ucenter', $data);
            } else {
                $url = $this->ci_wechat->getOauthRedirect("http://weixin.smell.ren/bind");
                header("location:$url");
            }

        }


    }
}