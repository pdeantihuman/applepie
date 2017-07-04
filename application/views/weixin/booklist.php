<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * User: 张昱
 * Date: 2017/5/10
 * Time: 1:01
 * Email: henbf@vip.qq.com
 */
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="/static/css/mui.min.css">
    <style>
        .mui-plus.mui-android header.mui-bar{
            display: none;
        }
        .mui-plus.mui-android .mui-bar-nav~.mui-content{
            padding: 0;
        }

    </style>
</head>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
    wx.config({
        debug: false,
        appId: '<?php echo $JS['appId'];?>',
        timestamp: <?php echo $JS['timestamp'];?>,
        nonceStr: '<?php echo $JS['nonceStr'];?>',
        signature: '<?php echo $JS['signature'];?>',
        jsApiList: [
            'hideOptionMenu',

        ]
    });
    wx.ready(function(){
        wx.hideOptionMenu();
    });
    </script>

<body>
<header class="mui-bar mui-bar-nav">
    <h1 class="mui-title">查询结果</h1>
</header>
<div class="mui-content">
    <ul class="mui-table-view mui-table-view-chevron">
        <?php foreach ($book as $data): ?>
        <li class="mui-table-view-cell mui-media">
            <a href='http://61.181.145.1:82/opac/<?php echo $data['url'];?>' class="mui-navigate-right">
                <img class="mui-media-object mui-pull-left" src="/static/img/book2.png">
                <div class="mui-media-body">
                    <?php echo $data['title'];?>
                    <p class='mui-ellipsis'>作者：<?php echo $data['actor'];?></p>
                </div>
            </a>
        </li>
        <?php endforeach; ?>
    </ul>
<!--    <div class="mui-content-padded">-->
<!--        <ul class="mui-pager">-->
<!--            <li class="mui-disabled">-->
<!--                <span> 上一页 </span>-->
<!--            </li>-->
<!--            <li>-->
<!--                <a href="#">-->
<!--                    下一页-->
<!--                </a>-->
<!--            </li>-->
<!--        </ul>-->
<!--    </div>-->
</div>
<footer  class="mui-bar mui-bar-footer">
    <p align="center" style="margin-top: 15px;">
        © 2017 北京科技大学天津学院智慧校园
    </p>
</footer >

</body>
<script src="/static/js/mui.min.js"></script>
<script>
    mui.init({
        swipeBack:true //启用右滑关闭功能
    });
</script>
</html>
