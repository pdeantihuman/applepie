<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: henbf
 * Date: 2017/5/11
 * Time: 17:33
 * 开网信息表数据操作
 */
class WxNetInfo_model extends CI_Model
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
        return $result->num_rows() > 0 ;
    }

    public function applicationByOpenId($openid){
        $this->db->where('N_openid',$openid);
        $this->db->set('N_state',4);
        $this->db->update('netinfo');
        return $this->db->affected_rows()>0;
    }

    public function initializeNetInfo($openid){
        $data = [
            'N_openid' => $openid,
        ];
        $return = $this->db->insert('netinfo',$data);
        return $this->db->affected_rows()>0;
    }

    /**
     * @param $data
     * @return bool
     * 添加开网信息
     */
    public function add($data){
        $return = $this->db->insert('netinfo',$data);
        return $this->db->affected_rows()>0;
    }

    /**
     * @param $openid
     * @return bool
     * 获取开网状态
     */
    public function getInfoByOpenId($openid){
        $this->db->where('N_openid',$openid);
        $this->db->select('N_state');
        $return = $this->db->get('netinfo')->row_array();
        if($return){
            return $return;
        }else{
            return false;
        }
    }
    public function getStateByOpenId($openid){
        $this->db->where('N_openid',$openid);
        $state=$this->db->get('netinfo')->row_array()['N_state'];
        if (is_null($state))
            return 1;
        else
            return $state;
    }

    public function searchByNetState($state){
        $this->db->where('N_state',$state);
        $this->db->get('netinfo')->result_array();
    }



}