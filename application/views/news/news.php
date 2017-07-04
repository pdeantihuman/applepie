<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * User: 张昱
 * Date: 2017/5/25
 * Time: 23:38
 * Email: henbf@vip.qq.com
 * 新闻内容页面
 */
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link href="https://cdn.bootcss.com/jquery-mobile/1.3.2/jquery.mobile.css" rel="stylesheet">
    <script src="/static/news/js/jquery-1.8.3.min.js"></script>
    <script src="https://cdn.bootcss.com/jquery-mobile/1.3.2/jquery.mobile.js"></script>
</head>
<body style="font-size:16px">

<div data-role="page"  data-theme="d">
    <div data-role="header" data-theme="c" data-position="fixed">
        <a href="/news/news/tag/<?php echo $news['N_Ntid'];?>" data-role="button" data-icon="back">返回</a>
<!--        <h1></h1>-->
        <h1><?php echo $news['N_name'];?></h1>
    </div>

    <div data-role="content">
        <?php echo $news['N_content'];?>
    </div>
    <div data-role="footer" data-theme="d" data-position="fixed">
        <h6>北京科技大学天津学院智慧校园</h6>
    </div>
</div>
</body>
</html>
