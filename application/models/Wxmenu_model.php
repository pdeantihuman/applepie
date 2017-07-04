<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User: 张昱
 * Date: 2017/5/30
 * Time: 17:42
 * Email: henbf@vip.qq.com
 */
class Wxmenu_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get(){
        $this->db->select('type,name,url');
        return $this->db->get('menu')->result_array();
    }
    public function getall(){
        return $this->db->get('menu')->result_array();
    }
    public function del($Mid){
        $this->db->where('Mid',$Mid);
        $return = $this->db->delete('menu');
        if ($return){
            return true;
        }else{
            return false;
        }
    }
    public function add($data){
        $return = $this->db->insert('menu',$data);
        if($return){
            return true;
        }else{
            return false;
        }
    }
}