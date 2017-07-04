<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * User: 张昱
 * Date: 2017/5/24
 * Time: 15:12
 * Email: henbf@vip.qq.com
 * 自动回复list页面
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>自动回复</title>
    <link rel="stylesheet" href="/static/admin/frame/layui/css/layui.css">
    <link rel="stylesheet" href="/static/admin/css/style.css">
</head>
<body class="body">

<table class="layui-table">
    <thead>
    <tr>
        <th width="10%">关键词</th>
        <th width="auto">回复内容</th>
        <th width="7%">操作</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>
            <input id="k" type="text" name="keword" placeholder="关键词" class="layui-input">
        </td>
        <td><input id="c" type="text" name="content" placeholder="回复内容" class="layui-input"></td>
        <td><button class="layui-btn layui-btn-small layui-btn-normal"onclick="add()">添加</button></td>
    </tr>
    <?php foreach ($list as $data): ?>
    <tr>
        <td><?php echo $data['A_keyword'];?></td>
        <td><?php echo $data['A_content'];?></td>
        <td><button class="layui-btn layui-btn-small layui-btn-danger" onclick="del('<?php echo $data['Aid'];?>')">删除</button></td>
    </tr>
    <?php endforeach; ?>

    </tbody>
</table>




<script type="text/javascript" src="/static/admin/frame/layui/layui.js"></script>
<script type="text/javascript">
    layui.use(['laypage','layer'], function () {
        var $ = layui.jquery;

        var layer = layui.layer;


        });

    function del(name){
        layer.confirm('确定要删除？', {icon: 3, title:'提示'}, function(index){
            //do something
            var $ = layui.jquery;
            $.ajax({

                url:"/admin/listdata/delautoreply",
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


    function add(){
        layer.confirm('确认是否添加', {icon: 3, title:'提示'}, function(index){
            //do something
            var $ = layui.jquery;
            var k = document.getElementById('k').value;
            var c = document.getElementById('c').value;
            $.ajax({

                url:"/admin/listdata/addautoreply",
                type:"post",
                data:{
                    keyword:k,
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
    }
</script>
</body>
</html>
