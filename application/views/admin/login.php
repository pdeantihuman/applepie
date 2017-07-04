<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: henbf
 * Date: 2017/5/14
 * Time: 11:39
 * 后台管理的登录界面
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>北京科技大学天津学院智慧校园</title>
    <link rel="stylesheet" href="/static/admin/frame/layui/css/layui.css">
    <link rel="stylesheet" href="/static/admin/css/style.css">
</head>
<body>
<div class="login-main">
    <header class="layui-elip">智慧校园微信管理</header>
    <form class="layui-form">
        <div class="layui-input-inline">
            <input id="username" type="text" name="username" required lay-verify="required" placeholder="账号" autocomplete="off" class="layui-input">
        </div>
        <div class="layui-input-inline">
            <input id="password" type="password" name="password" required  lay-verify="required" placeholder="密码" autocomplete="off" class="layui-input">
        </div>
        <div class="layui-input-inline login-btn">
            <button type="submit" class="layui-btn" lay-submit lay-filter="*">登录</button>
        </div>
    </form>
</div>
<script src="/static/admin/frame/layui/layui.js"></script>
<script type="text/javascript">
    layui.use(['form'], function () {
        var form = layui.form();
        var $ = layui.jquery;
        form.on('submit(*)',function (data) {
            $.ajax({
                url:"login",
                type:"post",
                data:data.field,
                dataType: "json",
                success:function (data){
                    if(data.state=="1"){
                        layer.msg(data.message, {
                            icon: 1,
                            time: 1500
                        }, function(){
                            window.location.href=data.link;
                        });
                    }else {
                        layer.alert(data.message);
                    }
                }
            });
            return false;
        });
    });
</script>
</body>
</html>
