<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: henbf
 * Date: 2017/5/7
 * Time: 16:39
 * 微信url的管理入口
 */
class Wurl extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('CI_Wechat');
    }
    public function url(){
        $parm = $this->uri->segment(2,0);
        switch ($parm){
            case 'bind':
                $url=$this->ci_wechat->getOauthRedirect("http://weixin.smell.ren/bind");
                break;
            case 'repair':
                $url=$this->ci_wechat->getOauthRedirect("http://weixin.smell.ren/fix");break;
            case 'power':
                $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxecefa82667c5ac83&redirect_uri=http%3A%2F%2Fwww.cdgfwx.com%2Fisimsweb%2FToLoginServlet&response_type=code&scope=snsapi_base&state=123&connect_redirect=1#wechat_redirect";break;
            case 'vr':
                $url="http://720yun.com/t/ppplmw5a3nh5647rhj?pano_id=piAXHq8ryl9S40Vr";break;
            case 'ucenter':
                $url=$this->ci_wechat->getOauthRedirect("http://weixin.smell.ren/ucenter/index");
                break;
            case 'calenday':
                $url=$this->ci_wechat->getOauthRedirect("http://weixin.smell.ren/bind/calenday");
                break;
            case 'book':
                $url=$this->ci_wechat->getOauthRedirect("http://weixin.smell.ren/book/search");
                break;
            case 'net':
                $url=$this->ci_wechat->getOauthRedirect("http://weixin.smell.ren/net");
                break;
            default:
                show_404();
                exit;
        }
        header("location:$url");


    }

}