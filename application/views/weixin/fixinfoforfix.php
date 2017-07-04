<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: henbf
 * Date: 2017/5/13
 * Time: 11:23
 * 维修信息给维修人员，有转交和留言功能
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
        .mui-views,
        .mui-view,
        .mui-pages,
        .mui-page,
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
        .mui-pages {
            top: 46px;
            height: auto;
        }
        .mui-scroll-wrapper,
        .mui-scroll {
            background-color: #efeff4;
        }
        .mui-page.mui-transitioning {
            -webkit-transition: -webkit-transform 300ms ease;
            transition: transform 300ms ease;
        }
        .mui-page-left {
            -webkit-transform: translate3d(0, 0, 0);
            transform: translate3d(0, 0, 0);
        }
        .mui-ios .mui-page-left {
            -webkit-transform: translate3d(-20%, 0, 0);
            transform: translate3d(-20%, 0, 0);
        }
        .mui-navbar {
            position: fixed;
            right: 0;
            left: 0;
            z-index: 10;
            height: 44px;
            background-color: #f7f7f8;
        }
        .mui-navbar .mui-bar {
            position: absolute;
            background: transparent;
            text-align: center;
        }
        .mui-android .mui-navbar-inner.mui-navbar-left {
            opacity: 0;
        }
        .mui-ios .mui-navbar-left .mui-left,
        .mui-ios .mui-navbar-left .mui-center,
        .mui-ios .mui-navbar-left .mui-right {
            opacity: 0;
        }
        .mui-navbar .mui-btn-nav {
            -webkit-transition: none;
            transition: none;
            -webkit-transition-duration: .0s;
            transition-duration: .0s;
        }
        .mui-navbar .mui-bar .mui-title {
            display: inline-block;
            width: auto;
        }
        .mui-page-shadow {
            position: absolute;
            right: 100%;
            top: 0;
            width: 16px;
            height: 100%;
            z-index: -1;
            content: '';
        }
        .mui-page-shadow {
            background: -webkit-linear-gradient(left, rgba(0, 0, 0, 0) 0, rgba(0, 0, 0, 0) 10%, rgba(0, 0, 0, .01) 50%, rgba(0, 0, 0, .2) 100%);
            background: linear-gradient(to right, rgba(0, 0, 0, 0) 0, rgba(0, 0, 0, 0) 10%, rgba(0, 0, 0, .01) 50%, rgba(0, 0, 0, .2) 100%);
        }
        .mui-navbar-inner.mui-transitioning,
        .mui-navbar-inner .mui-transitioning {
            -webkit-transition: opacity 300ms ease, -webkit-transform 300ms ease;
            transition: opacity 300ms ease, transform 300ms ease;
        }
        .mui-page {
            display: none;
        }
        .mui-pages .mui-page {
            display: block;
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
        .mui-table-view-divider {
            background-color: #efeff4;
            font-size: 14px;
        }
        .mui-table-view-divider:before,
        .mui-table-view-divider:after {
            height: 0;
        }



        .mui-fullscreen {
            position: fixed;
            z-index: 20;
            background-color: #000;
        }
        .mui-ios .mui-navbar .mui-bar .mui-title {
            position: static;
        }
    </style>

</head>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
    wx.config({

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
                    <a>报修时间<span class="mui-pull-right"><?php echo date("Y-m-d H:i:s",$info['Fo_time']);?></span></a>
                </li>
                <li class="mui-table-view-cell">
                    <a>处理状态<span class="mui-pull-right"><?php
                            switch ($info['Fo_state']){
                                case 1:
                                    echo "已提交";
                                    break;
                                case 2:
                                    echo "处理中";
                                    break;
                                case 3:
                                    echo "完成";
                                    break;
                                default:
                                    break;
                            }
                            ?></span></a>
                </li>
                <li class="mui-table-view-cell">
                    <a>报修地点<span class="mui-pull-right"><?php echo $address;?></span></a>
                </li>
                <li class="mui-table-view-cell">
                    <a>报修类型<span class="mui-pull-right"><?php echo $info['Fo_type'];?></span></a>
                </li>

            </ul>
            <ul class="mui-card mui-table-view">
                <li class=" mui-table-view-cell mui-collapse">
                    <a class="mui-navigate-right" href="#">报修详情</a>
                    <div class="mui-collapse-content">
                        <p><?php echo $info['Fo_content'];?></p>
                    </div>
                </li>
            </ul>
            <ul class="mui-card mui-table-view">
                <li class=" mui-table-view-cell mui-collapse">
                    <a class="mui-navigate-right" href="#">处理进程</a>
                    <div class="mui-collapse-content">
                        <?php foreach ($fixorderfollow as $data): ?>
                            <p>处理人：<?php echo $this->Wxfixuser_model->getfixusernamebyopenid($data['Fof_fuopenid']);?>&nbsp;<?php echo $data['Fof_message'];?>&nbsp;<?php echo date("Y-m-d H:i:s",$data['Fof_time']);?><hr />
                        <?php endforeach; ?>


                    </div>
                </li>
            </ul>
            <ul class="mui-card mui-table-view">
                <li class="mui-table-view-cell mui-collapse">
                    <a class="mui-navigate-right" href="#">转交</a>
                    <div class="mui-collapse-content">
                        <form class="mui-input-group">
                            <div class="mui-input-row">
                                <label>转交给</label>
                                <select id="fixname">
                                    <option value="">---请选择---</option>
                                    <?php foreach ($fixuser as $data): ?>
                                        <option><?php echo $data['Fu_name'];?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mui-input-row">
                                <label>留言</label>
                                <input id="message" type="text" class="mui-input-clear" placeholder="留言">
                            </div>

                            <div class="mui-button-row">
                                <button id="returnbtn" class="mui-btn mui-btn-primary" type="button">确认</button>

                            </div>
                        </form>
                    </div>
                </li>
                <li class="mui-table-view-cell mui-collapse">
                    <a class="mui-navigate-right" href="#">完成</a>
                    <div class="mui-collapse-content">
                        <form class="mui-input-group">
                            <div class="mui-button-row">
                                <button id="overbtn" class="mui-btn mui-btn-primary" type="button">完成</button>
                            </div>
                        </form>
                    </div>
                </li>

            </ul>

        </div>
    </div>
</div>

</body>
<script type="text/javascript" src="/static/js/mui.min.js" ></script>
<script>
    var addurl = '<?php $url =base_url('fix/api');echo "http://$url";?>';
    var fixname = document.getElementById("fixname");
    var message = document.getElementById("message");
    var returnbtn = document.getElementById("returnbtn");
    var overbtn = document.getElementById("overbtn");

    returnbtn.addEventListener("tap",function(enent) {
        var info = {
            fixname : fixname.value,
            message : message.value
        };
        if (info.fixname == "") {
            mui.toast('请选择转交人',{ duration:'long', type:'div' });
            return;
        }
        mui.post(addurl,{
                key:"addfollow",
                foid:'<?php echo $id;?>',
                fixname:info.fixname,
                message:info.message
            },function(data){
                if(data.state === 'success'){
                    window.location.href=data.link;

                }else{
                    mui.alert(data.message,"注意","确定");
                }


            },'json'
        );

    });

    overbtn.addEventListener("tap",function(enent) {

        mui.post(addurl,{
                key:"overfollow",
                foid:'<?php echo $id;?>',
            },function(data){
                if(data.state === 'success'){
                    window.location.href=data.link;

                }else{
                    mui.alert(data.message,"注意","确定");
                }


            },'json'
        );

    });


</script>
</html>

