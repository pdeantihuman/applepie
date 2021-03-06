<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User: 张昱
 * Date: 2017/5/30
 * Time: 19:29
 * Email: henbf@vip.qq.com
 */
class Fix extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('CI_Wechat');
        $this->load->helper('url');
        $this->load->model('Wxfixorder_model');
        $this->load->model('WxUserInfo_model');
        $this->load->model('Wxfixuser_model');
        $this->load->model('Wxfixorderfollow_model');
        $this->load->model('WxWeChatFunction_model');
    }

    /**
     * @return bool
     * 检查用户是否登录
     */
    private function check_is_adminer()
    {
        $admin = $this->session->admin;
        if (is_null($admin)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     *查看没有处理的订单列表
     */
    public function nothandlelist(){
        if($this->check_is_adminer()){
            exit;
        }else{
            $data['list'] = $this->Wxfixorder_model->getUnTreatedOrder();
            if(is_null($data['list'])){
                echo "没有需要处理的数据";
                exit;
            }
            for($i=0;$i<count($data['list']);$i++){
                $data['list'][$i]['userinfo'] = $this->WxUserInfo_model->getInfoByOpenId($data['list'][$i]['Fo_openid']);
            }
//            print_r($data['list'][0]['userinfo']);
//            exit;
            $this->load->view('admin/nohandlelist',$data);
        }
    }

    public function management(){
        if($this->check_is_adminer()){
            exit;
        }else{
            $s = '06/Oct/2011:19:00:02';
            $date = date_create_from_format('d/M/Y:H:i:s', $s);
            $date = date('Y-m-d H:i:s',$date->getTimestamp());
            $now = date('Y-m-d H:i:s',time());
//            $bigBang = date_create_from_format('Y-m-d H:i:s', '2015/10/01 00:00:01');
//            $bigBang = $bigBang->getTimestamp();
            $data['countFix'] = $this->Wxfixorderfollow_model->countFix($date,$now);
            $data['count'] = count($data['countFix']);
            $data['curr'] = 1;
            $this->load->view('admin/fixUserManagement',$data);
        }
    }

    private function transfer($id,$message ,$OutOpenId, $Fuid){
        $InOpenId = $this->Wxfixuser_model->getOpenIdById($Fuid);
        $return1= $this->Wxfixorderfollow_model->tranasferOut($id,$message,$OutOpenId);
        $return2= $this->Wxfixorderfollow_model->transferIn($id,$InOpenId);
        return $return1 and $return2;
    }
    /**
     *查看正在进行中的维修订单列表
     */
    public function handleinglist(){
        if($this->check_is_adminer()){
            exit;
        }else{
            if(!$data['list'] = $this->Wxfixorder_model->getfixlistbystate('2')){
                echo "没有需要处理的数据";
                exit;
            }
            for($i=0;$i<count($data['list']);$i++){
                $userinfo = $this->WxUserInfo_model->getInfoByOpenId($data['list'][$i]['Fo_openid']);
                $data['list'][$i]['userinfo']=$userinfo;
            }
        }$this->load->view('admin/handleinglist',$data);
    }

    /**
     * @param int $page
     * 按照页数来查看已经完成的订单信息列表
     */
    public function handleedlist($page = 1){
        if($this->check_is_adminer()){
            exit;
        }else{
            $data['list'] = $this->Wxfixorder_model->getFixOrderListByStateAndPage('3',$page);
            $data['count']=$this->Wxfixorder_model->count('3');
            $data['curr']=$page;
            for($i=0;$i<count($data['list']);$i++){
                $userinfo = $this->WxUserInfo_model->getInfoByOpenId($data['list'][$i]['Fo_openid']);
                $data['list'][$i]['userinfo']=$userinfo;
            }
        }$this->load->view('admin/handleedlist',$data);
        }


    /**
     * @param $id
     * 根据订单id查看该订单的维修记录
     */
    public function listlog($id){
        if($this->check_is_adminer()){
            exit;
        }else{
            $data['log']=$this->Wxfixorderfollow_model->getinfobyfoid($id);
            $this->load->view('admin/listlog',$data);
        }
    }

    /**
     *删除
     */
    public function del(){
        if ($this->check_is_adminer()) {
            exit;
        } else {
            $id=$this->input->post('id');
            if($id==""){
                $return = [
                    'state' => 2,
                    'message' => "不能为空",
                ];
                $return = json_encode($return);
                echo $return;
                exit;
            }
            $check=$this->Wxfixorder_model->del($id);
            if ($check) {
                $return = [
                    'state' => 1,
                    'message' => "删除成功",
                ];
                $return = json_encode($return);
                echo $return;
            }else{
                $return = [
                    'state' => 2,
                    'message' => "删除失败",
                ];
                $return = json_encode($return);
                echo $return;
            }
        }
    }

    /**
     * @param $id
     * 根据维修人员的id来确定谁去进行维修
     */
    public function choosefixer($id){
        if($this->check_is_adminer()){
            exit;
        }else{
            $data['user']=$this->Wxfixuser_model->getallfixuserinfo();
            $data['id']=$id;
            $this->load->view('admin/choosefixer',$data);
        }
    }

    /**
     *确认维修人，参数包括维修人id和需要维修的订单
     */
    public function dochoose()
    {
        if ($this->check_is_adminer()) {
            exit;
        } else {
            $Fuid = $this->input->post('id');
            $Foid = $this->input->post('fid');
            if ($this->Wxfixorderfollow_model->accessToControl($Foid, '0')) {
                if ($this->transfer($Foid, '管理员分配维修人员', '0',$Fuid)) {
                    $this->Wxfixorder_model->updatestate($Foid, '2');
                    $fixinfo = $this->Wxfixorder_model->getfixinfobyid($Foid);
                    $address = $this->WxUserInfo_model->getInfoByOpenId($fixinfo['Fo_openid'])['U_dormitory'];
                    $Fu_openid = $this->Wxfixuser_model->getOpenIdById($Fuid);
                    $this->WxWeChatFunction_model->sendFixInfoForFixUser($Foid, $Fu_openid, $fixinfo['Fo_comment'], $fixinfo['Fo_time'], $address);
                    $return = [
                        'state' => 1,
                        'message' => "成功",
                    ];
                    $return = json_encode($return);
                    echo $return;
                } else {
                    $return = [
                        'state' => 2,
                        'message' => '指定失败'
                    ];
                    $return = json_encode($return);
                    echo $return;
                }
            } else {
                $return = [
                    'state' => 2,
                    'message' => '订单已分配'
                ];
                $return =json_encode($return);
                echo $return;
            }
        }

    }

    public function api(){
        $startDate = strtotime($this->input->post('startDate'));
        $startDate = date('Y-m-d', $startDate);
        $endDate = strtotime($this->input->post('endDate'));
        $endDate= date('Y-m-d',$endDate);
        $data['countFix'] = $this->Wxfixorderfollow_model->countFix($startDate,$endDate);
        $data['count'] = count($data['countFix']);
        $this->load->view('admin/management',$data);
        $return = [
            'state' => 1,
            'message' => "查询成功",
        ];
        $return = json_encode($return);
        echo $return;
        $this->load->view('admin/fixUserManagement',$data);
    }
}