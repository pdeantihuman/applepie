<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * User: 张昱
 * Date: 2017/5/30
 * Time: 10:47
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
<hr>
<blockquote class="layui-elem-quote">
    说明：下载模板之后，按照Excel格式导入相应的数据即可。如果出现数据错误的情况，重新上传即可。<small><u>重新上传会覆盖掉之前上传的所有数据</u></small>
</blockquote>
<div class="fl">
<a href="/upload/static/demo.xlsx" type="button" class="layui-btn"><i class="layui-icon">&#xe601;</i>&nbsp;数据模板</a>
    <input type="file" name="upfile" lay-type="file" class="layui-upload-file">
</div>
<hr/>
<blockquote class="layui-elem-quote">
    下载未绑定的用户数据<small></small>
</blockquote>
<div class="fl">
    <a href="/admin/datacontrol/down" type="button" class="layui-btn"><i class="layui-icon">&#xe601;</i>&nbsp;下载</a>
</div>

<hr/>
<blockquote class="layui-elem-quote">
    下载已绑定的用户数据<small></small>
</blockquote>
<div class="fl">
    <a href="/admin/datacontrol/downbind" type="button" class="layui-btn"><i class="layui-icon">&#xe601;</i>&nbsp;下载</a>
</div>

<script type="text/javascript" src="/static/admin/frame/layui/layui.js"></script>
<script>
    layui.use('upload', function(){
        layui.upload({
            url: '/admin/datacontrol/upload'
            ,title: '上传数据'
            ,ext: 'xlsx'
            ,before: function(input){
                layer.msg('数据上传中');
            }
            ,success: function(data){
                if(data.state=="1"){
                    layer.alert(data.message, {
                        title :'成功',
                        icon: 1,
                    });
                }else {
                    layer.alert(data.message);
                }
            }
        });
    });
//    function down(){
//        layer.prompt({
//            title: '输入下载密码',
//        },function(val, index){
//            var $ = layui.jquery;
//            $.ajax({
//
//                url:"/admin/datacontrol/down",
//                type:"post",
//                data:{
//                    pass:val
//                },
//                dataType: "json",
//                success:function (data){
//                    if(data.state=="1"){
//                        layer.msg(data.message, {
//                            icon: 1,
//                            time: 1000
//                        }, function(){
//
//                        });
//                    }else {
//                        layer.alert(data.message);
//                    }
//                }
//            });
//            layer.close(index);
//        });
//    }
</script>
</body>
</html>
