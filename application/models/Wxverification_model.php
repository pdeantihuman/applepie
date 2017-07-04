<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: henbf
 * Date: 2017/5/8
 * Time: 12:59
 * 绑定验证对比信息数据操作
 */
class Wxverification_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * @param $number
     * @param $card
     * @return bool
     * 根据学号和身份证号码，获取验证用户信息
     */
    public function getuserinfo($number, $card){
        $this->db->where('V_number',$number);
        $this->db->where('V_card',$card);
        $this->db->select('V_name, V_profession, V_class, V_state');
        $result = $this->db->get('verification')->row_array();
        if($result){
            return $result;
        }else{
            return false;
        }
    }

    /**
     * @param $number
     * @return bool
     * 根据学号修改验证用户数据表中的验证状态
     */
    public function setstate($number){
        $this->db->set('V_state','2');
        $this->db->where('V_number',$number);
        $return = $this->db->update('verification');
        return $return ? true : false;
    }

    /**
     * @param $data
     * @return bool
     * 先清空验证用户数据表，然后给验证用户数据表添加数据
     */
    public function add($data){
        $this->db->empty_table('verification');
        $return = $this->db->insert_batch('verification', $data);
        if($return){
            return true;
        }else{
            return false;
        }
    }

    /**
     * @param $state
     * @return int
     * 根据状态id统计数量
     */
    public function countstate($state){
        $this->db->where('V_state',$state);
        $this->db->from('verification');
        $return = $this->db->count_all_results();
        if($return){
            return $return;
        }else{
            return $return = 0;
        }
    }

    /**
     * @return mixed
     * 获取未绑定用户的数据到txt
     */
    public function csv(){
        $this->load->dbutil();
        $query = $this->db->query("SELECT V_name,V_number,V_card,V_profession,V_class FROM verification WHERE V_state = 1");
        $delimiter = ",";
        $newline = "\r\n";
        $enclosure = '"';
        $data =  $this->dbutil->csv_from_result($query, $delimiter, $newline, $enclosure);
        return $data;
    }



}