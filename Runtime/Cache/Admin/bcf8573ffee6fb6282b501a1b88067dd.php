<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <title>话题列表 - bjyadmin</title>
        <meta http-equiv="Cache-Control" content="no-transform" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="stylesheet" href="/Public/statics/bootstrap-3.3.5/css/bootstrap.min.css" />
    <link rel="stylesheet" href="/Public/statics/bootstrap-3.3.5/css/bootstrap-theme.min.css" />
    <link rel="stylesheet" href="/Public/statics/font-awesome-4.4.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="/tpl/Public/css/base.css" />
    <style type="text/css">
        .lqk-count{
            line-height: 36px;
            text-align: right;
            padding-right: 30px;
            font-size: 14px;
        }
        .lqk-number{
            padding: 0 5px;
            color: #D15B47;
        }
    </style>
</head>
<body>

<!-- 导航栏开始 -->
<div class="bjy-admin-nav">
    <i class="fa fa-home"></i> 首页
    &gt;
    后台管理
    &gt;
    视频列表
</div>
<!-- 导航栏结束 -->
<ul id="myTab" class="nav nav-tabs" style="margin-top: 15px;">
   <li class="active">
         <a href="<?php echo U('Admin/Posts/index');?>" data-toggle="tab">视频列表</a>
   </li>
   <li>
        <a href="<?php echo U('Admin/Posts/add');?>">添加视频</a>
    </li>
</ul>
<form action="<?php echo U('Admin/Posts/order_topic');?>" method="post">
    <table class="table table-bordered table-hover table-condensed table-striped">
        <tr>
            <th>ID</th>
            <th>标题</th> 
            <th>封面图</th>
            <th>点赞量</th>
            <th>发布时间</th>
            <th>操作</th> 
        </tr>
        <?php if(is_array($list)): foreach($list as $key=>$v): ?><tr>
                <td><?php echo ($v['post_id']); ?></td>
                <td><?php echo ($v['title']); ?></td>
                <td>
                    <img src="<?php echo ($v['cover_path']); ?>" width="100" height="50">
                </td>
                <td><?php echo ($v['click_number']); ?></td>
                <td><?php echo ($v['create_time']); ?></td>
                <td>
                    <a href="<?php echo U('Admin/Comment/add',array('post_id'=>$v['post_id']));?>">添加评论</a>
                    <a href="<?php echo U('Admin/Comment/list',array('post_id'=>$v['post_id']));?>">查看评论</a>
                    <a href="<?php echo U('Admin/Posts/edit',array('post_id'=>$v['post_id']));?>">修改</a>
                    <a href="<?php echo U('Admin/Posts/del',array('post_id'=>$v['post_id']));?>">删除</a>
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