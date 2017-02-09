<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    <title>视频列表 - 时时评</title>
    <link rel="stylesheet" type="text/css" href="/Public/statics/weui-master/dist/style/weui.min.css" />
    <link rel="stylesheet" type="text/css" href="/Public/statics/font-awesome-4.4.0/css/font-awesome.min.css" />
    <link rel="stylesheet" type="text/css" href="/tpl/Public/css/base.css" />
    <link rel="stylesheet" type="text/css" href="/tpl/User/Public/css/posts.css" />
</head>
<body id="showResult">
    <!-- 导航条 -->
    <div class="ss-nav-fixed">
        <div class="ss-nav-outbox">
            <ul class="ss-nav-box">
                <li class="ss-nav-li">
                    <a href="<?php echo U('User/Posts/index',array('cate_id'=>'0'));?>" class="ss-nav-a <?php if($_GET['cate_id'] == '0' ): ?>ss-nav-choose"<?php endif; ?>">
                        首页
                    </a>
                </li>
                <?php if(is_array($cate_list)): foreach($cate_list as $key=>$v): ?><li class="ss-nav-li">
                        <a href="<?php echo U('User/Posts/index',array('cate_id'=>$v['cate_id']));?>" class="ss-nav-a <?php if($v['cate_id'] == $_GET['cate_id']): ?>ss-nav-choose"<?php endif; ?>">
                            <?php echo ($v['name']); ?>
                        </a>
                    </li><?php endforeach; endif; ?>
            </ul>
            <div class="ss-nav-add">
                +
            </div>
        </div>       
    </div>
    <!-- 列表 -->
    <ul class="ss-list-outbox ss-scroll-frame ss-list-data">
        <li class="ss-list-li" v-for="item in list">
            <a :href="item.url">
                <div class="ss-list-show">
                    <img class="ss-list-img" :src="item.cover_path">
                    <!-- <i class="fa fa-play-circle-o ss-list-btn"></i> -->
                    <i class="ss-list-title" v-text="item.title"></i>
                </div>
                <div class="ss-list-user">
                    <img class="ss-list-avatar" :src="item.avatar">
                    <i class="ss-list-name" v-text="item.username"></i>
                    <div class="ss-list-right">
                        <i class="ss-list-count">
                            <i class="fa fa-thumbs-up ss-list-icon"></i>
                            <i v-text="item.click_number"></i>
                        </i>
                        <i class="ss-list-count">
                            <i class="fa fa-commenting-o ss-list-icon"></i>
                            <i v-text="item.comment_count"></i>
                        </i>
                    </div>
                </div>
            </a>
        </li>
    </ul>

    <!-- 模态框 -->
    <div id="dialog1" style="display: none;">
        <div class="weui-mask"></div>
        <div class="weui-dialog">
            <div class="weui-dialog__bd" style="padding: 8px 0px;">
                <img src="/tpl/User/Public/images/alert.jpeg" style="width: 100%;">
            </div>
        </div>
    </div>
    <script type="text/javascript" src="/Public/statics/js/zepto-1.1.6.min.js"></script>
    <script src="/Public/statics/vue/vue.js"></script>    
<script src="/Public/statics/vue/vue-resource.min.js"></script> 
<script>
    Vue.http.options.emulateJSON = true;
</script>    
    <script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
    <script type="text/javascript">
        $('.weui-mask').click(function(){
            $(this).parents('#dialog1').hide();
        })
        $('.ss-nav-add').click(function(){
            $('#dialog1').show();
        })
        var get_url = '<?php echo U('User/Posts/list_data');?>'+'/cate_id/'+<?php echo I('get.cate_id');?>+'/p/';
        var page=1;
        var vm=new Vue({
            el: '.ss-list-data',
            data: {
                list:''
            },
            ready: function () {
              this.$http.get(get_url+'1').then(function (response) {
                  this.list=response.data.data;
              })
            }
        })
        // 分享图片
        var share_image_url = "http://imgshi.liqingkuo.com/upload/avatar/2017-01-23/5885fc371806b.jpeg"; 
        // 分享内容
        var share_content = "专注于视频分享的平台,娱乐你我他";
        // 分享标题
        var share_title = "时时评";
        // 微信分享
        wx.config({
            appId: '<?php echo ($signPackage["appId"]); ?>',
            timestamp: '<?php echo ($signPackage["timestamp"]); ?>',
            nonceStr: '<?php echo ($signPackage["nonceStr"]); ?>',
            signature: '<?php echo ($signPackage["signature"]); ?>',
            jsApiList: [
                'checkJsApi',
                'onMenuShareTimeline',
                'onMenuShareAppMessage',
                'onMenuShareQQ',
                'onMenuShareWeibo'
              ]
        });             
        wx.ready(function () {
            // 1 判断当前版本是否支持指定 JS 接口，支持批量判断
            wx.checkJsApi({
              jsApiList: [
                'getNetworkType',
                'previewImage',
                 'onMenuShareTimeline',
                'onMenuShareAppMessage',
                'onMenuShareQQ',
                'onMenuShareWeibo'
              ],            
            });
            var shareData = {
              title: share_title,
              desc: share_content,
              link: '',
              imgUrl: share_image_url, 
            };
            wx.onMenuShareAppMessage(shareData);
            wx.onMenuShareTimeline(shareData);
            wx.onMenuShareQQ(shareData);
            wx.onMenuShareWeibo(shareData);
        });

        var vm=new Vue({
            el: 'body',
            data: {
                content:'',
                topicList:'',
                'title':'',
                'images_path':''
            },
            ready: function () {
              this.$http.get(get_url+'1').then(function (response) {
                  this.topicList=response.data.data;
              })
            },
            methods: {
                addTopic: function(){
                    this._data.topicList = '';
                    this.$http.post(post_url,this._data)
                    .then(function(response){
                        console.log(response.data);
                        if(response.data.error_code==1){
                            ie.alert(response.data.error_message);
                        }else{
                            this.topicList=response.data.data;
                            // 触发模态框消失
                            $('#input-title').val('');
                            $('#input-textarea').val('');
                            location.reload(true);
                        }
                    }) 
                }
            }
        })




        // 分页处理
        $(window).scroll(function(event) {
            var documentHeight=$(document).height(),
                    windowHeight=$(window).height(),
                    scrollTop=$(window).scrollTop();
            if (scrollTop>=documentHeight-windowHeight) {
                page++;
                $.ajax({
                    url: get_url+page,
                    type: 'GET',
                    dataType: 'json',
                    beforeSend:beforeSend, //发送请求
                    success:callback, //请求成功
                    complete:complete//请求完成
                })
                function beforeSend(XMLHttpRequest){
                  $("#showResult").append('<div class="weui-loadmore"><i class="weui-loading"></i><span class="weui-loadmore__tips">正在加载</span></div>');
                }
                function complete(XMLHttpRequest, textStatus){
                  $(".weui-loadmore").remove();
                }
                function callback(response){
                    if(response.data.length==0){
                        $("#showResult").append('<div class="weui-loadmore"><span class="weui-loadmore__tips">已经到底部</span></div>');
                    }
                    response.data.forEach(function (k) {
                        vm.list.push(k);
                    })
                }
            }
        });
    </script>
</body>
</html>