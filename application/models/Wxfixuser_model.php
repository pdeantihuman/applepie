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
        return $this->db->get('fixUser')->result_array();
    }
    public function getallfixuserinfo(){
        return $this->db->get('fixUser')->result_array();
    }

    public function getAllUserNameExceptSelf($Fu_openid){
        $this->db->select('Fu_openid');
        $this->db->where('Fu_openid !=',$Fu_openid,false);
        return $this->db->get('fixUser')->result_array;
    }

    /**
     * 通过维修人员openid获取维修人员姓名
     * @param $openid
     * @return mixed
     */
    public function getNameByOpenId ($openid){
        $this->db->where('Fu_openid',$openid);
        return $this->db->get('fixUser')->row_array()['Fu_name'];
    }


    /**
     * 通过维修人员姓名获取维修人员openid
     * @param $name
     * @return mixed
     */
    public function getOpenIdByName($name){
        $this->db->where('Fu_name',$name);
        $this->db->select('Fu_openid');
        return $this->db->get('fixUser')->row_array()['Fu_openid'];
    }


    /**
     * 通过fuid获取维修人员openid
     * @param $fuid
     * @return mixed
     */
    public function getOpenIdById($fuid){
        $this->db->where('Fuid',$fuid);
        $this->db->select('Fu_openid');
        return $this->db->get('fixUser')->row_array()['Fu_openid'];
    }

    /**
     * @param $openid
     * @return bool
     * 判断该openid是否为维修人员
     */
    public function checkFixUserByOpenId($openid){
        $this->db->where('Fu_openid',$openid);
        return $this->db->get('fixUser')->num_rows()>0;
    }

}