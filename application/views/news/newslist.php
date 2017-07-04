<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * User: 张昱
 * Date: 2017/5/25
 * Time: 23:00
 * Email: henbf@vip.qq.com
 * 新闻罗列标题页面
 */
?>

<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link href="https://cdn.bootcss.com/jquery-mobile/1.3.2/jquery.mobile.css" rel="stylesheet">
    <script src="/static/news/js/jquery-1.8.3.min.js"></script>
    <script src="https://cdn.bootcss.com/jquery-mobile/1.3.2/jquery.mobile.js"></script>
</head>
<body>
<div data-role="page" data-theme="d">
    <div data-role="header" data-theme="d" data-position="fixed">
        <a href="/news/news/" data-role="button" data-icon="back">返回</a>
        <h4><?php echo $title['Nt_name'];?></h4>
    </div>
    <div data-role="content" data-theme="d">
        <ul data-role="listview" data-inset="false">
            <?php foreach ($list as $data): ?>
            <li>
                <a href="../doc/<?php echo $data['Nid'];?>">
                    <h5><?php echo $data['N_name'];?></h5>
                </a>
            </li>
            <?php endforeach; ?>
        </ul>

    </div>
    <div data-role="footer" data-theme="d" data-position="fixed">
        <h6>北京科技大学天津学院智慧校园</h6>
    </div>
    <div>
</body>
</html>

