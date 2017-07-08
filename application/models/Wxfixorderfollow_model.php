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
        $this->load->model('Wxfixorder_model');
    }


    /**
     * @param $foid
     * 根据订单的id查询订单的处理进程信息
     */
    public function getinfobyfoid($foid){
        $this->db->where('Fof_foid',$foid);
        $this->db->order_by('Fofid','DESC');
        $result = $this->db->get('fixOrderFollow')->result_array();
        return $result ? $result : false;
    }
    public function getfixlistbyresult($Fof_result){
        $this->db->order_by('Fof_time','DESC');
        $this->db->where('Fof_result',$Fof_result);
        $data = $this->db->get('fixOrderFollow')->result_array();
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
        $this->db->order_by('Fof_time','DESC');
        $this->db->limit(1);
        $this->db->select('Fof_state');
        $result = $this->db->get('fixOrderFollow')->row_array()['Fof_state'];
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
     * @param $openid
     * @return bool
     * hasProcessed返回true的条件：关于该订单，你的最后一条follow状态为2
     */
    public function hasProcessed($foid, $openid){
        $this->db->where('Fof_foid',$foid);
        $this->db->where('Fof_fuOpenId',$openid);
        $this->db->order_by('Fof_time','DESC');
        return $this->db->get('fixOrderFollow')->row_array()['Fof_state']==2;
    }


    /**
     * @param $foid
     * @param $openid
     * @return bool
     * 获得读权限的条件是openid曾是处理人
     */
    public function accessToRead($foid, $openid){
        $this->db->where('Fof_foid',$foid);
        $this->db->where('Fof_fuOpenId',$openid);
        return $this->db->get('fixOrderFollow')->num_rows()>0;
    }


    /**
     * @param $foid
     * @param $openid
     * @return bool
     * 获得控制权限的条件是，订单状态不为完成，最新的订单跟踪处理人是openid
     */
    public function accessToControl($foid, $openid){
        $this->db->where('Fof_foid',$foid);
        $this->db->order_by('Fofid','DESC');
        $data = $this->db->get('fixOrderFollow')->row_array();
        if (is_null($data)){
            return false;
        }

        else{
            if ($data['Fof_result'] == 2) {
                return false;
            } else {
                if ($openid == $data['Fof_fuOpenId']) {
                    return true;
                } else{
                    return false;
                }
            }
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
        $result = $this->db->get('fixOrderFollow')->row_array()['Fof_result'];
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

    public function accessToOrder($Fof_foid, $openid){
        $this->db->where('Fof_foid',$Fof_foid);
        $this->db->where('Fof_fuOpenId',$openid);
        $this->db->order_by('Fof_time','DESC');
        $return=$this->db->get('fixOrderFollow')->row_array()['Fof_state'];
        if (isset($return)){
            if ($return == 1)
                return true;
            else
                return false;
        }else
            return false;
    }

    public function initializeOrder($Fof_foid){
        $data = [
            'Fof_foid' => $Fof_foid,
            'Fof_fuOpenId' => 0,
            'Fof_message' => '系统收到你的报修申请'
        ];
        $this->db->insert('fixOrderFollow',$data);
        return $this->db->affected_rows()>0;
    }

    public function tranasferOut($Foid, $Fof_message,$openid){
        $date =[
            'Fof_foid' => $Foid,
            'Fof_fuOpenId' => $openid,
            'Fof_message' => $Fof_message,
            'Fof_state' => 2,
            'Fof_result' => 1
        ];
        $this->db->insert('fixOrderFollow',$date);
        return $this->db->affected_rows()>0;
    }

    public function transferIn($Foid, $openid){
        $data=[
            'Fof_fuOpenId' => $openid,
            'Fof_foid' => $Foid,
            'Fof_message' => '正在处理',
            'Fof_state'=> 1,
        ];
        $this->db->insert('fixOrderFollow',$data);
        $this->Wxfixorder_model->raisePriorityById($Foid);
        return $this->db->affected_rows()>0;
    }

    public function finishOrder($Foid, $Fof_message,$openid){
        $data = [
            'Fof_foid' => $Foid,
            'Fof_fuOpenId' => $openid,
            'Fof_message' => $Fof_message,
            'Fof_state' => 2,
            'Fof_result' =>2
        ];
        $this->db->insert('fixOrderFollow',$data);
    }
    /**
     * @param $data
     * @return bool
     * 添加维修跟踪信息
     */
    public function addfixorderfollow($data){
        $return = $this->db->insert('fixOrderFollow',$data);
        $return = $this->db->affected_rows()>0;
        return $return and $this->Wxfixorder_model->raisePriorityById($data['Fof_foid']);
    }
    public function searchFixFollowResult($startDate,$endDate)
    {
        $this->db->where('Fof_time >',$startDate);
        $this->db->where('Fof_time <',$endDate);
        $this->db->where('Fof_result','2');
        $this->db->select('Fof_fuOpenId,count(Fof_fuOpenId) as Result');
        $this->db->group_by('Fof_fuOpenId');
        return $this->db->get('fixOrderFollow')->result_array();
    }
    public function searchFixFollowReceive($startDate,$endDate){
        $this->db->where('Fof_time >',$startDate);
        $this->db->where('Fof_time <',$endDate);
        $this->db->where('Fof_state','1');
        $this->db->where('Fof_result','1');
        $this->db->select('Fof_fuOpenId,count(Fof_fuOpenId) as Receive');
        $this->db->group_by('Fof_fuOpenId');
        return $this->db->get('fixOrderFollow')->result_array();
    }
    public function searchFixFollowTrans($startDate,$endDate){
        $this->db->where('Fof_time >',$startDate);
        $this->db->where('Fof_time <',$endDate);
        $this->db->where('Fof_state','2');
        $this->db->where('Fof_result','1');
        $this->db->select('Fof_fuOpenId,count(Fof_fuOpenId) as Trans');
        $this->db->group_by('Fof_fuOpenId');
        return $this->db->get('fixOrderFollow')->result_array();
    }
}