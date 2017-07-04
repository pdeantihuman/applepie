<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * User: 张昱
 * Date: 2017/5/10
 * Time: 0:00
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
        h5 {
            margin: 5px 7px;
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
            'hideOptionMenu'

        ]
    });
    wx.ready(function(){
        wx.hideOptionMenu();
    });


</script>

<body>
<header class="mui-bar mui-bar-nav">
    <h1 class="mui-title">北京科技大学天津学院图书馆</h1>
</header>
<div class="mui-content">
    <div class="mui-content-padded" style="margin: 15px;">

        <div class="mui-input-row mui-search">
            <input id="search" type="search" class="mui-input-clear" placeholder="书名" onchange="searchaction()">
        </div>

    </div>
</div>

<div class="mui-content-padded">
    <h5>新书通报</h5>
</div>
<div class="mui-card" style="margin-bottom: 35px;">

    <ul class="mui-table-view mui-table-view-chevron">

        <?php foreach ($book as $data): ?>
            <li class="mui-table-view-cell mui-media">
                <a href='http://61.181.145.1:82/opac/<?php echo $data['url'];?>' class="mui-navigate-right">

                    <div class="mui-media-body">
                        <?php echo $data['title'];?>/
                        <span class='mui-ellipsis'><?php echo $data['actor'];?></span>
                    </div>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<footer  class="mui-bar mui-bar-footer">
    <p align="center" style="margin-top: 15px;">
        © 2017 北京科技大学天津学院智慧校园
    </p>
</footer >


<script src="/static/js/mui.min.js"></script>
<script>
    var addurl = '<?php $url =base_url('book/getbook');echo "http://$url";?>';
    var search = document.getElementById("search");
    function searchaction(){
        var Info = {
            search : search.value
        };
        if (Info.search==="") {
            mui.toast('请输入要查询的书籍名',{ duration:'long', type:'div' });
            return;
        }
        mui.post(addurl,{
                search:Info.search
            },function(data){
                if(data.state === 'success'){
                    window.location.href=data.link;

                }else{
                    mui.alert(data.message,"注意","确定");
                }


            },'json'
        );
    }



</script>

</body>

</html>
