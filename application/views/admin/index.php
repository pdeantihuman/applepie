<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: henbf
 * Date: 2017/5/20
 * Time: 17:07
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>智慧校园管理</title>
    <link rel="stylesheet" href="/static/admin/frame/layui/css/layui.css">
    <link rel="stylesheet" href="/static/admin/css/style.css">
</head>
<body>
<div class="layui-layout layui-layout-admin">
    <div class="layui-header my-header">
        <a href='<?php $url =base_url('admin');echo "http://$url";?>'>
            <div class="my-header-logo">智慧校园管理</div>
        </a>
        <div class="my-header-btn">
            <button class="layui-btn layui-btn-small btn-nav"><i class="layui-icon">&#xe620;</i></button>
        </div>
        <ul class="layui-nav my-header-user-nav" lay-filter="side-right">

            <li class="layui-nav-item">
                <a class="name" href="javascript:;"><i class="layui-icon">&#xe613;</i>系统管理员 </a>
                <dl class="layui-nav-child">
                    <dd><a href="javascript:;" href-url="/changepassword"><i class="layui-icon">&#xe614;</i>修改密码</a></dd>
                    <dd><a href="/logout"><i class="layui-icon">&#x1006;</i>退出</a></dd>
                </dl>
            </li>
        </ul>
    </div>
    <div class="layui-side my-side">
        <div class="layui-side-scroll">
            <ul class="layui-nav layui-nav-tree" lay-filter="side">
                <li class="layui-nav-item">
                    <a href="javascript:;"><i class="layui-icon">&#xe620;</i>网络注册</a>
                    <dl class="layui-nav-child">
                        <dd class="layui-nav-item"><a href="javascript:;" href-url="/listbindeduser/1"><i class="layui-icon">&#xe60a;</i>已绑定用户</a></dd>
                        <dd class="layui-nav-item"><a href="javascript:;" href-url="/admin/listdata/map"><i class="layui-icon">&#xe62c;</i>用户数据统计</a></dd>
                        <dd class="layui-nav-item"><a href="javascript:;" href-url="/admin/set"><i class="layui-icon">&#xe614;</i>注册表单设置</a></dd>
                        <dd class="layui-nav-item"><a href="javascript:;" href-url="/admin/datacontrol"><i class="layui-icon">&#xe612;</i>用户数据管理</a></dd>
                    </dl>
                </li>

                <li class="layui-nav-item">
                    <a href="javascript:;"><i class="layui-icon">&#xe620;</i>报修管理</a>
                    <dl class="layui-nav-child">
                        <dd class="layui-nav-item"><a href="javascript:;" href-url="/admin/fix/nothandlelist"><i class="layui-icon">&#xe60e;</i>待处理</a></dd>
                        <dd class="layui-nav-item"><a href="javascript:;" href-url="/admin/fix/handleinglist"><i class="layui-icon">&#xe60e;</i>处理中</a></dd>
                        <dd class="layui-nav-item"><a href="javascript:;" href-url="/admin/fix/handleedlist"><i class="layui-icon">&#x1005;</i>已完成</a></dd>
                        <dd class="layui-nav-item"><a href="javascript:;" href-url="http://www.baidu.com"><i class="layui-icon">&#xe612;</i>人员管理</a></dd>
                    </dl>
                </li>

                <li class="layui-nav-item">
                    <a href="javascript:;"><i class="layui-icon">&#xe620;</i>公众号管理</a>
                    <dl class="layui-nav-child">
                        <dd class="layui-nav-item"><a href="javascript:;" href-url="/admin/listdata/autoreply"><i class="layui-icon">&#xe63a;</i>自动回复</a></dd>
                        <dd class="layui-nav-item"><a href="javascript:;" href-url="/admin/weixin/mass"><i class="layui-icon">&#xe606;</i>群发消息</a></dd>
                        <dd class="layui-nav-item"><a href="javascript:;" href-url="/listguest/1"><i class="layui-icon">&#xe62d;</i>留言信息</a></dd>
                        <dd class="layui-nav-item"><a href="javascript:;" href-url="/admin/weixin/menu"><i class="layui-icon">&#xe614;</i>菜单设置</a></dd>
                    </dl>
                </li>

                <li class="layui-nav-item">
                    <a href="javascript:;"><i class="layui-icon">&#xe620;</i>文档设置</a>
                    <dl class="layui-nav-child">
                        <dd class="layui-nav-item"><a href="javascript:;" href-url="/admin/news"><i class="layui-icon">&#xe63a;</i>添加</a></dd>
                        <dd class="layui-nav-item"><a href="javascript:;" href-url="/admin/news/newslist"><i class="layui-icon">&#xe60a;</i>查看</a></dd>
                    </dl>
                </li>
            </ul>
        </div>
    </div>
    <div class="layui-body my-body">
        <div class="layui-tab layui-tab-card my-tab" lay-filter="card" lay-allowClose="true">
            <ul class="layui-tab-title">
                <li class="layui-this" lay-id="0"><span>系统</span></li>
            </ul>
            <div class="layui-tab-content">
                <div class="layui-tab-item layui-show">
                    <iframe id="iframe" src="https://tyzy.win" frameborder="0"></iframe>
                </div>
            </div>
        </div>
    </div>
    <div class="layui-footer my-footer">
        <p><a href="http://www.smell.ren" target="_blank">北京科技大学天津学院智慧校园</a>
        <p>2017 © 张昱</p>
    </div>
</div>
<script type="text/javascript" src="/static/admin/frame/layui/layui.js"></script>
<script type="text/javascript" src="/static/admin/js/index.js"></script>
</body>
</html>
