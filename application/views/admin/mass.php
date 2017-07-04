<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * User: 张昱
 * Date: 2017/5/24
 * Time: 23:38
 * Email: henbf@vip.qq.com
 * 群发消息编辑界面
 */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>群发消息</title>
    <link rel="stylesheet" href="/static/admin/frame/layui/css/layui.css">
    <link rel="stylesheet" href="/static/admin/css/style.css">
</head>
<body class="body">
<div class="layui-input-label">
    <textarea id="c" placeholder="请输入群发内容" class="layui-textarea"></textarea>
</div>
<button class="layui-btn fr" lay-submit="" lay-filter="*">群发</button>
<script type="text/javascript" src="/static/admin/frame/layui/layui.js"></script>
<script type="text/javascript">
    layui.use(['layer','form'], function () {
        var $ = layui.jquery;
        var layer = layui.layer;
        var form = layui.form();
        form.on('submit(*)', function(){
        layer.confirm('确认是否发送', {icon: 3, title:'提示'}, function(index){
            var c = document.getElementById('c').value;
            $.ajax({
                url:"/admin/weixin/domass",
                type:"post",
                data:{
                    content:c
                },
                dataType: "json",
                success:function (data){
                    if(data.state=="1"){
                        layer.msg(data.message, {
                            icon: 1,
                            time: 1000
                        }, function(){
                            location.reload();
                        });
                    }else {
                        layer.alert(data.message);
                    }
                }
            });
            layer.close(index);
        });
        });
    });
</script>
</body>
</html>
