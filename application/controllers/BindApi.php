<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: henbf
 * Date: 2017/5/8
 * Time: 10:20
 * 绑定操作返回json结果的控制器
 */
class BindApi extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Wxuserinfo_model');
        $this->load->model('Wxverification_model');
        if(!$this->session->openid){
            show_404();
            exit;
        }

    }

    /**
     *账号绑定响应api返回json数据
     */
    public function index(){
        $U_openid = $this->session->openid;
        $U_name = $this->input->post('name');
        $U_number = $this->input->post('number');
        $U_card = substr($this->input->post('card'),6);
        $U_sex = $this->input->post('sex');
        $U_class = $this->input->post('classid');
        $U_Expclass = $this->input->post('shiyanban');
        $U_profession = $this->input->post('major');
        $U_instructor = $this->input->post('fuzu');
        $U_dormitory = $this->input->post('zainum')."斋".$this->input->post('ssnum');
        $U_phone = $this->input->post('tel');
        $U_time = time();
        $data = [
            'U_openid' => $U_openid,
            'U_name' => $U_name,
            'U_number' => $U_number,
            'U_card' => $U_card,
            'U_sex' => $U_sex,
            'U_class' => $U_class,
            'U_Expclass' => $U_Expclass,
            'U_profession' =>$U_profession,
            'U_instructor' =>$U_instructor,
            'U_dormitory'=>$U_dormitory,
            'U_phone'=>$U_phone,
            'U_time'=>$U_time,
            'U_grade'=>substr($U_number,0,2)
        ];
        if($this->Wxuserinfo_model->checkuseropenid($data['U_openid'])){
            $return=[
                'state'=> 'error',
                'message' =>'你的微信号已经绑定过'
            ];
            echo json_encode($return);
            exit;
        }
        if(strlen($data['U_number'])<8 or strlen($data['U_number'])>9 ){
            $return=[
                'state'=> 'error',
                'message' =>'学号填写有误'
            ];
            echo json_encode($return);
            exit;
        }
        if($this->Wxuserinfo_model->checkusernumber($data['U_number'])){
            $return=[
                'state'=> 'error',
                'message' =>'你的学号已经绑定过'
            ];
            echo json_encode($return);
            exit;
        }
        if($this->Wxuserinfo_model->checkusercard($data['U_card'])){
            $return=[
                'state'=> 'error',
                'message' =>'你的身份证号码已经绑定过'
            ];
            echo json_encode($return);
            exit;
        }
        if($this->Wxuserinfo_model->checkuserphone($data['U_phone'])){
            $return=[
                'state'=> 'error',
                'message' =>'你的手机号已经绑定过'
            ];
            echo json_encode($return);
            exit;
        }
        if(!$this->Wxverification_model->getuserinfo($data['U_number'],$data['U_card'])){
            $return=[
                'state'=> 'error',
//                'message' =>'系统没有你的信息'
                'message' =>$data['U_card']
            ];
            echo json_encode($return);
            exit;
        }
        $Vinfo=$this->Wxverification_model->getuserinfo($data['U_number'],$data['U_card']);
        if($data['U_name']!=$Vinfo['V_name']){
            $return=[
                'state'=> 'error',
                'message' =>'姓名不符'
            ];
            echo json_encode($return);
            exit;
        }
        if($data['U_profession']!==$Vinfo['V_profession']){
            $return=[
                'state'=> 'error',
                'message' =>'专业不符'
            ];
            echo json_encode($return);
            exit;
        }
        if($data['U_class']!==$Vinfo['V_class']){
            $return=[
                'state'=> 'error',
                'message' =>'班级不符'
            ];
            echo json_encode($return);
            exit;
        }
        if($this->Wxverification_model->setstate($data['U_number'])){

        }
        if($this->Wxuserinfo_model->adduserinfo($data)){

            $return=[
                'state'=> 'success',
                'link' => '/url/bind'
            ];
            echo json_encode($return);
            exit;
        }







    }


}