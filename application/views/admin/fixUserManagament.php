<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User:
 * Date: 2017/7/5
 * Time: 19:54
 * 维修人员管理
 */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>已绑定用户</title>
    <link rel="stylesheet" href="static/admin/frame/layui/css/layui.css">
    <link rel="stylesheet" href="static/admin/css/style.css">
    <script type="text/javascript" src="static/admin/frame/layui/layui.js"></script>

</head>
<body class="body">
<div class="my-btn-box">
    <span class="fl">
        <span class="layui-form-label">共计：</span>
        <button class="layui-btn mgl-20"><?php echo $count; ?></button>
    </span>
    <span class="fl">
        <span class="layui-form-label">学号：</span>
        <div class="layui-input-inline">
            <input  id="number" type="text" autocomplete="off" placeholder="输入学号" class="layui-input">
        </div>
        <button onclick="search()" class="layui-btn mgl-20"><i class="layui-icon">&#xe615;</i>查询</button>
    </span>

    <span class="fl">
		<span class="layui-form-label">范围选择：</span>
		<div class="layui-input-inline">
			<input class="layui-input" placeholder="开始日" id="LAY_demorange_s">
		</div>
		<div class="layui-input-inline">
			<input class="layui-input" placeholder="截止日" id="LAY_demorange_e">
		</div>
		<button onclick="search()" class="layui-btn mgl-20">
		<i class="layui-icon">&#xe615;</i>查询
		</button>
	</span>
</div>

<table id="dateTable" class="layui-table">
    <thead>
    <tr>
        <th>序号</th>
        <th>姓名</th>
        <th>学号</th>
        <th>手机号</th>
        <th>接受报修</th>
        <th>完成报修</th>
        <th>转给他人</th>
        <th>任务完成率</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody>

    <?php $index = 1;foreach ($listuserinfo as $data): ?>
        <tr>
            <td><?php echo $index ?></td>
            <td><?php echo $data['U_name']; ?></td>
            <td><?php echo $data['U_number']; ?></td>
            <td><?php echo $data['U_phone']; ?></td>
            <td><?php echo $data['U_accepted']; ?></td>  <!--TODO:新增接受报修数-->
            <td><?php echo $data['U_finished']; ?></td>  <!--TODO:新增完成报修数-->
            <td><?php echo $data['U_transmission']; ?></td>  <!--TODO:新增转交报修数-->
            <td><?php echo $data['U_rate']; ?></td>  <!--TODO:新增完成报修率，报修率计算=(完成报修数-转交报修数)/接受报修数-->
            <td>
                <!--            <button class="layui-btn layui-btn-small">查看</button>-->
                <!--            <button class="layui-btn layui-btn-small layui-btn-normal">编辑</button>-->
                <!--            <button class="layui-btn layui-btn-small layui-btn-normal">同意</button>-->
                <button class="layui-btn layui-btn-small layui-btn-danger" onclick="del('<?php echo $data['Uid']; ?>')">删除</button>
            </td>
        </tr>

        <?php  $index++;endforeach; ?>
    </tbody>

</table>
<div id="demo1" class="fr"></div>



<script type="text/javascript">
    layui.use(['laypage', 'layer'], function() {
        var laypage = layui.laypage,
            layer = layui.layer;
        laypage({
            cont: 'demo1',
            pages:<?php echo ceil($count / 10); ?>//总页数
            , groups: 5 //连续显示分页数
            , curr:<?php echo $curr; ?>, jump: function(e, first) { //触发分页后的回调
                if(!first) { //一定要加此判断，否则初始时会无限刷新
                    location.href = '' + e.curr;
                }
            }
        });

    });

    function search() {
        var number = document.getElementById('number').value;
        if(number == "") {
            layer.alert('请填写学号');
        } else {
            location.href = '/admin/search/searchbynumber/' + number;
        }

    }

    function del(name) {
        layer.confirm('确定要删除？', {
            icon: 3,
            title: '提示'
        }, function(index) {
            //do something
            var $ = layui.jquery;
            $.ajax({

                url: "/admin/listdata/del",
                type: "post",
                data: {
                    id: name
                },
                dataType: "json",
                success: function(data) {
                    if(data.state == "1") {
                        layer.msg(data.message, {
                            icon: 1,
                            time: 1000
                        }, function() {
                            location.href = '' +<?php echo $curr; ?>;
                        });
                    } else {
                        layer.alert(data.message);
                    }
                }
            });
            layer.close(index);
        });
    }</script>
<script>//关于日期选择的js
    layui.use('laydate', function(){
        var laydate = layui.laydate;

        var start = {
//  min: laydate.now()
            min:'2015-01-01 00:00:00'
            ,max: '2099-06-16 23:59:59'
            ,istoday: false
            ,choose: function(datas){
                end.min = datas; //开始日选好后，重置结束日的最小日期
                end.start = datas //将结束日的初始值设定为开始日
            }
        };

        var end = {
//  min: laydate.now()
            min:'2015-01-01 00:00:00'
            ,max: '2099-06-16 23:59:59'
            ,istoday: false
            ,choose: function(datas){
                start.max = datas; //结束日选好后，重置开始日的最大日期
            }
        };

        document.getElementById('LAY_demorange_s').onclick = function(){
            start.elem = this;
            laydate(start);
        }
        document.getElementById('LAY_demorange_e').onclick = function(){
            end.elem = this
            laydate(end);
        }

    });
</script>
</body>
</html>
