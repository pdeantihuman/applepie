<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User: 张昱
 * Date: 2017/5/9
 * Time: 23:57
 * Email: henbf@vip.qq.com
 */
class Book extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->library('CI_Wechat');
        $this->load->library('tools');
    }

    /**
     * @return bool
     * 检查用户授权
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
     *图书查询页面控制器
     */
    public function search(){
        if(!$this->checkopenid()){
            exit;
        }
        $data['book']=$this->tools->newbook();
        $data['JS']=$this->ci_wechat->getJsSign('http://weixin.smell.ren/book/search');
        $this->load->view('weixin/booksearch',$data);
    }
    public function getbook(){
        if(!$this->checkopenid()){
            exit;
        }
        $search = $this->input->post('search');
        $data =$this->tools->book($search);
        if($data){
            $return=[
                'state'=> 'success',
                'link' => "/book/booklist/$search"

            ];
            echo json_encode($return);
            exit;
        }else{
            $return=[
                'state'=> 'error',
                'message' =>'没有查询到你需要的书籍'
            ];
            echo json_encode($return);
            exit;
        }
    }
    public function booklist($keyword){
        if(!$this->checkopenid()){
            exit;
        }
        $data['book'] =$this->tools->book($keyword);
        $data['JS']=$this->ci_wechat->getJsSign('http://weixin.smell.ren/book/booklist');
        $this->load->view('weixin/booklist',$data);
    }

}