<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: henbf
 * Date: 2017/5/7
 * Time: 13:06
 */
class Weixin extends CI_Controller{
    function __construct()
    {
        parent::__construct();
        $this->load->library('CI_Wechat');
        $this->load->model('Wxreply_model');
        $this->load->model('Wxguestbook_model');

    }


    /**
     *微信入口方法，对微信端进入的数据进行响应
     */
    public function index(){
        $this->ci_wechat->valid();
        $type = $this->ci_wechat->getRev()->getRevType();
        $content = $this->ci_wechat->getRevContent();
        $openid = $this->ci_wechat->getRevFrom();
        $time = $this->ci_wechat->getRevCtime();
        $enent = $this->ci_wechat->getRevEvent();


        /*
         * 对微信端的时间类型进行响应
         * */
        switch($type){
            /*
             * 如果用户给我们发送文字消息，我们的响应内容如下
             * */
            case Wechat::MSGTYPE_TEXT;
                $data = $this->Wxreply_model->getReplay($content);
                if($data){
                    $this->ci_wechat->text($data)->reply();
                }else{
                    $guestbookinfo=[
                        'g_openid' => $openid,
                        'g_content' => $content,
                        'g_type' => 'text',
                        'g_time' => $time
                    ];
                    if($this->Wxguestbook_model->addGuestbook($guestbookinfo)){

                    }else{
                        $this->ci_wechat->text('系统异常，请联系管理员')->reply();
                    }
                }
                break;

            /*
             * 如果用户发送图片信息，就将
             * 图片信息保存到服务器上面
             * */
            case Wechat::MSGTYPE_IMAGE:
                $picinfo= $this->ci_wechat->getRevPic();
                $out = file_get_contents($picinfo['picurl']);
                $imageName = $time.rand(1,9);
                $image="./upload/"."$imageName".".jpg";
                file_put_contents($image,$out);
                $guestbookinfo=[
                    'g_openid' => $openid,
                    'g_pictureid' => $picinfo['mediaid'],
                    'g_pictureurl' => "/upload/"."$imageName".".jpg",
                    'g_type' => 'images',
                    'g_time' => $time
                ];
                if($this->Wxguestbook_model->addGuestbook($guestbookinfo)){
                    $this->ci_wechat->text('好吧，实话告诉你，其实我是在套路你的图片来了')->reply();break;
                }else{
                    $this->ci_wechat->text('系统异常，请联系管理员')->reply();
                }
                break;
            case Wechat::MSGTYPE_VOICE:
                $this->ci_wechat->text('很抱歉，公众号不接收语音类消息')->reply();
                break;
            case Wechat::MSGTYPE_VIDEO:
                $this->ci_wechat->text('很抱歉，公众号不接收视频类消息')->reply();
                break;
            case Wechat::MSGTYPE_EVENT:
                switch ($enent['event']){
                    case Wechat::EVENT_SUBSCRIBE:
                        $this->load->model('Wxconcern_model');
                        $this->config->load('wechat');
                        $replay = $this->config->item('sub');
                        $data = [
                            'C_openid' => $openid,
                            'C_state' => 1,
                            'C_time' => $time
                        ];
                        if($this->Wxconcern_model->action($data)){
                            $this->ci_wechat->text($replay)->reply();
                        }else{
                            $this->ci_wechat->text('系统异常，请联系管理员')->reply();
                        }
                        break;
                    case Wechat::EVENT_UNSUBSCRIBE:
                        $this->load->model('Wxconcern_model');
                        $data = [
                            'C_openid' => $openid,
                            'C_state' => 2,
                            'C_time' => $time
                        ];
                        $this->Wxconcern_model->action($data);
                        break;

                    /*
                     * 获取二维码的参数进行数据响应
                     * */
                    case Wechat::EVENT_SCAN:
                        $sceneid = $this->ci_wechat->getRevSceneId();
                        $this->ci_wechat->text($sceneid)->reply();
                        break;
                    /*
                     * 菜单点击时间的响应
                     * */
                    case Wechat::EVENT_MENU_CLICK;
                        $key = $this->ci_wechat->getRevEvent()['key'];
                        switch ($key){
                            case  "df":
//                                $this->ci_wechat->image("guhBtkUjjXEoGFEFWxXHBGFZAfW2Xmi0Sq6QrxipjFs")->reply();break;
                                $this->ci_wechat->text('关闭中，开放时间待定')->reply();break;
                            case  "caidan":
                                $this->ci_wechat->text('电费停止查询')->reply();break;
                            default:
                                break;
                        }
                        break;

                    default:
                        break;
                }
                break;
            default:
                break;
        }
    }
}