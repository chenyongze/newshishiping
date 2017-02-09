<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <title>用户列表 - bjyadmin</title>
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
    <a href="<?php echo U('Admin/Index/index');?>"><i class="fa fa-home"></i> 首页</a>
    &gt;
    用户列表列表
</div>

<!-- 导航栏结束 -->
<ul id="myTab" class="nav nav-tabs" style="margin-top: 15px;">
    <li class="active" >
         <a href="<?php echo U('Admin/Users/index');?>">用户列表</a>
    </li>
    <li >
         <a href="<?php echo U('Admin/Users/add');?>">用户添加</a>
    </li>
</ul>

<!-- 导航栏结束 -->
<table class="table table-striped table-bordered table-hover table-condensed">
    <tr>
        <th>ID</th> 
        <th>头像</th>
        <th>用户名</th>
        <th>注册时间</th>
        <th>操作</th>
    </tr>
    <?php if(is_array($list)): foreach($list as $key=>$v): ?><tr>
            <td><?php echo ($v['id']); ?></td>
            <td>
                <img src="<?php echo ($v['avatar']); ?>" width="45" height="45">
            </td>
            <td><?php echo ($v['username']); ?></td>
            <td><?php echo date('Y-m-d H:i:s',$v['register_time']);?></td>
            <td>
                <a href="<?php echo U('Admin/Users/del',array('id'=>$v['id']));?>">删除</a>
            </td>
        </tr><?php endforeach; endif; ?>
</table>
<div class="h-page"><?php echo ($page); ?></div>
<!-- 引入bootstrjs部分开始 -->
<script src="/Public/statics/js/jquery-1.10.2.min.js"></script>
<script src="/Public/statics/bootstrap-3.3.5/js/bootstrap.min.js"></script>
<script src="/tpl/Public/js/base.js"></script>
</body>
</html>