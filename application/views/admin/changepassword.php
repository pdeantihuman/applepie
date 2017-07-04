<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: henbf
 * Date: 2017/5/21
 * Time: 11:33
 * 密码修改界面
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>修改密码</title>
    <link rel="stylesheet" href="/static/admin/frame/layui/css/layui.css">
    <link rel="stylesheet" href="/static/admin/css/style.css">
</head>
<body>
<div class="login-main">
    <header class="layui-elip">修改密码</header>
    <form class="layui-form">
        <div class="layui-input-inline">
            <input id="username" type="password" name="password" required lay-verify="required" placeholder="原密码" autocomplete="off" class="layui-input">
        </div>
        <div class="layui-input-inline">
            <input id="password" type="password" name="newpassword" required  lay-verify="required" placeholder="新密码" autocomplete="off" class="layui-input">
        </div>
        <div class="layui-input-inline login-btn">
            <button type="submit" class="layui-btn" lay-submit lay-filter="*">确认修改</button>
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
                url:"dochange",
                type:"post",
                data:data.field,
                dataType: "json",
                success:function (data){
                    if(data.state=="1"){
                        layer.msg(data.message, {
                            icon: 1,
                            time: 1500
                        }, function(){
//                            window.location.href=data.link;
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
