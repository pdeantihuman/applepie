<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: henbf
 * Date: 2017/5/7
 * Time: 20:27
 */
class Wxguestbook_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function addGuestbook($data){
        $return = $this->db->insert('guestbook',$data);
        return $return ? true : false;
    }
    public function listGuest($page){

        $this->db->order_by('gid','DESC');
        $this->db->limit(10,($page-1)*10);
        $return = $this->db->get('guestbook')->result_array();
        if($return){
            return $return;
        }else{
            return false;
        }
    }


    /**
     * @param $gid
     * @return bool
     * 根据用户的gid删除留言
     */
    public function del($Uid){
        $this->db->where('gid',$Uid);
        $return = $this->db->delete('guestbook');
        if ($return){
            return true;
        }else{
            return false;
        }
    }

    public function count(){
        $return = $this->db->count_all('guestbook');
        if($return){
            return $return;
        }else{
            return false;
        }
    }
}