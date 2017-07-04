<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User: 张昱
 * Date: 2017/5/26
 * Time: 23:30
 * Email: henbf@vip.qq.com
 */
class News extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Wxnews_model');
        $this->load->model('Wxnewstag_model');
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
     *帮助文档首页控制器方法
     */
    public function index()
    {
        if ($this->check_is_adminer()) {
            exit;
        } else {
            $data['tag'] = $this->Wxnewstag_model->listtag();
            $this->load->view('admin/news', $data);
        }
    }

    /**
     *查看帮助文档的文章内容
     */
    public function newslist()
    {
        if ($this->check_is_adminer()) {
            exit;
        } else {
            $data['news'] = $this->Wxnews_model->getallnews();
            $this->load->view('admin/newslist', $data);
        }
    }

    /**
     *删除文章
     */
    public function del()
    {
        if ($this->check_is_adminer()) {
            exit;
        } else {
            $id = $this->input->post('id');
            if ($id == "") {
                $return = [
                    'state' => 2,
                    'message' => "不能为空",
                ];
                $return = json_encode($return);
                echo $return;
                exit;
            }
            $check = $this->Wxnews_model->del($id);
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
     *添加文章
     */
    public function addnews()
    {
        if ($this->check_is_adminer()) {
            exit;
        } else {
            $tag = $this->input->post('fl');
            $title = $this->input->post('title');
            $content = $this->input->post('content');
            if ($tag == "") {
                $return = [
                    'state' => 2,
                    'message' => "分类不能为空",
                ];
                $return = json_encode($return);
                echo $return;
            }
            if ($title == "") {
                $return = [
                    'state' => 2,
                    'message' => "标题不能为空",
                ];
                $return = json_encode($return);
                echo $return;
            }
            if ($content == "") {
                $return = [
                    'state' => 2,
                    'message' => "内容不能为空",
                ];
                $return = json_encode($return);
                echo $return;
            }
            $data = [
                'N_name' => $title,
                'N_content' => $content,
                'N_Ntid' => $tag,
                'N_time' => time()
            ];
            if ($this->Wxnews_model->addnews($data)) {
                $return = [
                    'state' => 1,
                    'message' => "成功",
                ];
                $return = json_encode($return);
                echo $return;
            } else {
                $return = [
                    'state' => 2,
                    'message' => "失败",
                ];
                $return = json_encode($return);
                echo $return;
            }
        }
    }

    /**
     *文章分类管理
     */
    public function tagmanage()
    {
        if ($this->check_is_adminer()) {
            exit;
        } else {
            $data['tag'] = $this->Wxnewstag_model->listtag();
            $this->load->view('admin/flgl', $data);
        }
    }

    /**
     *根据文章id获取文章的内容
     */
    public function getcontent()
    {
        if ($this->check_is_adminer()) {
            exit;
        } else {
            $id = $this->uri->segment(4, 0);
            echo $this->Wxnews_model->getnewscontent($id)['N_content'];


        }
    }

    /**
     *添加分类
     */
    public function addtag()
    {
        if ($this->check_is_adminer()) {
            exit;
        } else {
            $tag = $this->input->post('tag');
            if ($tag == "") {
                $return = [
                    'state' => 2,
                    'message' => "分类不能为空",
                ];
                $return = json_encode($return);
                echo $return;
            }
            $data = [
                'Nt_name' => $tag
            ];
            if ($this->Wxnewstag_model->add($data)) {
                $return = [
                    'state' => 1,
                    'message' => "成功",
                ];
                $return = json_encode($return);
                echo $return;
            } else {
                $return = [
                    'state' => 2,
                    'message' => "失败",
                ];
                $return = json_encode($return);
                echo $return;
            }
        }
    }

    /**
     *删除分类
     */
    public function deltag()
    {
        if ($this->check_is_adminer()) {
            exit;
        } else {
            $id = $this->input->post('id');
            if ($id == "") {
                $return = [
                    'state' => 2,
                    'message' => "分类不能为空",
                ];
                $return = json_encode($return);
                echo $return;
            }
            $check = $this->Wxnewstag_model->del($id);
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