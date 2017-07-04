<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * User: 张昱
 * Date: 2017/5/26
 * Time: 23:32
 * Email: henbf@vip.qq.com
 * news管理界面
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


<form class="layui-form layui-form-pane">
    <div class="layui-form-item">
        <label class="layui-form-label">分类</label>
        <div class="layui-input-inline">
            <select name="fl" lay-verify="required">
                <option value=""  selected="">请选择分类</option>
                <?php foreach ($tag as $data): ?>
                <option value="<?php echo $data['Ntid'];?>"><?php echo $data['Nt_name'];?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <input type="button" value="分类管理" onclick="flgl()" class="layui-btn layui-btn-normal" />
        </div>
    </div>


    <div class="layui-form-item">
        <label class="layui-form-label">标题</label>
        <div class="layui-input-inline">
            <input type="text" name="title" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div style="width:50%;">
        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">内容</label>
            <div class="layui-input-block">
                <textarea class="layui-textarea layui-hide" name="content" lay-verify="content" id="content"></textarea>
            </div>
        </div>
    </div>
    <div class="layui-form-item">
        <input type="button" value="立即提交" class="layui-btn" lay-submit="" lay-filter="*" />
    </div>
</form>


<script src="/static/admin/frame/layui/layui.js" charset="utf-8"></script>
<script type="text/javascript">
    layui.use(['form', 'layedit', 'laydate'], function(){

        var form = layui.form();
        var layer = layui.layer;
        var layedit = layui.layedit;
        var laydate = layui.laydate;
        var $ =layui.jquery;

        //创建一个编辑器
        layedit.set({
            uploadImage:{
                url: '/admin/upload/image',
                type:'post'
            }
        });


        var index = layedit.build('content',{
            tool: [
                'strong',
                'italic',
                'underline',
                '|',
                'left',
                'center',
                'link',
//      		'image',
            ]
        });
        /*
         * 通过验证数据同步富文本编辑器的内容到textarea
         */
        form.verify({
            content:function (vale){
                layedit.sync(index);
            }

        });







        //监听提交
        form.on('submit(*)', function(data){
//      	var content = layedit.getContent(index);
//      	layedit.sync(content);
//          layer.alert(JSON.stringify(data.field), {
//              title: '最终的提交信息'
//          });
//          return false;

//		alert(layedit.getContent(index));
//		alert(data.form);

            var $ = layui.jquery;
            $.ajax({

                url:"/admin/news/addnews",
                type:"post",
                data:data.field,
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
            return false;
        });


    });

    function flgl() {
        layer.open({
            type: 2,
            shadeClose: false,
            fixed: false,
            title: '分类管理',
            area: ['300px', '300px'],
            offset: '35%',
            content: 'news/tagmanage',
            resize:false,

            end: function(){
                location.reload();
            }
        });
    };

</script>
</body>
</html>

