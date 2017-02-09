<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, minimal-ui">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta http-equiv="Cache-Control" content="no-transform" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <title>后台登录</title>
    <link rel="stylesheet" type="text/css" href="/tpl/Public/css/base.css" />
        <meta http-equiv="Cache-Control" content="no-transform" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="stylesheet" href="/Public/statics/bootstrap-3.3.5/css/bootstrap.min.css" />
    <link rel="stylesheet" href="/Public/statics/bootstrap-3.3.5/css/bootstrap-theme.min.css" />
    <link rel="stylesheet" href="/Public/statics/font-awesome-4.4.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="/tpl/Public/css/base.css" />
    <style type="text/css">
        #lqk-body{
            background: #1E3040;
        }
        .login-box{
            margin: 150px auto 0;
            width: 300px;
        }
        input {
            margin: 10px 0;
        }
        #login-post {
            float: right;
            margin-top: 2px;
            width: 100px;
        }
        img {
            cursor: pointer;
        }
    </style>

</head>
<body id="lqk-body">
    
    <div class="login-box">
        <form action="<?php echo U('User/Login/login');?>" method="post">
            <input class="form-control modal-sm" type="text" placeholder="请输入用户名" name="username">
            <input class="form-control modal-sm" type="password" placeholder="请输入密码" name="password">
            <input class="form-control modal-sm" type="text" placeholder="请输入验证码" name="verify_code">
            <img onclick="this.src+='/'+Math.random();" src="/index.php/User/Login/verify_code">
            <input type="submit" value="登录" class="btn btn-default" id="login-post"> 
        </form>
    </div>

<!-- 引入bootstrjs部分开始 -->
<script src="/Public/statics/js/jquery-1.10.2.min.js"></script>
<script src="/Public/statics/bootstrap-3.3.5/js/bootstrap.min.js"></script>
<script src="/tpl/Public/js/base.js"></script>
</body>
</html>