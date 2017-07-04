<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: henbf
 * Date: 2017/5/11
 * Time: 17:33
 * 开网信息表数据操作
 */
class Wxnetinfo_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    /**
     * @param $openid
     * @return bool
     * 判断用户openid检查是否已经申请过
     */
    public function checkuseropenid($openid){
        $this->db->where('N_openid', $openid);
        $result = $this->db->get('netinfo');
        return $result->num_rows() > 0 ? true : false;
    }


    /**
     * @param $data
     * @return bool
     * 添加开网信息
     */
    public function add($data){
        $return = $this->db->insert('netinfo',$data);
        return $return ? true : false;
    }

    /**
     * @param $openid
     * @return bool
     * 获取开网状态
     */
    public function getstate($openid){
        $this->db->where('N_openid',$openid);
        $this->db->select('N_state');
        $return = $this->db->get('netinfo')->row_array();
        if($return){
            return $return;
        }else{
            return false;
        }
    }
    public function get_net_state($openid){
        $this->db->where('N_openid',$openid);
        $this->db->select('N_state');
        $state=$this->db->get('netinfo')->row_array()['N_state'];
        if($state!=2){
            return false;
        }else{
            return true;
        }
    }



}