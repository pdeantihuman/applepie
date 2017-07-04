<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: henbf
 * Date: 2017/5/7
 * Time: 19:39
 * 微信自动回复相关的数据处理
 */
class Wxreply_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * @param $keyword
     * @return mixed
     * 通过查询关键字，返回自动回复的文本消息
     */
    public function getReplay($keyword){
        $this->db->where('A_keyword',$keyword);
        $this->db->select('A_content');
        $return = $this->db->get('autoreply')->row_array()['A_content'];
        return $return;
    }

    /**
     * @return bool
     * 获取所有自动回复
     */
    public function listReplay(){
        $this->db->order_by('Aid','DESC');
        $return = $this->db->get('autoreply')->result_array();
        if($return){
            return $return;
        }else{
            return false;
        }
    }
    public function add($data){
        $return = $this->db->insert('autoreply',$data);
        return $return ? true : false;
    }

    public function del($Aid){
        $this->db->where('Aid',$Aid);
        $return = $this->db->delete('autoreply');
        if ($return){
            return true;
        }else{
            return false;
        }
    }

}