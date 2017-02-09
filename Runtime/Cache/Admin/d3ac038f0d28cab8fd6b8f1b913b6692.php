<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <title>后台登录 - 时时评</title>
        <meta http-equiv="Cache-Control" content="no-transform" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="stylesheet" href="/Public/statics/bootstrap-3.3.5/css/bootstrap.min.css" />
    <link rel="stylesheet" href="/Public/statics/bootstrap-3.3.5/css/bootstrap-theme.min.css" />
    <link rel="stylesheet" href="/Public/statics/font-awesome-4.4.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="/tpl/Public/css/base.css" />
    <link rel="stylesheet" type="text/css" href="/tpl/Admin/Public/css/login.css" />
</head>
<body>
    <div class="login-box">
        <form action="<?php echo U('Admin/Login/login');?>" method="post">
            <input type="text" class="form-control modal-sm" name="username" placeholder="请输入用户名">
            <input type="password" class="form-control modal-sm" name="password" placeholder="请输入密码">
            <input type="text" class="form-control modal-sm" name="verify_code" placeholder="请输入验证码">
            <img src="<?php echo U('Admin/Login/verify_code');?>" onclick="this.src+='/'+Math.random();">
            <input type="submit" class="btn btn-default" id="login-post" value="登陆">
        </form>
    </div>
<!-- 引入bootstrjs部分开始 -->
<script src="/Public/statics/js/jquery-1.10.2.min.js"></script>
<script src="/Public/statics/bootstrap-3.3.5/js/bootstrap.min.js"></script>
<script src="/tpl/Public/js/base.js"></script>
</body>
</html>