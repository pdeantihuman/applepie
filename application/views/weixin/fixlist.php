<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: henbf
 * Date: 2017/5/12
 * Time: 19:55
 * 用户的维修记录
 */
?>
<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <title></title>
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <link href="/static/css/mui.min.css" rel="stylesheet" />
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
<div class="mui-content">
    <div class="mui-card" style="margin-bottom: 35px;">
        <ul class="mui-table-view">
            <?php foreach ($list as $data): ?>
            <li class="mui-table-view-cell">
                <a class="mui-navigate-right" href="<?php $url =base_url('fix/fixinfobyid').'/'.$data['Foid'];echo "http://$url";?>">
                    <?php
                        switch ($data['Fo_state']){
                            case 1:
                                echo "<span class='mui-badge mui-badge-primary'>已提交</span>";break;
                            case 2:
                                echo "<span class='mui-badge mui-badge-primary'>处理中</span>";break;
                            case 3:
                                echo "<span class='mui-badge mui-badge-success'>完成</span>";break;
                            default:
                                break;
                        }
                        ?>
                    <?php echo date("Y-m-d H:i:s",$data['Fo_time']);?>
                </a>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
