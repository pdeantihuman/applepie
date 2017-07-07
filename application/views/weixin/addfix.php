<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * User: 张昱
 * Date: 2017/5/12
 * Time: 0:08
 * Email: henbf@vip.qq.com
 */
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">

    <!--标准mui.css-->
    <link rel="stylesheet" href="/static/css/mui.min.css">


</head>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>wx.config({});wx.ready(function(){wx.hideOptionMenu();});</script>
<body>


    <div class="mui-content" style="margin-top: 50px;">



        <form class="mui-input-group">
        <div class="mui-input-row">
            <label>类型</label>
            <select class="mui-select" id="type">
                <option value="">---请选择---</option>
                <option>插上网线没有反应</option>
                <option>提示系统有代理</option>
                <option>网络故障</option>
                <option>网速太慢</option>
                <option>其他</option>
            </select>
        </div>
        </form>




            <div class="mui-input-row" style="margin: 10px 5px;">
                <textarea id="content" rows="5" placeholder="请描述你所遇到的问题"></textarea>
            </div>


        <div class="mui-button-row">
            <button id="btn" type="button" class="mui-btn mui-btn-primary">提交</button>
        </div>



    </div>

<script src="/static/js/mui.min.js"></script>
<script>
    mui.init({
        swipeBack:true //启用右滑关闭功能
    });
    var addurl = '<?php $url =base_url('fix/api');echo "http://$url";?>';
    var type = document.getElementById("type");
    var content = document.getElementById("content");
    var btn = document.getElementById("btn");
    btn.addEventListener("tap",function(enent) {
        var info = {
            type : type.value,
            content : content.value
        };
        if (info.type == "") {
            mui.toast('请选择报修类型',{ duration:'long', type:'div' });
            return;
        }
        if (info.content == "") {
            mui.toast('请填写描述信息',{ duration:'long', type:'div' });
            return;
        }
        mui.post(addurl,{
                key:"addfix",
                type:info.type,
                content:info.content
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
</body>

</html>
