<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: henbf
 * Date: 2017/5/20
 * Time: 16:45
 */
class Index extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('Wxadminer_model');
    }

    /**
     * @return bool
     * 检查用户是否登录
     */
    private function check_is_adminer() {
        $admin = $this->session->admin;
        if(is_null($admin)){
            return true;
        }else{
            return false;
        }
    }

    /**
     *后台管理登录判断
     */
    public function index(){
        if($this->check_is_adminer()){
            $this->load->view('admin/login');
        }else{
            $this->load->view('admin/index');
        }




    }
    public function test(){

    }

    /**
     *登录操作
     */
    public function login(){
        $name=$this->input->post('username');
        $pass=$this->input->post('password');
        if($this->check_is_adminer()){
            $check =$this->Wxadminer_model->login($name,$pass);
            if($check){
                $data =[
                    'admin' => $name
                ];
                $this->session->set_userdata($data);
                $return =[
                    'state' => 1,
                    'message' =>"登录成功",
                    'link' =>'admin'
                ];
                $return = json_encode($return);
                echo  $return;
            }else{
                $return =[
                    'state' => 2,
                    'message' =>"请确认您的账号和密码是否正确"
                ];
                echo json_encode($return);
            }

        }else{
            show_404();
        }

    }

    /**
     *退出操作
     */
    public function logout(){
        if(!$this->check_is_adminer()){
            $this->session->unset_userdata('admin');
            header("location:admin");
        }else{
            show_404();
        }


    }

    /**
     *用户修改密码界面
     */
    public function changepassword(){
        if(!$this->check_is_adminer()){
            $this->load->view('admin/changepassword');
        }else{
            show_404();
        }
    }
    public function dochange(){
        if(!$this->check_is_adminer()){
            $password = $this->input->post('password');
            $newpassword = $this->input->post('newpassword');
            $check =$this->Wxadminer_model->login($this->session->admin,$password);
            if($check){
                if($this->Wxadminer_model->changepassword($this->session->admin,$newpassword)){
                    $return =[
                        'state' => 1,
                        'message' =>"密码修改成功",
                        'link' =>'logout'
                    ];
                    $return = json_encode($return);
                    echo  $return;
                }else{
                    $return =[
                        'state' => 2,
                        'message' =>"出现异常"
                    ];
                    echo json_encode($return);
                }

            }else{
                $return =[
                    'state' => 2,
                    'message' =>"你的原密码不正确"
                ];
                echo json_encode($return);
            }

        }else{
            show_404();
        }
    }


}