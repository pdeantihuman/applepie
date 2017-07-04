<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: henbf
 * Date: 2017/5/13
 * Time: 12:28
 */
class Wxfixuser_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * @return mixed
     * 查询所有的维修人员的姓名
     */
    public function getallfixusername(){
        $this->db->select('Fu_name');
        return $this->db->get('fixuser')->result_array();
    }
    public function getallfixuserinfo(){
        return $this->db->get('fixuser')->result_array();
    }
    public function getfixusernamebyopenid($openid){
        $this->db->where('Fu_openid',$openid);
        $this->db->select('Fu_name');
        return $this->db->get('fixuser')->row_array()['Fu_name'];
    }
    public function getopenidbyname($name){
        $this->db->where('Fu_name',$name);
        $this->db->select('Fu_openid');
        return $this->db->get('fixuser')->row_array()['Fu_openid'];
    }
    public function getfixuseopenidbyfuid($fuid){
        $this->db->where('Fuid',$fuid);
        $this->db->select('Fu_openid');
        return $this->db->get('fixuser')->row_array()['Fu_openid'];
    }

}