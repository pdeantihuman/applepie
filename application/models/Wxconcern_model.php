<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User: 张昱
 * Date: 2017/5/8
 * Time: 0:26
 * Email: henbf@vip.qq.com
 * 用户对关注了公众号的时间进行记录
 */
class Wxconcern_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    /**
     *用户动作
     */
    public function action($data){
        $return = $this->db->insert('concern',$data);
        return $return ? true : false;
    }
}