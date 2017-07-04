<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: henbf
 * Date: 2017/5/9
 * Time: 17:56
 */
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />

    <title>北京科技大学天津学院</title>

    <meta name="msapplication-TileColor" content="#0e90d2">

    <link type="text/css" href="/static/css/zui.css" rel="stylesheet" />
    <style type="text/css">
        body{width:96%; min-width:240px; padding-left:1%; padding-right:1%;}
        td{border:1px solid #eee; text-align:center;}
        .r{color:#f00;}
        .bt{ border-top:1px solid #000;}
        .cw{border:1px solid red;}
        .cw td{background:#9CF;}
        .cd{font-weight:bold; color:red; background:#FFC;}
        .nofloat{float:none;}
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
<div class="row">
    <div class="col-xs-11 col-sm-7 col-md-6 col-lg-3 center-block nofloat">
        <h3 class="text-center">2016-2017学年校历</h3>
        <div class="dropdown text-center">
            <a id="dLabel" role="button" data-toggle="dropdown" data-target="#" class="text-center">第二学期<span>&nbsp;</span><?php echo "今天是 " . date("Y-m-d");?>
            </a>
            <ul class="dropdown-menu" role="menu" aria-labelledby="dropupMenu1">
                <li>
                    <a>第二学期</a>
                </li>
            </ul>
        </div>

        <table width="100%"  class="table_form">
            <tr>
                <td>周</td>
                <td>月份</td>
                <td>一</td>
                <td>二</td>
                <td>三</td>
                <td>四</td>
                <td>五</td>
                <td>六</td>
                <td class="r">日</td>
                <td>14-16级</td>
            </tr>
            <!--2017年3月  3-6周   Start-->
            <tr>
                <td class="r bt">3</td>
                <td rowspan="4" style="background:#fff;">2017年<br />3月</td>

                <td class=" bt">6</td>
                <td class=" bt">7</td>
                <td class=" bt">8</td>
                <td class=" bt">9</td>
                <td class=" bt">10</td>
                <td class=" bt">11</td>
                <td class="r bt">12</td>
                <td class="bt" rowspan="18" style="background:#fff;">上<br />课<br />16<br />周<br />（<br />含<br />放<br />假<br />）</td>
            </tr>


            <tr>
                <td class="r">4</td>

                <td class="">13</td>
                <td class="">14</td>
                <td class="">15</td>
                <td class="">16</td>
                <td class="">17</td>
                <td class="">18</td>
                <td class="r">19</td>
            </tr>
            <tr>
                <td class="r">5</td>

                <td class="">20</td>
                <td class="">21</td>
                <td class="">22</td>
                <td class="">23</td>
                <td class="">24</td>
                <td class="">25</td>
                <td class="r">26</td>
            </tr>
            <tr>
                <td class="r">6</td>

                <td class="">27</td>
                <td class="">28</td>
                <td class="">29</td>
                <td class="">30</td>
                <td class="">31</td>
                <td class="">&nbsp;</td>
                <td class="r">&nbsp;</td>
            </tr>
            <!--2017年3月  3-6周   End-->
            <!--2017年4月   6-11周   Start-->
            <tr>
                <td class="r bt">6</td>
                <td rowspan="5" style="background:#fff;">2017年<br />4月</td>

                <td class=" bt">&nbsp;</td>
                <td class=" bt">&nbsp;</td>
                <td class=" bt">&nbsp;</td>
                <td class=" bt">&nbsp;</td>
                <td class=" bt">&nbsp;</td>
                <td class=" bt">1</td>
                <td class="r bt">2</td>
            </tr>


            <tr>
                <td class="r">7</td>

                <td class="">3</td>
                <td class="">4</td>
                <td class="">5</td>
                <td class="">6</td>
                <td class="">7</td>
                <td class="">8</td>
                <td class="r">9</td>
            </tr>


            <tr>
                <td class="r">8</td>

                <td class="">10</td>
                <td class="">11</td>
                <td class="">12</td>
                <td class="">13</td>
                <td class="">14</td>
                <td class="">15</td>
                <td class="r">16</td>
            </tr>


            <tr>
                <td class="r">9</td>

                <td class="">17</td>
                <td class="">18</td>
                <td class="">19</td>
                <td class="">20</td>
                <td class="">21</td>
                <td class="">22</td>
                <td class="r">23</td>
            </tr>


            <tr>
                <td class="r">10</td>

                <td class="">24</td>
                <td class="">25</td>
                <td class="">26</td>
                <td class="">27</td>
                <td class="">28</td>
                <td class="">29</td>
                <td class="r">30</td>
            </tr>

            <!--2017年4月   6-10周   End-->
            <!--2017年5月   11-15周   Start-->
            <tr>
                <td class="r bt">11</td>
                <td rowspan="5" style="background:#fff;">2017年<br />5月</td>

                <td class=" bt">1</td>
                <td class=" bt">2</td>
                <td class=" bt">3</td>
                <td class=" bt">4</td>
                <td class=" bt">5</td>
                <td class=" bt">6</td>
                <td class="r bt">7</td>
            </tr>


            <tr>
                <td class="r">12</td>

                <td class="">8</td>
                <td class="">9</td>
                <td class="">10</td>
                <td class="">11</td>
                <td class="">12</td>
                <td class="">13</td>
                <td class="r">14</td>
            </tr>


            <tr>
                <td class="r">13</td>

                <td class="">15</td>
                <td class="">16</td>
                <td class="">17</td>
                <td class="">18</td>
                <td class="">19</td>
                <td class="">20</td>
                <td class="r">21</td>
            </tr>


            <tr class="cw">
                <td class="r">14</td>

                <td class="">22</td>
                <td class="">23</td>
                <td class="">24</td>
                <td class="">25</td>
                <td class="">26</td>
                <td class="">27</td>
                <td class="r">28</td>
            </tr>


            <tr>
                <td class="r">15</td>

                <td class="">29</td>
                <td class="">30</td>
                <td class="">31</td>
                <td class="">&nbsp;</td>
                <td class="">&nbsp;</td>
                <td class="">&nbsp;</td>
                <td class="r">&nbsp;</td>
            </tr>
            <!--2017年5月   11-15周   End-->

            <!--2017年6月   15-19周   Start-->
            <tr>
                <td class="r bt">15</td>
                <td rowspan="5" style="background:#fff;">2017年<br />6月</td>

                <td class=" bt">&nbsp;</td>
                <td class=" bt">&nbsp;</td>
                <td class=" bt">&nbsp;</td>
                <td class=" bt">1</td>
                <td class=" bt">2</td>
                <td class=" bt">3</td>
                <td class="r bt">4</td>
            </tr>


            <tr>
                <td class="r">16</td>

                <td class="">5</td>
                <td class="">6</td>
                <td class="">7</td>
                <td class="">8</td>
                <td class="">9</td>
                <td class="">10</td>
                <td class="r">11</td>
            </tr>
            <tr>
                <td class="r">17</td>
                <td class="">12</td>
                <td class="">13</td>
                <td class="">14</td>
                <td class="">15</td>
                <td class="">16</td>
                <td class="">17</td>
                <td class="r">18</td>
            </tr>
            <tr>
                <td class="r">18</td>
                <td class="">19</td>
                <td class="">20</td>
                <td class="">21</td>
                <td class="">22</td>
                <td class="">23</td>
                <td class="">24</td>
                <td class="r">25</td>
            </tr>
            <tr >
                <td class="r bt " style="background:AliceBlue;">19</td>
                <td class=""  style="background:AliceBlue;">26</td>
                <td class=""  style="background:AliceBlue;">27</td>
                <td class="" style="background:AliceBlue;">28</td>
                <td class="" style="background:AliceBlue;">29</td>
                <td class="" style="background:AliceBlue;">30</td>
                <td class="" style="background:AliceBlue;">&nbsp;</td>
                <td class="r" style="background:AliceBlue;">&nbsp;</td>
                <td class="r bt" rowspan="2" style="background:AliceBlue;">考试</td>
            </tr>
            <!--2017年6月   15-19周   End-->
            <!--2017年7月   Start -->
            <tr>
                <td class="r bt" style="background:AliceBlue;">19</td>
                <td rowspan="6" style="background:#fff;">2017年<br />7月</td>
                <td class=" bt" style="background:AliceBlue;">&nbsp;</td>
                <td class=" bt" style="background:AliceBlue;">&nbsp;</td>
                <td class=" bt" style="background:AliceBlue;">&nbsp;</td>
                <td class=" bt" style="background:AliceBlue;">&nbsp;</td>
                <td class=" bt" style="background:AliceBlue;">&nbsp;</td>
                <td class=" bt" style="background:AliceBlue;">1</td>
                <td class="r bt" style="background:AliceBlue;">2</td>
            </tr>
            <!--   实训四周   Start-->
            <tr>
                <td class="r">1</td>
                <td class="">3</td>
                <td class="">4</td>
                <td class="">5</td>
                <td class="">6</td>
                <td class="">7</td>
                <td class="">8</td>
                <td class="r">9</td><td class="bt" rowspan="4" style="background:#fff;">实训4周</td>
            </tr>
            <tr>
                <td class="r">2</td>
                <td class="">10</td>
                <td class="">11</td>
                <td class="">12</td>
                <td class="">13</td>
                <td class="">14</td>
                <td class="">15</td>
                <td class="r">16</td>
            </tr>
            <tr>
                <td class="r">3</td>
                <td class="">17</td>
                <td class="">18</td>
                <td class="">19</td>
                <td class="">20</td>
                <td class="">21</td>
                <td class="">22</td>
                <td class="r">23</td>
            </tr>
            <tr>
                <td class="r">4</td>
                <td class="">24</td>
                <td class="">25</td>
                <td class="">26</td>
                <td class="">27</td>
                <td class="">28</td>
                <td class="">29</td>
                <td class="r">30</td>
            </tr>
            <!--2017年7月   实训四周   End-->
            <tr>
                <td class="r">1</td>
                <td class="">31</td>
                <td class="">&nbsp;</td>
                <td class="">&nbsp;</td>
                <td class="">&nbsp;</td>
                <td class="">&nbsp;</td>
                <td class="">&nbsp;</td>
                <td class="r">&nbsp;</td><td class="bt" rowspan="7" style="background:#fff;">暑假5周</td>
            </tr>
            <!--2017年7月   End -->
            <!--2017年8月   Start -->
            <tr>
                <td class="r bt">1</td>
                <td rowspan="5" style="background:#fff;">2017年<br />8月</td>
                <td class=" bt">&nbsp;</td>
                <td class=" bt">1</td>
                <td class=" bt">2</td>
                <td class=" bt">3</td>
                <td class=" bt">4</td>
                <td class=" bt">5</td>
                <td class="r bt">6</td>
            </tr>
            <tr>
                <td class="r">2</td>
                <td class="">7</td>
                <td class="">8</td>
                <td class="">9</td>
                <td class="">10</td>
                <td class="">11</td>
                <td class="">12</td>
                <td class="r">13</td>
            </tr>
            <tr>
                <td class="r">3</td>
                <td class="">14</td>
                <td class="">15</td>
                <td class="">16</td>
                <td class="">17</td>
                <td class="">18</td>
                <td class="">19</td>
                <td class="r">20</td>
            </tr>
            <tr>
                <td class="r">4</td>
                <td class="">21</td>
                <td class="">22</td>
                <td class="">23</td>
                <td class="">24</td>
                <td class="">25</td>
                <td class="">26</td>
                <td class="r">27</td>
            </tr>
            <tr>
                <td class="r">5</td>

                <td class="">28</td>
                <td class="">29</td>
                <td class="">30</td>
                <td class="">31</td>
                <td class="">&nbsp;</td>
                <td class="">&nbsp;</td>
                <td class="r">&nbsp;</td>
            </tr>
            <tr>
                <td class="r bt">5</td>
                <td rowspan="5" style="background:#fff;">9月</td>
                <td class="">&nbsp;</td>
                <td class="">&nbsp;</td>
                <td class="">&nbsp;</td>
                <td class="">&nbsp;</td>
                <td class="">1</td>
                <td class="">2</td>
                <td class="r">3</td>
            </tr>
        </table>
        <p style="text-indent:2em;color: #0a67fb">5月27日上星期二的课，5月28-30日端午节放假。</p>
        <p style="text-indent:2em; color: #929292" align="center">© 2017 北京科技大学天津学院智慧校园</p>
    </div>
</div>
</body>
</html>

