<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: henbf
 * Date: 2017/5/13
 * Time: 13:20
 */
class Wxfixorderfollow_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    /**
     * @param $foid
     * 根据订单的id查询订单的处理进程信息
     */
    public function getinfobyfoid($foid){
        $this->db->where('Fof_foid',$foid);
        $this->db->order_by('Fof_time','DESC');
        $result = $this->db->get('fixorderfollow')->result_array();
        return $result ? $result : false;
    }
    public function getfixlistbyresult($Fof_result){
        $this->db->order_by('Fof_time','DESC');
        $this->db->where('Fof_result',$Fof_result);
        $data = $this->db->get('fixorderfollow')->result_array();
        if($data){
            return $data;
        }else{
            return false;
        }
    }

    /**
     * @param $foid
     * @param $openid
     * @return bool
     * 查看维修人员对这条订单的状态，如果已经修改过了，就不允许修改
     */
    public function getstatebyfoid($foid, $openid){
        $this->db->where('Fof_foid', $foid);
        $this->db->where('Fof_fuopenid', $openid);
        $this->db->order_by('Fofid','DESC');
        $this->db->limit(1);
        $this->db->select('Fof_state');
        $result = $this->db->get('fixorderfollow')->row_array()['Fof_state'];
        switch ($result){
            case 1:
                return false;
                break;
            case 2:
                return true;
                break;
            default:
                return true;
                break;
        }
    }

    /**
     * @param $foid
     * @return bool
     * 检查订单的状态
     */
    public function getresult($foid){
        $this->db->where('Fof_foid', $foid);
        $this->db->order_by('Fofid','DESC');
        $this->db->limit(1);
        $this->db->select('Fof_result');
        $result = $this->db->get('fixorderfollow')->row_array()['Fof_result'];
        switch ($result){
            case 1:
                return false;
                break;
            case 2:
                return true;
                break;
            default:
                return true;
                break;
        }
    }

    /**
     * @param $data
     * @return bool
     * 添加维修跟踪信息
     */
    public function addfixorderfollow($data){
        $return = $this->db->insert('fixorderfollow',$data);
        return $return ? true : false;
    }

}