<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User: 张昱
 * Date: 2017/5/27
 * Time: 0:01
 * Email: henbf@vip.qq.com
 */
class Wxnewstag_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    public function add($data){
        $return = $this->db->insert('newstag',$data);
        return $return ? true : false;
    }
    public function del($Ntid){
        $this->db->where('Ntid',$Ntid);
        $return = $this->db->delete('newstag');
        if ($return){
            return true;
        }else{
            return false;
        }
    }
    public function listtag(){
        return $this->db->get('newstag')->result_array();
    }
    public function getnamebyid($id){
        $this->db->where('Ntid',$id);
        $this->db->select('Nt_name');
        $return=$this->db->get('newstag')->row_array();
        if ($return){
            return $return;
        }else{
            return false;
        }

    }


}