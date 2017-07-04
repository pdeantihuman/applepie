<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: henbf
 * Date: 2017/5/26
 * Time: 22:16
 */
class Set extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('Sysconfig_model');

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
     *专业和辅导员设计界面的控制器方法
     */
    public function index()
    {
        if ($this->check_is_adminer()) {
            exit;
        } else {
            $data['i'] = $this->Sysconfig_model->getInstructor();
            $data['p'] = $this->Sysconfig_model->getProfession();
            $this->load->view('admin/formsetting', $data);
        }

    }

    /**
     *添加专业
     */
    public function addp()
    {
        if ($this->check_is_adminer()) {
            exit;
        } else {
            $A_content = $this->input->post('p');
            if ($A_content == "") {
                $return = [
                    'state' => 2,
                    'message' => "不能为空",
                ];
                $return = json_encode($return);
                echo $return;
                exit;
            }
            $data = [
                'Sp_name' => $A_content
            ];
            $check = $this->Sysconfig_model->addProfession($data);
            if ($check) {
                $return = [
                    'state' => 1,
                    'message' => "添加成功",
                ];
                $return = json_encode($return);
                echo $return;
            } else {
                $return = [
                    'state' => 2,
                    'message' => "添加失败",
                ];
                $return = json_encode($return);
                echo $return;
            }
        }
    }

    /**
     *删除专业
     */
    public function delp()
    {
        if ($this->check_is_adminer()) {
            exit;
        } else {
            $Aid = $this->input->post('id');
            $check = $this->Sysconfig_model->delProfession($Aid);
            if ($check) {
                $return = [
                    'state' => 1,
                    'message' => "删除成功",
                ];
                $return = json_encode($return);
                echo $return;
            } else {
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
     *添加辅导员
     */
    public function addi()
    {
        if ($this->check_is_adminer()) {
            exit;
        } else {
            $A_content = $this->input->post('i');
            if ($A_content == "") {
                $return = [
                    'state' => 2,
                    'message' => "不能为空",
                ];
                $return = json_encode($return);
                echo $return;
                exit;
            }
            $data = [
                'Si_name' => $A_content
            ];
            $check = $this->Sysconfig_model->addInstructor($data);
            if ($check) {
                $return = [
                    'state' => 1,
                    'message' => "添加成功",
                ];
                $return = json_encode($return);
                echo $return;
            } else {
                $return = [
                    'state' => 2,
                    'message' => "添加失败",
                ];
                $return = json_encode($return);
                echo $return;
            }
        }
    }

    /**
     *删除辅导员
     */
    public function deli()
    {

        if ($this->check_is_adminer()) {
            exit;
        } else {
            $Aid = $this->input->post('id');
            $check = $this->Sysconfig_model->delInstructor($Aid);
            if ($check) {
                $return = [
                    'state' => 1,
                    'message' => "删除成功",
                ];
                $return = json_encode($return);
                echo $return;
            } else {
                $return = [
                    'state' => 2,
                    'message' => "删除失败",
                ];
                $return = json_encode($return);
                echo $return;
            }
        }

    }

}