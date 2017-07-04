<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User: 张昱
 * Date: 2017/5/30
 * Time: 10:39
 * Email: henbf@vip.qq.com
 * 用户数据的导入导出操作控制器
 */
class Datacontrol extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->database();
        $this->load->helper('url');
        $this->load->model('Readexcel_model');
        $this->load->model('Wxverification_model');
        $this->load->model('Wxuserinfo_model');
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
     *数据操作页面的控制器主方法
     */
    public function index()
    {
        if ($this->check_is_adminer()) {
            exit;
        } else {
            $this->load->view('admin/data');
        }
    }

    /**
     *下载没有绑定的用户数据
     */
    public function down()
    {
        if ($this->check_is_adminer()) {
            exit;
        } else {
            $data = $this->Wxverification_model->csv();
            $this->load->helper('download');
            $name = 'nobind.txt';
            force_download($name, $data);
        }
    }

    /**
     *下载已经绑定了的用户数据
     */
    public function downbind()
    {
        if ($this->check_is_adminer()) {
            exit;
        } else {
            $data = $this->Wxuserinfo_model->csv();
            $this->load->helper('download');
            $name = 'bind.txt';
            force_download($name, $data);
        }
    }

    /**
     *上传验证数据
     */
    public function upload()
    {
        if ($this->check_is_adminer()) {
            exit;
        } else {
            $config['upload_path'] = './upload/tmp/';
            $config['allowed_types'] = 'xlsx';
            $config['max_size'] = '100';
            $config['file_name'] = uniqid();
            $this->load->library('upload', $config);
            $check = $this->upload->do_upload('upfile');
            if ($check) {
                $uploadinfo = $this->upload->data();
                $file_name = $uploadinfo['file_name'];
                $filepath = "./upload/tmp/$file_name";
                $data = $this->Readexcel_model->getReadexcel($filepath);
                if ($data) {
                    $return = $this->Wxverification_model->add($data);
                    if ($return) {
                        $count = $this->Wxverification_model->countstate('1');
                        $return = [
                            'state' => 1,
                            'message' => "$count" . "数据上传成功",
                        ];
                        $return = json_encode($return);
                        echo $return;
                        exit;
                    } else {
                        $return = [
                            'state' => 2,
                            'message' => "数据上传失败，请联系管理员",
                        ];
                        $return = json_encode($return);
                        echo $return;
                        exit;
                    }
                } else {
                    $return = [
                        'state' => 2,
                        'message' => "上传的文件格式不符合要求，请重新下载模板填写数据",
                    ];
                    $return = json_encode($return);
                    echo $return;
                    exit;
                }
            } else {
                $return = [
                    'state' => 2,
                    'message' => "上传的文件格式不正确",
                ];
                $return = json_encode($return);
                echo $return;
                exit;
            }
        }
    }


}