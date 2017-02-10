<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <title>评论列表 - 时时评后台管理</title>
        <meta http-equiv="Cache-Control" content="no-transform" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="stylesheet" href="/Public/statics/bootstrap-3.3.5/css/bootstrap.min.css" />
    <link rel="stylesheet" href="/Public/statics/bootstrap-3.3.5/css/bootstrap-theme.min.css" />
    <link rel="stylesheet" href="/Public/statics/font-awesome-4.4.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="/tpl/Public/css/base.css" />
</head>
<body>
<!-- 导航栏开始 -->
<div class="bjy-admin-nav">
    <i class="fa fa-home"></i> 首页
    &gt;
    后台管理
    &gt;
    评论列表
</div>
<!-- 导航栏结束 -->
<ul id="myTab" class="nav nav-tabs" style="margin-top: 15px;">
    <li>
        <a href="<?php echo U('Admin/Posts/index');?>">视频列表</a>
    </li>
    <li class="active">
        <a href="<?php echo U('Admin/Comment/index',array('post_id'=>I('get.post_id')));?>">评论列表</a>
    </li>
</ul>
<form action="<?php echo U('Admin/Posts/order_topic');?>" method="post">
    <table class="table table-bordered table-hover table-condensed table-striped">
        <tr>
            <th>ID</th>
            <th>评论内容</th> 
            <th>点赞量</th>
            <th>评论时间</th>
            <th>操作</th> 
        </tr>
        <?php if(is_array($list)): foreach($list as $key=>$v): ?><tr>
                <td><?php echo ($v['cid']); ?></td>
                <td><?php echo ($v['content']); ?></td>
                <td><?php echo ($v['click_number']); ?></td>
                <td><?php echo ($v['create_time']); ?></td>
                <td>
                    <a href="<?php echo U('Admin/Comment/edit',array('post_id'=>I('get.post_id'),'cid'=>$v['cid']));?>">修改</a>
                    <a href="<?php echo U('Admin/Comment/del',array('post_id'=>I('get.post_id'),'cid'=>$v['cid']));?>">删除</a>
                </td>
            </tr><?php endforeach; endif; ?>
    </table>
</form>
<div class="h-page"><?php echo ($page); ?></div>
<!-- 引入bootstrjs部分开始 -->
<script src="/Public/statics/js/jquery-1.10.2.min.js"></script>
<script src="/Public/statics/bootstrap-3.3.5/js/bootstrap.min.js"></script>
<script src="/tpl/Public/js/base.js"></script>
</body>
</html>