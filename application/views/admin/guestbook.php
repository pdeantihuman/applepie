<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * User: 张昱
 * Date: 2017/5/24
 * Time: 10:36
 * Email: henbf@vip.qq.com
 * 用户的留言信息
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>微信留言</title>
    <link rel="stylesheet" href="/static/admin/frame/layui/css/layui.css">
    <link rel="stylesheet" href="/static/admin/css/style.css">
</head>
<body class="body">
<table class="layui-table">
    <thead>
    <tr>
        <th width="10%">发送人</th>
        <th width="auto">内容</th>
        <th width="15%">时间</th>
        <th width="7%">操作</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($list as $data): ?>
    <tr>

        <td><?php echo $data['name'];?></td>
        <td><?php
            switch($data['g_type']){
                case 'text':
                    echo $data['g_content'];
                    break;
                case 'images':
                    $img=$data['g_pictureurl'];
                    echo "<a href='javascript:;' class='pay' href-url='' onclick=img('../..$img')>图片点击查看</a>";
                    break;
                default:
                    break;
            }

            ?></td>
        <td><?php echo date("Y-m-d H:i:s",$data['g_time']);?></td>
        <td><button class="layui-btn layui-btn-small layui-btn-danger" onclick="del('<?php echo $data['gid'];?>')">删除</button></td>

    </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<div id="demo1" class="fr"></div>



<!--<div class="my-pay-box none">
    <div><img src="../image/zfb.png" width="500px" height="auto"></div>
</div>-->

<script type="text/javascript" src="/static/admin/frame/layui/layui.js"></script>
<script type="text/javascript">

    layui.use(['laypage','layer'], function () {
        var $ = layui.jquery;
        var laypage = layui.laypage;
        var layer = layui.layer;
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

    });
    function img(myimg){
        layer.open({
            type: 1,
            title: false,
            closeBtn: true,
            shadeClose: true,
            area: ['auto','auto'],
            content: '<img src="../image/'+myimg+'" width="500px" height="auto">'
        });}
    function del(name){
        layer.confirm('确定要删除？', {icon: 3, title:'提示'}, function(index){
            //do something
            var $ = layui.jquery;
            $.ajax({

                url:"/admin/listdata/delguest",
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
