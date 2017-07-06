<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: John D
 * Date: 7/6/2017
 * Time: 11:45 AM
 */

class WxWeChatFunction_model extends CI_Model{
    function __construct()
    {
        parent::__construct();
    }


    /**
     * @param $data
     * @return bool
     */
    public function sendFixInfoForFixUser($Foid,$Fu_openid, $comment ,$time, $address){
        $url = "http://weixin.smell.ren/fix/fixer/".$Foid;
        $datatmp = [
            "touser"=>$Fu_openid,
            "template_id"=>'Vl9mHjDrg49ifhkZAYmLBGM-zbeC3-Jz93clPmfjS2I',
            "url"=>$url,
            "topcolor"=>"#FF0000",
            "data"=>[
                'message'=>[
                    'value'=>$comment,
                    "color"=>"#173177"
                ],
                'time'=>[
                    'value'=>$time,
                    "color"=>"#173177"
                ],
                'address'=>[
                    'value'=>$address,
                    "color"=>"#173177"
                ],
            ]
        ];
        return $this->ci_wechat->sendTemplateMessage($datatmp);
    }
}