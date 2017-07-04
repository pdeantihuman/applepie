<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User: 张昱
 * Date: 2017/5/11
 * Time: 23:27
 * Email: henbf@vip.qq.com
 */
class Wxfixorder_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * @param $openid
     * @return bool
     * 获取当前用户的最新一条报修记录的状态信息
     */
    public function getNewestorder($openid){
        $this->db->where('Fo_openid', $openid);
        $this->db->order_by('Foid','DESC');
        $this->db->limit(1);
        $this->db->select('Fo_state');
        $result = $this->db->get('fixorder')->row_array()['Fo_state'];
        return $result != 3 ? (is_null($result) ? true : (false)) : (is_null($result) ? true : (true));
    }

    /**
     * @param $data
     * @return bool
     * 添加一条报修信息
     */
    public function add($data){
        $return = $this->db->insert('fixorder',$data);
        return $return ? true : false;
    }


    /**
     * @param $openid
     * @return mixed
     * 获取用户的最新一条维修记录
     */
    public function getNeworder($openid){
        $this->db->where('Fo_openid',$openid);
        $this->db->order_by('Foid','DESC');
        $this->db->limit(1);
        $this->db->select('Fo_time,Fo_type,Fo_state,Fo_content');
        $result = $this->db->get('fixorder')->row_array();
        return $result;

    }
    /*
     * 获取用户的维修记录列表
     * */
    public function getorderlist($openid){
        $this->db->where('Fo_openid',$openid);
        $this->db->order_by('Foid','DESC');
        $this->db->select('Fo_time,Fo_state,Foid');
        $result = $this->db->get('fixorder')->result_array();
        return $result;
    }

    /**
     * @param $id
     * @return mixed
     * 根据id获取维修记录的信息
     */
    public function getfixlistbyid($id,$openid){
        $this->db->where('Foid',$id);
        $this->db->where('Fo_openid',$openid);
        $this->db->select('Fo_time,Fo_type,Fo_state,Fo_content');
        $result = $this->db->get('fixorder')->row_array();
        return $result ? $result : false;
    }

    /**
     * @param $id
     * @return bool
     * 根据id获取openid
     */
    public function getfixopenidbyid($id){
        $this->db->where('Foid',$id);
        $this->db->select('Fo_openid');
        $result=$this->db->get('fixorder')->row_array()['Fo_openid'];
        return $result ? $result : false;
    }

    /**
     * @param $id
     * @return bool
     * 根据id获取订单的维修详情
     */
    public function getfixinfobyid($id){
        $this->db->where('Foid',$id);
        $result=$this->db->get('fixorder')->row_array();
        return $result ? $result : false;
    }

    /**
     * @param $id
     * @param $state
     * 根据订单id修改订单的当前状态
     */
    public function updatestate($id, $state){
        $this->db->where('Foid',$id);
        $data = [
            'Fo_state' => $state
        ];
        $this->db->update('fixorder',$data);
    }

    /**
     * @param $state
     * @return bool
     * 根据订单状态查询订单信息
     */
    public function getfixlistbystate($state){
        $this->db->order_by('Fo_time','DESC');
        $this->db->where('Fo_state',$state);
        $data = $this->db->get('fixorder')->result_array();
        if($data){
            return $data;
        }else{
            return false;
        }
    }


    /**
     * @param $state
     * @param $page
     * @return bool
     * 根据状态和页数查看订单数据列表
     */
    public function getfixlistbystatepage($state, $page){
        $this->db->order_by('Fo_time','DESC');
        $this->db->limit(10,($page-1)*10);
        $this->db->where('Fo_state',$state);
        $data = $this->db->get('fixorder')->result_array();
        if($data){
            return $data;
        }else{
            return false;
        }
    }

    /**
     * @param $state
     * @return bool|int
     * 根据维修订单的状态统计该状态下的订单数量
     */
    public function count($state){
        $this->db->where('Fo_state',$state);
        $return = $this->db->count_all_results('fixorder');
        if($return){
            return $return;
        }else{
            return false;
        }
    }

    /**
     * @param $Foid
     * @return bool
     * 根据订单id删除订单
     */
    public function del($Foid){
        $this->db->where('Foid',$Foid);
        $return = $this->db->delete('fixorder');
        if ($return){
            return true;
        }else{
            return false;
        }
    }

}