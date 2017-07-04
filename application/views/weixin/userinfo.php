<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: henbf
 * Date: 2017/5/8
 * Time: 21:03
 */
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title></title>
    <link href="/static/css/mui.min.css" rel="stylesheet"/>
    <style>
        html,
        body {
            background-color: #efeff4;
        }
        .mui-page-content {
            position: absolute;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            width: 100%;
            height: 100%;
            background-color: #efeff4;
        }
        .mui-scroll-wrapper,
        .mui-scroll {
            background-color: #efeff4;
        }
        .mui-page .mui-table-view:first-child {
            margin-top: 15px;
        }
        .mui-page .mui-table-view:last-child {
            margin-bottom: 30px;
        }
        .mui-table-view {
            margin-top: 20px;
        }
        .mui-table-view span.mui-pull-right {
            color: #999;
        }
        .mui-fullscreen {
            position: fixed;
            z-index: 20;
            background-color: #000;
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

<body class="mui-fullscreen">
<div class="mui-page-content">

    <div class="mui-scroll-wrapper">

        <div class="mui-scroll">

            <ul class="mui-card mui-table-view">
                <li class="mui-table-view-cell">
                    <a>开网状态<span class="mui-pull-right"><?php
                                                switch ($netstate['N_state']){
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

                                                                    ?></span></a>
                </li>
                <li class="mui-table-view-cell">
                    <a>姓名<span class="mui-pull-right"><?php echo $userinfo['U_name'];?></span></a>
                </li>
                <li class="mui-table-view-cell">
                    <a>性别<span class="mui-pull-right"><?php echo $userinfo['U_sex'];?></span></a>
                </li>
                <li class="mui-table-view-cell">
                    <a>专业<span class="mui-pull-right"><?php echo $userinfo['U_profession'];?></span></a>
                </li>
                <li class="mui-table-view-cell">
                    <a>班级<span class="mui-pull-right"><?php echo $userinfo['U_class'];?></span></a>
                </li>
                <li class="mui-table-view-cell">
                    <a>辅导员<span class="mui-pull-right"><?php echo $userinfo['U_instructor'];?></span></a>
                </li>
                <li class="mui-table-view-cell">
                    <a>宿舍<span class="mui-pull-right"><?php echo $userinfo['U_dormitory'];?></span></a>
                </li>
            </ul>
            <ul class="mui-card mui-table-view">
                <li class="mui-table-view-cell">
                    <a><span class="mui-icon mui-icon-phone"></span><span class="mui-pull-right"><?php echo $userinfo['U_phone'];?></span></a>
                </li>
            </ul>

    </div>
    </div>
</div>
</body>
</html>
