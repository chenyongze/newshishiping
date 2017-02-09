<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <title>话题列表 — 时时评后台管理</title>
        <meta http-equiv="Cache-Control" content="no-transform" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="stylesheet" href="/Public/statics/bootstrap-3.3.5/css/bootstrap.min.css" />
    <link rel="stylesheet" href="/Public/statics/bootstrap-3.3.5/css/bootstrap-theme.min.css" />
    <link rel="stylesheet" href="/Public/statics/font-awesome-4.4.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="/tpl/Public/css/base.css" />
    <link rel="stylesheet" href="/tpl/Admin/Public/css/posts.css">
</head>
<body>

<!-- 导航栏开始 -->
<div class="bjy-admin-nav">
    <i class="fa fa-home"></i> 首页
    &gt;
    后台管理
    &gt;
    添加评论
</div>

<!-- 导航栏结束 -->
<ul id="myTab" class="nav nav-tabs" style="margin-top: 15px;">
    <li>
        <a href="<?php echo U('Admin/Posts/index');?>">视频列表</a>
    </li>
    <li>
        <a href="<?php echo U('Admin/Comment/list',array('post_id'=>I('get.post_id')));?>">评论列表</a>
    </li>
   <li class="active" >
        <a href="<?php echo U('Admin/Comment/add',array('post_id'=>I('get.post_id')));?>">添加评论</a>
   </li>
</ul>

<form action="" method="post" enctype="multipart/form-data" class="form-inline post-submit" enctype="multipart/form-data">
    <table class="table table-bordered table-condensed">
        <tr>
            <th>
                <div style="padding: 8px 0;">点赞数量</div>
                <br>
                评论内容
            </th>
            <td>
                <input type="text" class="form-control" style="margin-bottom: 5px;" name="click_number" placeholder="请输入点赞数量">                
                <textarea name="content" cols="70" rows="18" class="form-control" placeholder="请输入评论内容"></textarea>
            </td>
            <th>选择用户</th>
            <td class="lqk-add-salary" width="40%">
                 <div class="form-group col-sm-10">
                    <label class="sr-only" for="name">名称</label>
                    <input type="text" class="form-control" placeholder="请输入用户名" style="width:100%" v-model="username">
                </div>
                <div class="col-sm-2">
                    <button type="button" class="btn btn-default btn-sm" v-on:click="SalaryVue">搜索</button>
                </div>
                <div class="sl-out-frame">
                    <div class="sl-insert-frame">
                        <ul class="sl-insert-ul">
                            <li class="sl-insert-li" v-for="item in vuelist">
                                <div class="sl-insert-ship">
                                    <label :for="item.lot_id" style="display: inline;font-weight: 400;">
                                    <div class="col-sm-10">
                                        <img src="" v-bind:src="item.avatar" width="40" height="40" style="margin: 3px;">
                                        <i class="lqk-ul-name"  v-text="item.username"></i>
                                    </div>
                                    </label>
                                    <div class="col-sm-2">
                                        <input type="radio" name="uid" :value="item.id">
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="3"></td>
            <td>
                <input type="hidden" name="post_id" value="<?php echo I('get.post_id');?>">
                <input type="submit" class="btn btn-success bnt-sm" value="添加">
            </td>
        </tr>
    </table>   
</form>
<!-- 引入bootstrjs部分开始 -->
<script src="/Public/statics/js/jquery-1.10.2.min.js"></script>
<script src="/Public/statics/bootstrap-3.3.5/js/bootstrap.min.js"></script>
<script src="/tpl/Public/js/base.js"></script>
<script src="/Public/statics/vue/vue.js"></script>    
<script src="/Public/statics/vue/vue-resource.min.js"></script> 
<script>
    Vue.http.options.emulateJSON = true;
</script>    
<script type="text/javascript">
    var get_url = '<?php echo U('Admin/Users/get_users_list');?>'+'/p/';
    var post_url =  '<?php echo U('Admin/Users/search_users_list');?>';
    var page=1;
    var vm=new Vue({
        el: '.lqk-add-salary',
        data: {
            username:'',
            vuelist:''
        },
        ready: function () {
          this.$http.get(get_url+'1').then(function (response) {
              this.vuelist=response.data.data;
          })
        },
        methods: {
            SalaryVue: function(){
                this.$http.post(post_url,this._data)
                .then(function(response){
                    this.vuelist=response.data.data;
                }) 
            }
        }
    })
    // 分页处理
    $('.sl-insert-frame').scroll(function(event) {
        var documentHeight=$(document).height(),
                windowHeight=$(window).height(),
                scrollTop=$(window).scrollTop();
        if (scrollTop>=documentHeight-windowHeight) {
            page++;
            vm.$http.get(get_url+page).then(function (response) {
                if(response.data.data.length==0){
                    vm.showHint=true;
                }else{
                    response.data.data.forEach(function (k) {
                        vm.vuelist.push(k);
                    })
                }
            })
        }
    });
</script>
</body>
</html>