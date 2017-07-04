<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: henbf
 * Date: 2017/5/21
 * Time: 20:06
 * 罗列信息控制器
 */
class Listdata extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->library('CI_Wechat');
        $this->load->model('Wxuserinfo_model');
        $this->load->model('Wxnetinfo_model');
        $this->load->model('Wxguestbook_model');
        $this->load->model('Wxreply_model');
        $this->load->model('Wxverification_model');
    }

    /**
     * @return bool
     * 检查用户是否登录
     */
    private function check_is_adminer()
    {
        $admin = $this->session->admin;
        if (is_null($admin)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     *后台管理登录判断
     */
    public function listuserinfo($page = 1)
    {
        if ($this->check_is_adminer()) {
            exit;
        } else {
            $data['listuserinfo'] = $this->Wxuserinfo_model->listuserinfo($page);
            for($i=0;$i<count($data['listuserinfo']);$i++){
                $data['listuserinfo'][$i]['state']=$this->Wxnetinfo_model->getstate($data['listuserinfo'][$i]['U_openid'])['N_state'];
            }
            $data['count'] = $this->Wxuserinfo_model->listuserinfocount();
            $data['curr'] = $page;
            $this->load->view('admin/bindeduser', $data);
        }
    }

    /**
     *删除已绑定人员信息的操作
     */
    public function del()
    {

        if ($this->check_is_adminer()) {
            exit;
        } else {
                $Uid=$this->input->post('id');
            $check=$this->Wxuserinfo_model->del($Uid);
            if ($check) {
                $return = [
                    'state' => 1,
                    'message' => "删除成功",
                ];
                $return = json_encode($return);
                echo $return;
            }else{
                $return = [
                    'state' => 2,
                    'message' => "删除失败",
                ];
                $return = json_encode($return);
                echo $return;
            }
        }
    }


    /**
     *删除留言信息的方法
     */
    public function delguest()
    {

        if ($this->check_is_adminer()) {
            exit;
        } else {
            $gid=$this->input->post('id');
            $check=$this->Wxguestbook_model->del($gid);
            if ($check) {
                $return = [
                    'state' => 1,
                    'message' => "删除成功",
                ];
                $return = json_encode($return);
                echo $return;
            }else{
                $return = [
                    'state' => 2,
                    'message' => "删除失败",
                ];
                $return = json_encode($return);
                echo $return;
            }
        }
    }


    /**
     *数据可视化
     */
    public function map(){
        if ($this->check_is_adminer()) {
            exit;
        } else {
            $data['man']=$this->Wxuserinfo_model->countSex('男');
            $data['woman']=$this->Wxuserinfo_model->countSex('女');
            $data['garde14']=$this->Wxuserinfo_model->countGrade('14');
            $data['garde15']=$this->Wxuserinfo_model->countGrade('15');
            $data['garde16']=$this->Wxuserinfo_model->countGrade('16');
            $data['nobinded']=$this->Wxverification_model->countstate('1');
            $data['binded']=$this->Wxverification_model->countstate('2');
            $this->load->view('admin/statistics',$data);
        }

    }


    /**
     * @param int $page
     * 根据分页查看留言信息
     */
    public function guestbook($page=1){
        if ($this->check_is_adminer()) {
            exit;
        } else {
            $data['list'] = $this->Wxguestbook_model->listGuest($page);
            for($i=0;$i<count($data['list']);$i++){
                $name = $this->Wxuserinfo_model->getuerinfobyopenid($data['list'][$i]['g_openid']);
                if($name){
                    $name=$name['U_name'];
                }else{
                    $name = $this->ci_wechat->getuserinfo($data['list'][$i]['g_openid'])['nickname'];

                }
                $data['list'][$i]['name']=$name;
            }
            $data['count'] = $this->Wxguestbook_model->count();
            $data['curr'] = $page;
            $this->load->view('admin/guestbook',$data);
        }
    }


    /**
     *自动回复的控制器
     */
    public function autoreply(){
        if ($this->check_is_adminer()) {
            exit;
        }else{
            $data['list'] = $this->Wxreply_model->listReplay();
            $this->load->view('admin/autoreply',$data);
        }
    }


    /**
     *删除自动回复
     */
    public function delautoreply()
    {

        if ($this->check_is_adminer()) {
            exit;
        } else {
            $Aid=$this->input->post('id');
            $check=$this->Wxreply_model->del($Aid);
            if ($check) {
                $return = [
                    'state' => 1,
                    'message' => "删除成功",
                ];
                $return = json_encode($return);
                echo $return;
            }else{
                $return = [
                    'state' => 2,
                    'message' => "删除失败",
                ];
                $return = json_encode($return);
                echo $return;
            }
        }
    }

    /**
     *添加自动回复
     */
    public function addautoreply()
    {

        if ($this->check_is_adminer()) {
            exit;
        } else {
            $A_keyword=$this->input->post('keyword');
            $A_content=$this->input->post('content');
            if($A_keyword ==""){
                $return = [
                    'state' => 2,
                    'message' => "关键词不能为空",
                ];
                $return = json_encode($return);
                echo $return;
                exit;
            }
            if($A_content ==""){
                $return = [
                    'state' => 2,
                    'message' => "回复内容不能为空",
                ];
                $return = json_encode($return);
                echo $return;
                exit;
            }
            $data = [
                'A_keyword' => $A_keyword,
                'A_content' => $A_content
            ];
            $check=$this->Wxreply_model->add($data);
            if ($check) {
                $return = [
                    'state' => 1,
                    'message' => "添加成功",
                ];
                $return = json_encode($return);
                echo $return;
            }else{
                $return = [
                    'state' => 2,
                    'message' => "添加失败",
                ];
                $return = json_encode($return);
                echo $return;
            }
        }
    }





}