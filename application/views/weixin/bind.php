<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: henbf
 * Date: 2017/5/8
 * Time: 10:04
 */
?>
<!DOCTYPE html>
<html class="ui-page-login">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title></title>
    <link href="/static/css/mui.min.css" rel="stylesheet" />
    <link href="/static/css/style.css" rel="stylesheet" />
    <style>
        .area {
            margin: 20px auto 0px auto;
        }
        .mui-input-group:first-child {
            margin-top: 20px;
        }
        .mui-input-group label {
            width: 30%;
        }
        .mui-input-row label~input,
        .mui-input-row label~select,
        .mui-input-row label~textarea {
            width: 70%;
        }
        .mui-checkbox input[type=checkbox],
        .mui-radio input[type=radio] {
            top: 6px;
        }
        .mui-content-padded {
            margin-top: 25px;
        }
        .mui-btn {
            padding: 10px;
        }

    </style>
</head>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>wx.config({});wx.ready(function(){wx.hideOptionMenu();});</script>
<body>
<header class="mui-bar mui-bar-nav">

    <h1 class="mui-title">绑定</h1>
</header>
<div class="mui-content">
    <form class="mui-input-group">
        <div class="mui-input-row">
            <label>姓名</label>
            <input id='uname' type="text" class="mui-input-clear mui-input" placeholder="请输入姓名">
        </div>
        <div class="mui-input-row">
            <label>学号</label>
            <input id='schoolcar' type="number" class="mui-input-clear mui-input" placeholder="请输入学号">
        </div>
        <div class="mui-input-row">
            <label>身份证</label>
            <input id='card' type="text" class="mui-input-clear mui-input" placeholder="输入身份证号(尾号X大写)">
        </div>
        <div class="mui-input-row">
            <label>手机号</label>
            <input id='tel' type="number" class="mui-input-clear mui-input" placeholder="手机号">
        </div>
        <div class="mui-input-row">
            <label>斋号</label>
            <input id='zainum' type="number" class="mui-input-clear mui-input" placeholder="请输入斋号">
        </div>
        <div class="mui-input-row">
            <label>宿舍号</label>
            <input id='ssnum' type="number" class="mui-input-clear mui-input" placeholder="请输入宿舍号">
        </div>
        <div class="mui-input-row">
            <label>班级</label>
            <input id='class' type="number" class="mui-input-clear mui-input" placeholder="例如：1601">
        </div>
        <div class="mui-input-row">
            <label>性别</label>
            <select class="mui-select" id="sex">
                <option value="">---请选择---</option>
                <option value="男">男</option>
                <option value="女">女</option>
            </select>
        </div>
        <div class="mui-input-row">
            <label>专业</label>
            <select class="mui-select" id="major">
                <option value="">---请选择---</option>
                <?php foreach ($profession as $data): ?>
                    <option><?php echo $data['Sp_name'];?></option>
                <?php endforeach; ?>
<!--                <option>土木工程（工程造价管理）</option>-->
<!--                <option>土木工程（道路桥梁工程）</option>-->
<!--                <option>材料科学与工程</option>-->
<!--                <option>机械工程</option>-->
<!--                <option>计算机科学与技术</option>-->
<!--                <option>通信工程</option>-->
<!--                <option>自动化</option>-->
<!--                <option>国际经济与贸易</option>-->
<!--                <option>金融工程</option>-->
<!--                <option>会计学</option>-->
<!--                <option>财务管理</option>-->
<!--                <option>法学</option>-->
<!--                <option>英语</option>-->
<!--                <option>视觉传达设计</option>-->
<!--                <option>音乐表演（声乐演唱）</option>-->
<!--                <option>音乐表演（钢琴演奏）</option>-->
            </select>
        </div>
        <div class="mui-input-row">
            <label>实验班</label>
            <select class="mui-select" id="shiyanban">
                <option value="">---请选择---</option>
                <option value="否">否</option>
                <option value="是">是</option>
            </select>
        </div>
        <div class="mui-input-row">
            <label>辅导员</label>
            <select class="mui-select" id="fuzu">
                <option value="">---请选择---</option>
                <?php foreach ($instructor as $data): ?>
                    <option><?php echo $data['Si_name'];?></option>
                <?php endforeach; ?>
<!--                <option>李光</option>-->
<!--                <option>陈月</option>-->
<!--                <option>潘柏夷</option>-->
<!--                <option>周少华</option>-->
<!--                <option>尤文婷</option>-->
<!--                <option>吴思</option>-->
<!--                <option>王研</option>-->
<!--                <option>张莉</option>-->
<!--                <option>朱嘉阳</option>-->
<!--                <option>刘洋</option>-->
<!--                <option>田勇</option>-->
<!--                <option>张丽荣</option>-->
<!--                <option>唐甜</option>-->
<!--                <option>王堃</option>-->
<!--                <option>林小茹</option>-->
<!--                <option>陈柏霖</option>-->
<!--                <option>赵怡</option>-->
<!--                <option>张添善</option>-->
<!--                <option>赵鑫</option>-->
<!--                <option>李洋</option>-->
<!--                <option>郑妍</option>-->
<!--                <option>殷实</option>-->
<!--                <option>何欢欢</option>-->
<!--                <option>汪佳懿</option>-->
<!--                <option>李原林</option>-->
<!--                <option>任兆欢</option>-->
<!--                <option>闫谡</option>-->
<!--                <option>孟祥宇</option>-->
<!--                <option>李海哲</option>-->
<!--                <option>朱云鹏</option>-->
<!--                <option>孙超</option>-->
<!--                <option>盛鑫娜</option>-->
            </select>
        </div>

    </form>
    <div class="mui-content-padded">
        <button id='reg' class="mui-btn mui-btn-block mui-btn-primary">注册</button>
    </div>
</div>
<script src="/static/js/mui.min.js"></script>
<script>
    var addurl = '<?php $url =base_url('bindApi');echo "http://$url";?>';
</script>
<script>
    mui.init();
    var uname = document.getElementById("uname");
    var schoolcar = document.getElementById("schoolcar");
    var card = document.getElementById("card");
    var sex = document.getElementById("sex");
    var major = document.getElementById("major");
    var classid = document.getElementById("class");
    var fuzu = document.getElementById("fuzu");
    var zainum = document.getElementById("zainum");
    var ssnum = document.getElementById("ssnum");
    var tel = document.getElementById("tel");
    var shiyanban =document.getElementById("shiyanban");



    var btn = document.getElementById("reg");
    btn.addEventListener("tap",function(enent) {
        var userInfo = {
            uname : uname.value,
            schoolcar : schoolcar.value,
            card : card.value,
            sex : sex.value,
            major : major.value,
            classid : classid.value,
            fuzu : fuzu.value,
            zainum : zainum.value,
            ssnum : ssnum.value,
            shiyanban : shiyanban.value,
            tel : tel.value

        };
        if (userInfo.uname == "") {
            mui.toast('请输入姓名',{ duration:'long', type:'div' });
            return;
        }
        if (userInfo.schoolcar == "") {
            mui.toast('请输入学号',{ duration:'long', type:'div' });
            return;
        }
        if (userInfo.card == "") {
            mui.toast('请输入身份证号',{ duration:'long', type:'div' });
            return;
        }

        if (userInfo.card.length !=18) {
            mui.toast('请输入正确的身份证号',{ duration:'long', type:'div' });
            return;
        }
        if (userInfo.tel == "") {
            mui.toast('请输入手机号',{ duration:'long', type:'div' });
            return;
        }
        if (userInfo.tel.length !=11) {
            mui.toast('请输入正确的手机号',{ duration:'long', type:'div' });
            return;
        }
        if (userInfo.zainum =="") {
            mui.toast('请输入斋号',{ duration:'long', type:'div' });
            return;
        }
        if (userInfo.ssnum =="") {
            mui.toast('请输入宿舍号',{ duration:'long', type:'div' });
            return;
        }
        if (userInfo.classid == "") {
            mui.toast('请输入班级',{ duration:'long', type:'div' });
            return;
        }
        if (userInfo.classid.length != 4) {
            mui.toast('请输入正确的班级',{ duration:'long', type:'div' });
            return;
        }
        if (userInfo.sex == "") {
            mui.toast('请选择性别',{ duration:'long', type:'div' });
            return;
        }
        if (userInfo.major == "") {
            mui.toast('请选择专业',{ duration:'long', type:'div' });
            return;
        }
        if (userInfo.shiyanban == "") {
            mui.toast('请选择是否为实验班',{ duration:'long', type:'div' });
            return;
        }
        if (userInfo.fuzu == "") {
            mui.toast('请选择你的辅导员',{ duration:'long', type:'div' });
            return;
        }





        mui.post(addurl,{
                name:userInfo.uname,
                number:userInfo.schoolcar,
                card:userInfo.card,
                sex:userInfo.sex,
                major:userInfo.major,
                classid:userInfo.classid,
                fuzu:userInfo.fuzu,
                zainum:userInfo.zainum,
                ssnum:userInfo.ssnum,
                tel:userInfo.tel,
                shiyanban:userInfo.shiyanban
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
