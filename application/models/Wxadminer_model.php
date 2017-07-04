<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: henbf
 * Date: 2017/5/20
 * Time: 17:37
 * 管理员信息表
 */
class Wxadminer_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }




    /**
     * @param $name
     * @param $pass
     * @return bool
     * 管理员登录验证
     */
    public function login($name, $pass){
        $this->db->where('A_name',$name);
        $this->db->where('A_pass',$pass);
        $return = $this->db->get('adminer')->row_array();
        if($return){
            return true;
        }else{
            return false;
        }
    }

    /**
     * @param $name
     * @param $newpass
     * @return bool
     * 管理员修改密码
     */
    public function changepassword($name, $newpass){
        $this->db->set('A_pass',$newpass);
        $this->db->where('A_name',$name);
        $return = $this->db->update('adminer');
        if($return){
            return true;
        }else{
            return false;
        }
    }
}