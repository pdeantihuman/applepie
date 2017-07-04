<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User: 张昱
 * Date: 2017/5/13
 * Time: 0:23
 * Email: henbf@vip.qq.com
 * 系统配置信息modle，包括处理专业信息，辅导员信息等
 */
class Sysconfig_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * @return mixed
     * 获取专业名称
     */
    public function getProfession(){

        return $this->db->get('sysprofession')->result_array();
    }

    /**
     * @param $data
     * @return bool
     * 添加辅导员信息
     */
    public function addProfession($data){
        $return = $this->db->insert('sysprofession',$data);
        return $return ? true : false;
    }
    /**
     * @param $Siid
     * @return bool
     * 根据专业的id删除专业名称
     */
    public function delProfession($Spid){
        $this->db->where('Spid',$Spid);
        $return = $this->db->delete('sysprofession');
        if ($return){
            return true;
        }else{
            return false;
        }
    }

    /*
     *获取辅导员姓名
     * */
    public function getInstructor(){
        return $this->db->get('sysinstructor')->result_array();
    }

    /**
     * @param $data
     * @return bool
     * 添加辅导员信息
     */
    public function addInstructor($data){
        $return = $this->db->insert('sysinstructor',$data);
        return $return ? true : false;
    }

    /**
     * @param $Siid
     * @return bool
     * 根据辅导员的id删除辅导员
     */
    public function delInstructor($Siid){
        $this->db->where('Siid',$Siid);
        $return = $this->db->delete('sysinstructor');
        if ($return){
            return true;
        }else{
            return false;
        }
    }

}