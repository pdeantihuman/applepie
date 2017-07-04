<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: henbf
 * Date: 2017/5/7
 * Time: 19:44
 */
class Test extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('CI_Wechat');
        $this->load->model('Wxreply_model');
        $this->load->model('Wxuserinfo_model');
        $this->load->model('Wxnetinfo_model');
        $this->load->model('Wxverification_model');
        $this->load->model('Wxfixorder_model');
        $this->load->model('Sysconfig_model');
        $this->load->model('Wxfixuser_model');
        $this->load->model('Wxfixorderfollow_model');
        $this->load->model('Wxadminer_model');
        $this->load->model('Wxguestbook_model');
        $this->load->model('Wxnews_model');
        $this->load->model('Wxnewstag_model');
        $this->load->library('tools');
        $this->load->model('Readexcel_model');
        $this->load->model('Wxmenu_model');
    }

    public function index(){
        echo phpinfo();
//        $data = $this->Wxreply_model->getReplay('张俊杰');
//        var_dump($data);
//        print_r($this->ci_wechat->getMenu());
//        $Vinfo=$this->Wxverification_model->setstate(1455228);
//        print_r($Vinfo);
//        $data = $this->Wxuserinfo_model->getuerinfobyopenid('oSeQ3t0MjUVaJ7kQLh_f4JWUAdx8');
//        print_r($data);

//    print_r($this->Wxfixorder_model->getorderlist('oSeQ3t0MjUVaJ7kQLh_f4JWUAdx8'));
//    if($this->Wxfixorderfollow_model->getstatebyfoid('1','oSeQ3t0MjUVaJ7kQLh_f4JWUAdx8')){
//        echo '处理过';
//    }
//    else{
//        echo '没有处理过';
//    }
//        print_r($this->Wxadminer_model->login('test','test'));
//        print_r($this->Wxuserinfo_model->listuserinfo(1));
//        echo ceil(1005/10);
//          print_r($this->Wxuserinfo_model->countGrade('16'));
//        print_r($this->Wxnetinfo_model->getstate('oSeQ3t0MjUVaJ7kQLh_f4JWUAdx8'));
//        echo substr('1651522558',0,2);
//        print_r($this->Wxguestbook_model->listGuest('1'));
//        print_r($this->Wxreply_model->listReplay());
//        print_r($this->ci_wechat->getuserinfo('oSeQ3t-jMDB7mz3uVpx1U1BfSOLc'));
//        print_r($this->Wxnewstag_model->getnamebyid('1'));
//        $data['list']=$this->Wxnewstag_model->listtag();
//        $data['news']=$this->Wxnews_model->getnewsbyid($data['list']['1']['Ntid']);
//        print_r($data);
//        $data = $this->Readexcel_model->getReadexcel('./1.xlsx');
//        echo $this->Readexcel_model->add($data);
//        echo phpinfo();
//echo                         $count = $this->Wxverification_model->countstate('1');
//        $this->load->helper('file');
//        if ( ! write_file('./upload/tmp/file.csv', $data))
//        {
//            echo 'Unable to write the file';
//        }
//        else
//        {
//            echo 'File written!';
//        }
//        unlink('./upload/tmp/file.csv');
//        echo substr('500226199310250212', 6);
//        print_r($this->Wxmenu_model->get());
//        $menu = [
//            [
//                'type' =>'view',
//                'name'=>'dd',
//                'url'=>'http://weixin.smell.ren/url/vr'
//            ],
//
//
//        ];
//        print_r($menu);
//        echo $this->Wxfixuser_model->getfixuseopenidbyfuid(1);

//        print_r($this->Wxfixorder_model->getfixlistbystatepage('3',2));

//        print_r($this->Wxfixorder_model->getfixopenidbyid('1'));
//        print_r($this->Wxfixorder_model->getfixinfobyid('1'));
    }
//    public function book($keyword){
//    print_r($this->tools->book($keyword));
//    print_r($this->tools->booknextpage($keyword,$page));


//    }





    public function arr(){

        /*现在有$a,$b,$c三个数组如下，通过整理得到如$abc这个数组*/
        $a = array('0' =>'a', '1' =>'b', '2' =>'c');
        $b = array('0' =>'a', '1' =>'b', '2' =>'c');
        $c = array('0' =>'a', '1' =>'b', '2' =>'c');
//        $abc = array(
//            '0' => array(
//                'a' =>'0',
//                'b' =>'0',
//                'c' =>'0'
//            ),
//            '1' => array(
//                'a' =>'1',
//                'b' =>'1',
//                'c' =>'1'
//            ),
//            '2' => array(
//                'a' =>'2',
//                'b' =>'2',
//                'c' =>'2'
//            ),
//        );


        for($i=0;$i<count($a);$i++){
                $abc[$i]=array('a' => $a[$i], 'b' => $b[$i], 'c' => $c[$i]);
        }
        print_r($abc);

    }
    public function book(){
//        $data = $this->tools->newbook();
        $data = $this->tools->book('php');
        print_r($data);

    }

}