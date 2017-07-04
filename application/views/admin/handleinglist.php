<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * User: 张昱
 * Date: 2017/5/30
 * Time: 21:52
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
        <tr>
            <td><?php echo $data['userinfo']['U_dormitory'];?></td>
            <td><?php echo $data['userinfo']['U_name'];?></td>
            <td><?php echo $data['userinfo']['U_phone'];?></td>
            <td><?php echo $data['Fo_content'];?></td>
            <td><?php echo date("Y-m-d H:i:s",$data['Fo_time']);?></td>
            <td><button class="layui-btn layui-btn-small layui-btn-normal" onclick="content('<?php echo $data['Foid'];?>')">维修记录</button>
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
    function content(name) {
        layer.open({
            type: 2,
            shadeClose: false,
            fixed: false,
            title: '维修记录',
            area: ['700px', '300px'],
            offset: '35%',
            content: 'listlog/'+name,
            resize:false,
//            end: function(){
//                location.reload();
//            }

        });
    };

</script>
</body>
</html>


