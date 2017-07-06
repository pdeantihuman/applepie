<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: henbf
 * Date: 2017/5/8
 * Time: 9:58
 * 用户信息表数据操作
 *
 */
class Wxuserinfo_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('Wxverification_model');
    }


    /**
     * @param $U_number
     * @return array
     * 根据用户学号查询与用户个人信息
     */
    public function searchbynumber($U_number){
        $this->db->where('U_number',$U_number);
        $this->db->select('Uid, U_name, U_number,U_openid, U_sex, U_profession, U_class, U_Expclass, U_class, U_instructor, U_phone, U_dormitory, U_time');
        $return = $this->db->get('userinfo')->row_array();
        if ($return){
            return $return;
        }else{
            return false;
        }
    }





    /**
     * @param $Uid
     * @return bool
     * 根据用户的Uid删除用户资料
     * 并标记为未绑定
     */
    public function del($Uid){
        $this->db->where('Uid',$Uid);
        $row = $this->db->get('userinfo')->row_array();
        $this->Wxverification_model->dismissByCard($row['U_card']);
        $this->db->where('Uid',$Uid);
        $this->db->delete('userinfo');
        return $this->db->affected_rows()>0;
    }


    /**
     * @param $page
     * @return array
     * 按照页数查看用户信息列表
     */
    public function listuserinfo($page){

        $this->db->order_by('Uid','DESC');
        $this->db->limit(10,($page-1)*10);
        $this->db->select('Uid, U_name, U_number,U_openid, U_sex, U_profession, U_class, U_Expclass, U_class, U_instructor, U_phone, U_dormitory, U_time');
        $return = $this->db->get('userinfo')->result_array();
        if($return){
            return $return;
        }else{
            return array();
        }
    }

    /**
     * @return bool|int
     * 获取所有绑定用户的数量
     */
    public function listuserinfocount(){
        $return = $this->db->count_all('userinfo');
        if($return){
            return $return;
        }else{
            return 0;
        }
    }


    /**
     * @param $openid
     * @return array
     * 根据用户的openid获取用户的绑定信息
     * 返回一维数组
     */
    public function getuerinfobyopenid($openid){
        $this->db->where('U_openid',$openid);
        $this->db->select('U_name, U_number, U_sex, U_profession, U_class, U_class, U_instructor, U_phone, U_dormitory');
        $return = $this->db->get('userinfo')->row_array();
        if($return){
            return $return;
        }else{
            return false;
        }

    }

    /**
     * @param $data
     * @return bool
     * 添加绑定用户
     */
    public function adduserinfo($data){
        $return = $this->db->insert('userinfo',$data);
        return $return ? true : false;
    }

    /**
     * @param $openid
     * @return bool
     * 判断用户的openid是否已经绑定过
     */
    public function checkuseropenid($U_openid){
        $this->db->where('U_openid', $U_openid);
        $result = $this->db->get('userinfo');
        return $result->num_rows() > 0;
    }

    /**
     * @param $number
     * @return bool
     * 检查用户的学号是否已经绑定过
     */
    public function checkusernumber($U_number){
        $this->db->where('U_number', $U_number);
        $result = $this->db->get('userinfo');
        return $result->num_rows() > 0;
    }

    /**
     * @param $card
     * @return bool
     * 检查用户的身份证号码是否已经绑定过
     */
    public function checkusercard($U_card){
        $this->db->where('U_card', $U_card);
        $result = $this->db->get('userinfo');
        return $result->num_rows() > 0;
    }

    /**
     * @param $phone
     * @return bool
     * 检查用户的手机号是否已经绑定过
     */
    public function checkuserphone($U_phone){
        $this->db->where('U_phone', $U_phone);
        $result = $this->db->get('userinfo');
        return $result->num_rows() > 0;
    }

    /**
     * @param $sex
     * @return int
     * 统计性别人数
     */
    public function countSex($sex){
        $this->db->where('U_sex',$sex);
        $this->db->from('userinfo');
        $return = $this->db->count_all_results();
        if($return){
            return $return;
        }else{
            return $return = 0;
        }
    }
    /**
     * @param $sex
     * @return int
     * 统计年级人数
     */
    public function countGrade($grade){
        $this->db->where('U_grade',$grade);
        $this->db->from('userinfo');
        $return = $this->db->count_all_results();
        if($return){
            return $return;
        }else{
            return $return = 0;
        }
    }
    public function csv(){
        $this->load->dbutil();
        $query = $this->db->query("SELECT * FROM userinfo");
        $delimiter = ",";
        $newline = "\r\n";
        $enclosure = '"';
        $data =  $this->dbutil->csv_from_result($query, $delimiter, $newline, $enclosure);
        return $data;
    }


}