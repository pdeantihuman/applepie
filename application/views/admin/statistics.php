<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: henbf
 * Date: 2017/5/23
 * Time: 17:44
 * 用户数据统计分析
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>数据统计</title>
    <link rel="stylesheet" href="/static/admin/frame/layui/css/layui.css">
    <link rel="stylesheet" href="/static/admin/css/style.css">
</head>
<body class="body">

<!-- 为 ECharts 准备一个具备大小（宽高）的 DOM -->

    <div id="main-bing" style="width: 50%;height:400px;float:left;"></div>
    <div id="main-garde" style="width: 50%;height:400px;float:left;"></div>
    <div id="count-bind" style="width: 50%;height:400px;float:left;"></div>


<script type="text/javascript" src="/static/admin/frame/layui/layui.js"></script>
<script type="text/javascript" src="/static/admin/frame/echarts/echarts.min.js"></script>
<script type="text/javascript">
    // 基于准备好的dom，初始化echarts实例
    var chart = echarts.init(document.getElementById('main-bing'));
    // 配置
    chart.setOption({
        title : {
            text: '男女人数',
            subtext: '统计图',
            x:'center'
        },
        tooltip : {
            trigger: 'item',
            formatter: "{a} <br/>{b} : {c} ({d}%)"
        },
        series : [
            {
                name: '人数',
                type: 'pie',
                radius : '55%',
                center: ['50%', '60%'],
                data:[
                    {value:<?php echo $man;?>, name:'男'},
                    {value:<?php echo $woman;?>, name:'女'}
                ],
                itemStyle: {
                    emphasis: {
                        shadowBlur: 10,
                        shadowOffsetX: 0,
                        shadowColor: 'rgba(0, 0, 0, 0.5)'
                    }
                }
            }
        ]
    });

    var chart = echarts.init(document.getElementById('count-bind'));
    // 配置
    chart.setOption({
        title : {
            text: '验证用户统计',
            subtext: '统计图',
            x:'center'
        },
        tooltip : {
            trigger: 'item',
            formatter: "{a} <br/>{b} : {c} ({d}%)"
        },
        series : [
            {
                name: '人数',
                type: 'pie',
                radius : '55%',
                center: ['50%', '60%'],
                data:[
                    {value:<?php echo $binded;?>, name:'已绑定'},
                    {value:<?php echo $nobinded;?>, name:'未绑定'}
                ],
                itemStyle: {
                    emphasis: {
                        shadowBlur: 10,
                        shadowOffsetX: 0,
                        shadowColor: 'rgba(0, 0, 0, 0.5)'
                    }
                }
            }
        ]
    });
    var garde = echarts.init(document.getElementById('main-garde'));

    garde.setOption({
        title : {
            text: '年级人数',
            subtext: '统计图',
            x:'center'
        },
        color: ['#3398DB'],
        tooltip : {
            trigger: 'axis',
            axisPointer : {            // 坐标轴指示器，坐标轴触发有效
                type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
            }
        },
        grid: {
            left: '3%',
            right: '4%',
            bottom: '3%',
            containLabel: true
        },
        xAxis : [
            {
                type : 'category',
                data : ['14级', '15级', '16级'],
                axisTick: {
                    alignWithLabel: true
                }
            }
        ],
        yAxis : [
            {
                type : 'value'
            }
        ],
        series : [
            {
                name:'人数',
                type:'bar',
                barWidth: '60%',
                data:[<?php echo $garde14;?>, <?php echo $garde15;?>, <?php echo $garde16;?>]

            }
        ]
    })

    layui.use(['element'], function(){
        var $ = layui.jquery,element = layui.element;

        // you code ...

    });

</script>
</body>
</html>

