<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * User: 张昱
 * Date: 2017/5/30
 * Time: 17:53
 * Email: henbf@vip.qq.com
 * 菜单管理
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
<div>
    <blockquote class="layui-elem-quote">
        最多设置五个菜单，否则会创建失败
    </blockquote>
    <div class="fl">
        <a onclick="set()" type="button" class="layui-btn">保存生效</a>
    </div>
    <hr>
    <table class="layui-table">
        <thead>
        <tr>
            <th width="20%">名称</th>
            <th width="auto">地址</th>
            <th width="7%">操作</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td><input id="n" type="text" name="content" placeholder="名称" class="layui-input"></td>
            <td><input id="u" type="text" name="content" placeholder="网页地址http://" class="layui-input"></td>
            <td><button class="layui-btn layui-btn-small layui-btn-mini"onclick="add()">添加</button></td>
        </tr>
        <?php foreach ($menu as $data): ?>
            <tr>
                <td><?php echo $data['name'];?></td>
                <td><?php echo $data['url'];?></td>
                <td><button class="layui-btn layui-btn-mini layui-btn-danger" onclick="del('<?php echo $data['Mid'];?>')">删除</button></td>
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
    function set(){
        var $ = layui.jquery;
        $.ajax({

            url:"/admin/weixin/setmenu",
            type:"post",
            data:{
                id:1
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
    }
    function add(){
        layer.confirm('确认是否添加', {icon: 3, title:'提示'}, function(index){
            //do something
            var $ = layui.jquery;

            var n = document.getElementById('n').value;
            var u = document.getElementById('u').value;
            $.ajax({

                url:"/admin/weixin/addmenu",
                type:"post",
                data:{
                    name:n,
                    url:u

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

    function del(name){
        layer.confirm('确定要删除？', {icon: 3, title:'提示'}, function(index){
            //do something
            var $ = layui.jquery;
            $.ajax({

                url:"/admin/weixin/delmenu",
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

</script>
</body>
</html>

