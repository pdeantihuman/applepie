<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User: 张昱
 * Date: 2017/5/25
 * Time: 23:05
 * Email: henbf@vip.qq.com
 */
class News extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Wxnews_model');
        $this->load->model('Wxnewstag_model');
    }


    public function index(){
            $data['list']= $this->Wxnewstag_model->listtag();
            $this->load->view('news/newstag',$data);
    }

    public function tag(){
        $parm = $this->uri->segment(4,0);
        if($parm=="0"){
            show_404();
        }else{
        $data['list']= $this->Wxnews_model->listnewstitle($parm);
        $data['title']=$this->Wxnewstag_model->getnamebyid($parm);
        $this->load->view('news/newslist',$data);
        }
    }
    public function doc(){
        $parm = $this->uri->segment(4,0);
        if($parm=="0"){
            show_404();
        }else{
            $check = $this->Wxnews_model->getnewsbyid($parm);
            if($check){
                $data['news']=$check;
                $this->load->view('news/news',$data);
            }else{
                show_404();
            }


        }


    }

}