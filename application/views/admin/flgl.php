<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * User: 张昱
 * Date: 2017/5/27
 * Time: 15:37
 * Email: henbf@vip.qq.com
 * 新闻分类管理设置页面
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
    <table class="layui-table">
        <thead>
        <tr>
            <th width="auto"></th>
            <th width="7%"></th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td><input id="tag" type="text" name="content" placeholder="分类名称" class="layui-input"></td>
            <td><button class="layui-btn layui-btn-small layui-btn-mini"onclick="add()">添加</button></td>
        </tr>
        <?php foreach ($tag as $data): ?>
            <tr>
                <td><?php echo $data['Nt_name'];?></td>
                <td><button class="layui-btn layui-btn-mini layui-btn-danger" onclick="del('<?php echo $data['Ntid'];?>')">删除</button></td>
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
    function add(){
        layer.confirm('确认是否添加', {icon: 3, title:'提示'}, function(index){
            //do something
            var $ = layui.jquery;

            var tag = document.getElementById('tag').value;
            $.ajax({

                url:"/admin/news/addtag",
                type:"post",
                data:{
                    tag:tag
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
        layer.confirm('确定要删除？删除后，此分类的所有内容都将被删除！', {icon: 3, title:'提示'}, function(index){
            //do something
            var $ = layui.jquery;
            $.ajax({

                url:"/admin/news/deltag",
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

