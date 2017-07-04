<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: henbf
 * Date: 2017/5/11
 * Time: 17:51
 */

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title></title>
    <link rel="stylesheet" type="text/css" href="/static/css/mui.min.css" />
</head>
<body>
<div class="mui-content">
    <div class="mui-card">
        <div class="mui-card-header">开网注意事项：</div>
        <div class="mui-card-content">
            <div class="mui-card-content-inner">
<!--                开网提示信息-->
                <p>这里是开网的注意事项。开网协议！！！！！</p>
                <p>这里是开网的注意事项。开网协议！！！！！</p>
                <p>这里是开网的注意事项。开网协议！！！！！</p>
                <p>这里是开网的注意事项。开网协议！！！！！</p>
                <p>这里是开网的注意事项。开网协议！！！！！</p>
                <p>这里是开网的注意事项。开网协议！！！！！</p>
                <p>这里是开网的注意事项。开网协议！！！！！</p>
            </div>
        </div>
    </div>
    <div class="mui-content-padded">
        <button id="btnid" type="button" class="mui-btn mui-btn-primary mui-btn-block">申请开网</button>
    </div>
</div>
<footer  class="mui-bar mui-bar-footer">
    <p align="center" style="margin-top: 15px;">
        © 2017 北京科技大学天津学院智慧校园
    </p>
</footer >
</body>
<script type="text/javascript" src="/static/js/mui.min.js" ></script>
<script>
    var addurl = '<?php $url =base_url('net/api');echo "http://$url";?>';
    var btn = document.getElementById("btnid");
    btn.addEventListener("tap",function(enent) {
        mui.post(addurl,{
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
