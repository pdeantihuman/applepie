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
        $this->load->model('WxUserInfo_model');
        $this->load->model('WxNetInfo_model');
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
//    public function searchByNetState($state){
//        $this->db->where('U_number',$state);
//        $this->db->select('Uid, U_name, U_number,U_openid, U_sex, U_profession, U_class, U_Expclass, U_class, U_instructor, U_phone, U_dormitory, U_time');
//        $return = $this->db->get('netinfo')->row_array();
//        if ($return){
//            return $return; TODO: 需要一个根据开网状态查询的函数
//        }else{
//            return false;
//        }
//    }

    public function searchbynumber(){
        $number = $this->uri->segment(4, 0);
        if ($this->check_is_adminer()) {
            exit;
        }// else {
//            if($number == "0"){//TODO:假如用户输入的数据错误，应该显示提示信息，而不是转404
//                show_404();
//                exit;
//            }
            $return=$this->WxUserInfo_model->searchbynumber($number);
//            if(!$return){
 //               show_404();TODO:假如用户没有查询到数据，应该显示提示信息，而不是转404
//                exit;
//            }
            $data['userinfo']=$return;
            $data['userinfo']['state']=$this->WxNetInfo_model->getInfoByOpenId($data['userinfo']['U_openid'])['N_state'];
            $this->load->view('admin/searchuser',$data);
        }
    }
