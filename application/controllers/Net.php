<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: henbf
 * Date: 2017/5/11
 * Time: 17:31
 * 网络开通申请
 */
class Net extends CI_Controller
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

    private function _checkuser(){
        if($this->WxUserInfo_model->checkuseropenid($this->session->openid)) {
            return true;
        }else{
            return false;
        }
    }

    public function index(){
        if(!$this->checkopenid()){
            exit;
        }
        if($this->_checkuser()){
            if ($this->WxNetInfo_model->getStateByOpenId($this->session->openid)==1)
                $this->load->view('weixin/netinfo');
            //检查用户已经开通了账户，下一步需要调用内网的借口进行查询剩余网费的信息
            else{
                $url="http://weixin.smell.ren/bind";
                header("location:$url");
            }
        }else {
            $url="http://weixin.smell.ren/bind";
            header("location:$url");
        }

    }


    public function api(){
        if(!$this->checkopenid()){
            exit;
        }
//        $data = [
//            'N_openid' => $this->session->openid,
//            'N_state' => '4',
//            'N_time' => time()
//        ];
        //如果要你进行其他验证的话，请在这里进行代码的添加


        if($this->WxNetInfo_model->getStateByOpenId($this->session->openid)==4){
            $return=[
                'state'=> 'error',
                'message' =>'你已经提交过申请'
            ];
            echo json_encode($return);
            exit;
        }
        if($this->WxNetInfo_model->applicationByOpenId($this->session->openid)){
            $return=[
                'state'=> 'success',
                'link' =>'/url/bind'
            ];
            echo json_encode($return);
            exit;
        }else{
            $return=[
                'state' => 'error',
                'message' => '申请失败'
            ];
            echo json_encode($return);
            exit;
        }



    }

}