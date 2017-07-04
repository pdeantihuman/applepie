<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User: 张昱
 * Date: 2017/5/25
 * Time: 23:23
 * Email: henbf@vip.qq.com
 */
class Wxnews_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * @param $N_Ntid
     * @return bool
     * 根据分类id查看该分类id下面所有的文章
     */
    public function listnewstitle($N_Ntid){
        $this->db->where('N_Ntid',$N_Ntid);
        $this->db->order_by('Nid','DESC');
        $this->db->select('Nid, N_name');
        $return = $this->db->get('news')->result_array();
        if($return){
            return $return;
        }else{
            return false;
        }
    }

    /**
     * @param $id
     * @return bool
     * 根据文章id查看该文章的所有信息
     */
    public function getnewsbyid($id){
        $this->db->where('Nid',$id);
        $this->db->select('N_name, N_content,N_time,N_Ntid');
        $return = $this->db->get('news')->row_array();
        if($return){
            return $return;
        }else{
            return false;
        }
    }

    /**
     * @param $Nid
     * @return bool
     * 根据文章id删除文章
     */
    public function del($Nid){
        $this->db->where('Nid',$Nid);
        $return = $this->db->delete('news');
        if ($return){
            return true;
        }else{
            return false;
        }
    }

    /**
     * @param $id
     * @return bool
     * 根据文章id获取文章的内容
     */
    public function getnewscontent($id){
        $this->db->where('Nid',$id);
        $this->db->select('N_content');
        $return = $this->db->get('news')->row_array();
        if($return){
            return $return;
        }else{
            return false;
        }
    }

    /**
     * @return bool
     * 获取所有的文章，返回文章id和文章名
     */
    public function getallnews(){
        $this->db->select('Nid,N_name');
        $return = $this->db->get('news')->result_array();
        if($return){
            return $return;
        }else{
            return false;
        }
    }

    /**
     * @param $data
     * @return bool
     * 添加文章
     */
    public function addnews($data){
        $return = $this->db->insert('news',$data);
        if($return){
            return true;
        }else{
            return false;
        }
    }
}