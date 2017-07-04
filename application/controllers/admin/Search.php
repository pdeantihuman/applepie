<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: henbf
 * Date: 2017/5/22
 * Time: 16:04
 */
class Search extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('Wxuserinfo_model');
        $this->load->model('Wxnetinfo_model');
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


    public function searchbynumber(){
        $number = $this->uri->segment(4, 0);
        if ($this->check_is_adminer()) {
            exit;
        } else {
            if($number == "0"){
                show_404();
                exit;
            }
            $return=$this->Wxuserinfo_model->searchbynumber($number);
            if(!$return){
                show_404();
                exit;
            }
            $data['userinfo']=$return;
            $data['userinfo']['state']=$this->Wxnetinfo_model->getstate($data['userinfo']['U_openid'])['N_state'];
            $this->load->view('admin/searchuser',$data);
        }
    }
}