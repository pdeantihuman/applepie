<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * User: 张昱
 * Date: 2017/5/22
 * Time: 23:15
 * Email: henbf@vip.qq.com
 * 查询用户信息的用户界面
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
<div class="my-btn-box">
    <span class="fl">
        <button onclick="history.back();" class="layui-btn mgl-20 layui-btn-danger">返回</button>
    </span>
    <span class="fl">
        <span class="layui-form-label">学号：</span>
        <div class="layui-input-inline">
            <input  id="number" type="text" autocomplete="off" placeholder="输入学号" class="layui-input">
        </div>
        <button onclick="search()" class="layui-btn mgl-20">查询</button>
    </span>
</div>

<table id="dateTable" class="layui-table">
    <thead>
    <tr>
        <th>姓名</th>
        <th>学号</th>
        <th>性别</th>
        <th>专业</th>
        <th>班级</th>
        <th>实验班</th>
        <th>辅导员</th>
        <th>宿舍</th>
        <th>手机号</th>
        <th>网号状态</th>
        <th>绑定时间</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody>


        <tr>
            <td><?php echo $userinfo['U_name'];?></td>
            <td><?php echo $userinfo['U_number'];?></td>
            <td><?php echo $userinfo['U_sex'];?></td>
            <td><?php echo $userinfo['U_profession'];?></td>
            <td><?php echo $userinfo['U_class'];?></td>
            <td><?php echo $userinfo['U_Expclass'];?></td>
            <td><?php echo $userinfo['U_instructor'];?></td>
            <td><?php echo $userinfo['U_dormitory'];?></td>
            <td><?php echo $userinfo['U_phone'];?></td>
            <td><?php
                switch ($userinfo['state']){
                    case 1:
                        echo '已提交申请';
                        break;
                    case 2:
                        echo '已开通';
                        break;
                    case 3:
                        echo '冻结';
                        break;
                    default:
                        echo '未申请开通';
                        break;

                }

                ?></td>
            <td><?php echo date("Y-m-d H:i:s",$userinfo['U_time']);?></td>
            <td>

                <button class="layui-btn layui-btn-small layui-btn-danger" onclick="del('<?php echo $userinfo['Uid'];?>')">删除</button>
            </td>
        </tr>


    </tbody>

</table>


<script type="text/javascript" src="/static/admin/frame/layui/layui.js"></script>

<script type="text/javascript">
    layui.use(['layer'], function(){
        var layer = layui.layer;
    });
    function search(){
        var number = document.getElementById('number').value;
        if(number ==""){
            layer.alert('请填写学号');
        }else{
            location.href = '/admin/search/searchbynumber/'+number;
        }

    }
    function del(name){
        layer.confirm('确定要删除？', {icon: 3, title:'提示'}, function(index){
            //do something
            var $ = layui.jquery;
            $.ajax({

                url:"/admin/listdata/del",
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
                            history.back();
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

