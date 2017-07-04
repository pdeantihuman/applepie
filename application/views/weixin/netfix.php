<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: henbf
 * Date: 2017/5/11
 * Time: 18:17
 */
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title>网络报修</title>
    <link rel="stylesheet" type="text/css" href="/static/css/mui.min.css" />
</head>
<body>
<div class="mui-content">
    <div class="mui-card">
        <div class="mui-card-header">报修说明</div>
        <div class="mui-card-content">
            <div class="mui-card-content-inner">
                <p>提交报修信息后，会有维修人员到宿舍维修。如果问题，请直接在微信公众号留言！</p>
                <p>提交报修信息后，会有维修人员到宿舍维修。如果问题，请直接在微信公众号留言！</p>
                <p>提交报修信息后，会有维修人员到宿舍维修。如果问题，请直接在微信公众号留言！</p>
                <p>提交报修信息后，会有维修人员到宿舍维修。如果问题，请直接在微信公众号留言！</p>
                <p>提交报修信息后，会有维修人员到宿舍维修。如果问题，请直接在微信公众号留言！</p>
                <p>提交报修信息后，会有维修人员到宿舍维修。如果问题，请直接在微信公众号留言！</p>
            </div>
        </div>
    </div>
    <div class="mui-content-padded">
        <button id="upload" type="button" class="mui-btn mui-btn-primary mui-btn-block">网络报修</button>
        <button id="my" type="button" class="mui-btn mui-btn-success mui-btn-block">我的报修</button>
    </div>
</div>
</body>
<script type="text/javascript" src="/static/js/mui.min.js" ></script>
<script>
    var addurl = '<?php $url =base_url('fix/api');echo "http://$url";?>';
    var btn = document.getElementById("upload");
    btn.addEventListener("tap",function(enent) {
        mui.post(addurl,{
            key:'fix'
            },function(data){
                if(data.state === 'success'){
                    window.location.href=data.link;

                }else{
                    mui.alert(data.message,"注意","确定");
                }


            },'json'
        );

    });
    var btn = document.getElementById("my");
    btn.addEventListener("tap",function(enent) {
        mui.post(addurl,{
                key:'fixlist'
            },function(data){
                if(data.state === 'success'){
                    window.location.href=data.link;

                }else{
                    mui.alert(data.message,"注意","确定");
                }


            },'json'
        );
    });
</script>
</html>
