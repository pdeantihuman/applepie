<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * User: 张昱
 * Date: 2017/5/30
 * Time: 21:00
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
            <th width="auto"></th>
            <th width="7%"></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($user as $data): ?>
    <tr>
        <td><?php echo $data['Fu_name'];?></td>
        <td><button class="layui-btn layui-btn-mini layui-btn-danger" onclick="choose('<?php echo $data['Fuid'];?>','<?php echo $id;?>')">选择</button></td>
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

    function choose(name,fid){
        layer.confirm('确定选择他去维修么', {icon: 3, title:'提示'}, function(index){
            //do something
            var $ = layui.jquery;
            $.ajax({

                url:"/admin/fix/dochoose",
                type:"post",
                data:{
                    id:name,
                    fid:fid
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