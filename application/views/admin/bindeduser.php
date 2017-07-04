<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: henbf
 * Date: 2017/5/21
 * Time: 19:54
 * 已绑定用户
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
    <link rel="stylesheet" href="/static/admin/frame/layui/css/layui.css">
    <link rel="stylesheet" href="/static/admin/css/style.css">
</head>
<body class="body">
<div class="my-btn-box">
    <span class="fl">
        <span class="layui-form-label">共计：</span>
        <button class="layui-btn mgl-20"><?php echo $count;?></button>
    </span>
    <span class="fl">
        <span class="layui-form-label">学号：</span>
        <div class="layui-input-inline">
            <input  id="number" type="text" autocomplete="off" placeholder="输入学号" class="layui-input">
        </div>
        <button onclick="search()" class="layui-btn mgl-20"><i class="layui-icon">&#xe615;</i>查询</button>
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

    <?php foreach ($listuserinfo as $data): ?>
    <tr>
        <td><?php echo $data['U_name'];?></td>
        <td><?php echo $data['U_number'];?></td>
        <td><?php echo $data['U_sex'];?></td>
        <td><?php echo $data['U_profession'];?></td>
        <td><?php echo $data['U_class'];?></td>
        <td><?php echo $data['U_Expclass'];?></td>
        <td><?php echo $data['U_instructor'];?></td>
        <td><?php echo $data['U_dormitory'];?></td>
        <td><?php echo $data['U_phone'];?></td>
        <td><?php
            switch ($data['state']){
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
        <td><?php echo date("Y-m-d H:i:s",$data['U_time']);?></td>
        <td>
<!--            <button class="layui-btn layui-btn-small">查看</button>-->
<!--            <button class="layui-btn layui-btn-small layui-btn-normal">编辑</button>-->
            <button class="layui-btn layui-btn-small layui-btn-danger" onclick="del('<?php echo $data['Uid'];?>')">删除</button>
        </td>
    </tr>

    <?php endforeach; ?>
    </tbody>

</table>
<div id="demo1" class="fr"></div>

<script type="text/javascript" src="/static/admin/frame/layui/layui.js"></script>
<!-- jQuery -->
<!--<script type="text/javascript" charset="utf8" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>-->
<!--<script type="text/javascript" src="http://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>-->
<!--<script type="text/javascript" src="/static/admin/js/table-tool.js"></script>-->
<script type="text/javascript">
    layui.use(['laypage', 'layer'], function(){
        var laypage = layui.laypage
            ,layer = layui.layer;
        laypage({
            cont: 'demo1'
            ,pages: <?php echo ceil($count/10);?> //总页数
            ,groups: 5 //连续显示分页数
            ,curr: <?php echo $curr;?>
            ,jump: function(e, first){ //触发分页后的回调
            if(!first){ //一定要加此判断，否则初始时会无限刷新
                location.href = ''+e.curr;
            }
        }
        });
//  layui.use(['element','layer'], function(){
//      var $ = layui.jquery,element = layui.element,layer = layui.layer;
//
//      // 初始化表格
//      $('#dateTable').DataTable({
//          "dom": '<"top">rt<"bottom"flp><"clear">',
//          "autoWidth": true,                     // 自适应宽度
//          "stateSave": true,                      // 刷新后保存页数
//          "order": [[ 1, "desc" ]],               // 排序
//          "searching": false,                     // 本地搜索
//          "info": true,                           // 控制是否显示表格左下角的信息
//          "stripeClasses": ["odd", "even"],       // 为奇偶行加上样式，兼容不支持CSS伪类的场合
//          "aoColumnDefs": [{                      // 指定列不参与排序
//              "orderable": false,
//              "aTargets": [0,11]                   // 对应你的表格的列数
//          }],
//          "pagingType": "simple_numbers",         // 分页样式 simple,simple_numbers,full,full_numbers
//          "language": {                           // 国际化
//              "url":'language.json'
//          }
//      });
//
//      // 例:获取ids
//      $(document).on('click','#btn-delete-all', function(){
//          // getIds(table对象,获取input为id的属性)
//          var list = getIds($('#dateTable'),'data-id');
//          if(list == null || list == ''){
//              layer.msg('未选择');
//          }else{
//              layer.msg(list);
//          }
//      });
//
//      // you code ...
//
//
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
                            location.href = ''+<?php echo $curr;?>;
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
