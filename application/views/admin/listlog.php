<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * User: 张昱
 * Date: 2017/5/30
 * Time: 22:04
 * Email: henbf@vip.qq.com
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
            <th width="20%">处理人</th>
            <th width="auto">留言</th>
            <th width="40%">时间</th>
        </tr>
        </thead>
        <tbody>


                <?php foreach ($log as $data): ?>
                <tr>
                    <td><?php echo $this->Wxfixuser_model->getfixusernamebyopenid($data['Fof_fuopenid']);?></td>
                    <td><?php echo $data['Fof_message'];?></td>
                    <td><?php echo date("Y-m-d H:i:s",$data['Fof_time']);?></td>
                <tr>
                <?php endforeach; ?>



        </tbody>
    </table>
</div>


</body>
</html>
