<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * User: 张昱
 * Date: 2017/5/27
 * Time: 22:59
 * Email: henbf@vip.qq.com
 * 管理界面罗列新闻
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

<table class="layui-table">
    <thead>
    <tr>
        <th width="auto">名称</th>
        <th width="15%">操作</th>
    </tr>
    </thead>
    <tbody>

    <?php foreach ($news as $data): ?>
        <tr>

            <td><?php echo $data['N_name'];?></td>
            <td><button class="layui-btn layui-btn-small layui-btn-normal" onclick="content('<?php echo $data['Nid'];?>')">查看内容</button>
                <button class="layui-btn layui-btn-small layui-btn-danger" onclick="del('<?php echo $data['Nid'];?>')">删除</button>
            </td>
        </tr>
    <?php endforeach; ?>

    </tbody>
</table>
    <script type="text/javascript" src="/static/admin/frame/layui/layui.js"></script>
    <script type="text/javascript">
        layui.use(['element', 'layer'], function(){
            var element = layui.element();
            var layer = layui.layer;
        });
        function del(name){
            layer.confirm('确定要删除？', {icon: 3, title:'提示'}, function(index){
                //do something
                var $ = layui.jquery;
                $.ajax({

                    url:"/admin/news/del",
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


        function content(name) {
            layer.open({
                type: 2,
                shadeClose: false,
                fixed: false,
                title: '内容',
                area: ['300px', '300px'],
                offset: '35%',
                content: 'getcontent/'+name,
                resize:false
            });
        };

    </script>
</body>
</html>
