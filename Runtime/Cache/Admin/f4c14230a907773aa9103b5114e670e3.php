<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <title>视频分类列表 — 时时评后台管理</title>
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
    分类列表
</div>
<!-- 导航栏结束 -->
<ul id="myTab" class="nav nav-tabs" style="margin-top: 15px;">
    <li class="active" >
         <a href="<?php echo U('Admin/PostsCategory/index');?>">分类列表</a>
    </li>
    <li >
         <a href="<?php echo U('Admin/PostsCategory/add');?>">分类添加</a>
    </li>
</ul>
<form action="" method="post" enctype="multipart/form-data" class="form-inline">
    <table class="table table-bordered table-condensed">
        <tr>
            <th>ID</th>
            <td>分类名</td>
            <td>添加时间</td>
            <td>修改时间</td>
            <td>操作</td>
        </tr>
        <?php if(is_array($list)): foreach($list as $key=>$v): ?><tr>
            <td><?php echo ($v['cate_id']); ?></td>
            <td><?php echo ($v['name']); ?></td>
            <td><?php echo ($v['create_time']); ?></td>
            <td><?php echo ($v['update_time']); ?></td>
            <td>
                <a href="<?php echo U('Admin/PostsCategory/edit',array('cate_id'=>$v['cate_id']));?>">修改</a>
                <a href="<?php echo U('Admin/PostsCategory/del',array('cate_id'=>$v['cate_id']));?>">删除</a>
            </td>
        </tr><?php endforeach; endif; ?>
    </table>   
</form>
<!-- 引入bootstrjs部分开始 -->
<script src="/Public/statics/js/jquery-1.10.2.min.js"></script>
<script src="/Public/statics/bootstrap-3.3.5/js/bootstrap.min.js"></script>
<script src="/tpl/Public/js/base.js"></script>
</body>
</html>