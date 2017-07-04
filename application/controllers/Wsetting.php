<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: henbf
 * Date: 2017/5/7
 * Time: 16:25
 */
class Wsetting extends CI_Controller{
    function __construct()
    {
        parent::__construct();
        $this->load->library('CI_Wechat');
    }


    /**
     *给微信设置菜单
     */
    public function setmenu(){

        $data = array(
            "button"=> array(
                array(
                    "name"=>"服务中心",
                    "sub_button"=> array(
                        array('type'=>'view','name'=>'校园VR','url'=>'http://weixin.smell.ren/url/vr'),
//                        array('type'=>'view','name'=>'电费查询','url'=>'http://weixin.smell.ren/url/power'),
                        array('type'=>'click','name'=>'电费查询','key'=>'df'),
                        array('type'=>'view','name'=>'校历查询','url'=>'http://weixin.smell.ren/url/calenday'),
                        array('type'=>'view','name'=>'图书查询','url'=>'http://weixin.smell.ren/url/book')
                    )
                ),
                array(
                    "name"=>"网络服务",
                    "sub_button"=> array(
                        array('type'=>'view','name'=>'账号绑定','url'=>'http://weixin.smell.ren/url/bind'),
                        array('type'=>'view','name'=>'申请开网','url'=>'http://weixin.smell.ren/url/net'),
                        array('type'=>'view','name'=>'网络报修','url'=>'http://weixin.smell.ren/url/repair'),
                        array('type'=>'view','name'=>'网络助手','url'=>'http://weixin.smell.ren/news/news/')
                    )
                ),

                array('type'=>'view','name'=>'个人中心','url'=>'http://weixin.smell.ren/url/ucenter')
            )
        );
        $result = $this->ci_wechat->createMenu($data);
        print_r($result);

    }


}