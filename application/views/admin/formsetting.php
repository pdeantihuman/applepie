<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: henbf
 * Date: 2017/5/26
 * Time: 22:07
 * 专业信息和辅导员信息的设置
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title></title>
    <link rel="stylesheet" href="/static/admin/frame/layui/css/layui.css">
    <link rel="stylesheet" href="/static/admin/css/style.css">
</head>
<body class="body">
<div style="width: 48%;height:auto;float:left;">
    <table class="layui-table">
        <thead>
        <tr>

            <th width="auto">专业名称</th>
            <th width="7%">操作</th>
        </tr>
        </thead>
        <tbody>
        <tr>

            <td><input id="p" type="text" name="content" placeholder="专业名称" class="layui-input"></td>
            <td><button class="layui-btn layui-btn-small layui-btn-normal"onclick="addp()">添加</button></td>
        </tr>
        <?php foreach ($p as $data): ?>
            <tr>

                <td><?php echo $data['Sp_name'];?></td>
                <td><button class="layui-btn layui-btn-small layui-btn-danger" onclick="delp('<?php echo $data['Spid'];?>')">删除</button></td>
            </tr>
        <?php endforeach; ?>

        </tbody>
    </table>
</div>
<div style="width: 48%;height:auto;margin-left:auto ;">
    <table class="layui-table">
        <thead>
        <tr>

            <th width="auto">辅导员姓名</th>
            <th width="7%">操作</th>
        </tr>
        </thead>
        <tbody>
        <tr>

            <td><input id="i" type="text" name="content" placeholder="辅导员姓名" class="layui-input"></td>
            <td><button class="layui-btn layui-btn-small layui-btn-normal"onclick="addi()">添加</button></td>
        </tr>
        <?php foreach ($i as $data): ?>
            <tr>

                <td><?php echo $data['Si_name'];?></td>
                <td><button class="layui-btn layui-btn-small layui-btn-danger" onclick="deli('<?php echo $data['Siid'];?>')">删除</button></td>
            </tr>
        <?php endforeach; ?>

        </tbody>
    </table>
</div>




<script type="text/javascript" src="/static/admin/frame/layui/layui.js"></script>
<script type="text/javascript">
    layui.use(['laypage','layer'], function () {
        var layer = layui.layer;
    });

    function delp(name){
        layer.confirm('确定要删除？', {icon: 3, title:'提示'}, function(index){
            //do something
            var $ = layui.jquery;
            $.ajax({

                url:"/admin/set/delp",
                type:"post",
                data:{
                    id:name
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
    }
    function deli(name){
        layer.confirm('确定要删除？', {icon: 3, title:'提示'}, function(index){
            //do something
            var $ = layui.jquery;
            $.ajax({

                url:"/admin/set/deli",
                type:"post",
                data:{
                    id:name
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
    }


    function addp(){
        layer.confirm('确认是否添加', {icon: 3, title:'提示'}, function(index){
            //do something
            var $ = layui.jquery;
            var p = document.getElementById('p').value;
            $.ajax({

                url:"/admin/set/addp",
                type:"post",
                data:{
                    p:p
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
    }
    function addi(){
        layer.confirm('确认是否添加', {icon: 3, title:'提示'}, function(index){
            //do something
            var $ = layui.jquery;

            var i = document.getElementById('i').value;
            $.ajax({

                url:"/admin/set/addi",
                type:"post",
                data:{
                    i:i
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
    }
</script>
</body>
</html>

