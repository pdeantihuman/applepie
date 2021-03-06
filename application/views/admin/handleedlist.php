<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * User: 张昱
 * Date: 2017/5/30
 * Time: 22:15
 * Email: henbf@vip.qq.com
 */?>
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
        <th width="7%">宿舍</th>
        <th width="7%">姓名</th>
        <th width="13%">电话号码</th>
        <th width="auto">问题描述</th>
        <th width="15%">提交时间</th>
        <th width="15%">操作</th>
    </tr>
    </thead>
    <tbody>

    <?php foreach ($list as $data): ?>
        <?php if ($count==0) break;?>
        <tr>
            <td><?php echo $data['userinfo']['U_dormitory'];?></td>
            <td><?php echo $data['userinfo']['U_name'];?></td>
            <td><?php echo $data['userinfo']['U_phone'];?></td>
            <td><?php echo $data['Fo_comment'];?></td>
            <td><?php echo $data['Fo_time'];?></td>
            <td><button class="layui-btn layui-btn-small layui-btn-normal" onclick="content('<?php echo $data['Foid'];?>')">维修记录</button>
            </td>
        </tr>
    <?php endforeach; ?>

    </tbody>
</table>
<div id="demo1" class="fr"></div>
<script type="text/javascript" src="/static/admin/frame/layui/layui.js"></script>
<script type="text/javascript">
    layui.use(['element', 'layer','laypage'], function(){
        var element = layui.element();
        var layer = layui.layer;
        var laypage=layui.laypage;
        laypage({
            cont: 'demo1'
            ,pages: <?php if($count==0)echo 1;else echo ceil($count/10);?> //总页数
            ,groups: 5 //连续显示分页数
            ,curr: <?php echo $curr;?>
            ,jump: function(e, first){ //触发分页后的回调
                if(!first){ //一定要加此判断，否则初始时会无限刷新
                    location.href = '/admin/fix/handleedlist/'+e.curr;
                }
            }
        });
    });
    function content(name) {
        layer.open({
            type: 2,
            shadeClose: false,
            fixed: false,
            title: '维修记录',
            area: ['700px', '300px'],
            offset: '35%',
            content: '/admin/fix/listlog/'+name,
            resize:false,
//            end: function(){
//                location.reload();
//            }

        });
    };

</script>
</body>
</html>



