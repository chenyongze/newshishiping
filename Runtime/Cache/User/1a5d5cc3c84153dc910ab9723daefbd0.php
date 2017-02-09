<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    <title>视频详情 - 时时评</title>
    <link rel="stylesheet" type="text/css" href="/Public/statics/weui-master/dist/style/weui.min.css" />
    <link rel="stylesheet" type="text/css" href="/Public/statics/font-awesome-4.4.0/css/font-awesome.min.css" />
    <link rel="stylesheet" type="text/css" href="/tpl/Public/css/base.css" />
    <link rel="stylesheet" type="text/css" href="/tpl/User/Public/css/posts.css" />
</head>
<body class="ss-list-data">
    <div class="ss-click-out">
        <video webkit-playsinline width="1" height="1" class="ss-video" x-webkit-airplay controls loop="loop" poster="<?php echo ($data['cover_path']); ?>" src="<?php echo ($data['video_path']); ?>"></video>
        <a href="<?php echo U('User/Posts/index',array('cate_id'=>I('get.cate_id')));?>" class="fa fa-angle-left ss-video-icon"></a>
        <div class="ss-video-text">
            <p class="ss-video-font"><?php echo ($data['title']); ?></p>
            <div class="ss-video-count">
                <i class="ss-list-count ss-point" _src="<?php echo U('User/Posts/add_point',array('post_id'=>$data['post_id']));?>">
                    <i class="fa fa-thumbs-up ss-list-icon"></i>
                    <i class="ss-point-count"><?php echo ($data['click_number']); ?></i>
                </i>
                <i class="ss-list-count">
                    <i class="fa fa-commenting-o ss-list-icon"></i>
                    <i class="ss-comment-count"><?php echo ($data['comment_count']); ?></i>
                </i>
            </div>
        </div>
        <!-- 列表 -->
        <ul class="ss-list-out">
            <li class="ss-list-li" v-for="item in list">
                <div class="ss-list-user">
                    <img class="ss-list-avatar" :src="item.avatar">
                    <i class="ss-list-username" v-text="item.username"></i>
                    <i class="ss-list-count ss-point" :_src="item.point_url">
                        <i class="fa fa-thumbs-up ss-list-icon"></i>
                        <i v-text="item.click_number" class="ss-point-count"></i>
                    </i>
                </div>
                <div class="ss-list-content">
                    <i class="ss-comment-content" v-text="item.content"></i>
                    <div class="ss-list-bottom">
                        <i class="ss-comment-time" v-text="item.create_time"></i>
                    </div>
                </div>
            </li>
        </ul>
    </div>

    <div style="height:35px;">  </div>
    <!-- 底部 -->
    <div class="ss-comment-bottom">
        <div class="ss-comment-frame ss-nav-add">写评论......</div>
        <div class="ss-alert-btn">视频首页</div>
    </div>
    <!-- 模态框 -->
    <div id="dialog1" style="display: none;">
        <div class="weui-mask"></div>
        <div class="weui-dialog">
            <div class="weui-dialog__bd" style="padding: 8px 0px;">
                <textarea name="" cols="30" rows="7" class="ss-comment-box"></textarea>
            </div>
            <div class="weui-dialog__ft" style="line-height: 30px;height: 30px;">
                <a href="javascript:;" class="weui-dialog__btn weui-dialog__btn_default">取消</a>
                <a href="javascript:;" class="weui-dialog__btn weui-dialog__btn_primary">发表</a>
            </div>
        </div>
    </div>
    <!-- 模态框 -->
    <div id="dialog2" style="display: none;">
        <div class="weui-mask"></div>
        <div class="weui-dialog">
            <div class="weui-dialog__bd" style="padding: 8px 0px;">
                <img src="/tpl/User/Public/images/alert.jpeg" style="width: 100%;">
            </div>
        </div>
    </div>
<!-- 隐藏域 -->
<input type="hidden" v-model="post_id" value="<?php echo I('get.post_id');?>" id="post_id">
<input type="hidden" id="ss-login" value="<?php echo $_SESSION['user']['id'];?>">
<input type="hidden" id="ss-url" value="<?php echo U('Api/Wx/back_url',array('cate_id'=>I('get.cate_id'),'post_id'=>I('get.post_id')));?>">

    <script type="text/javascript" src="/Public/statics/js/zepto-1.1.6.min.js"></script>
    <script src="/Public/statics/vue/vue.js"></script>    
<script src="/Public/statics/vue/vue-resource.min.js"></script> 
<script>
    Vue.http.options.emulateJSON = true;
</script>    
    <script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
    <script type="text/javascript">
        // 分享图片
        var share_image_url = '<?php echo ($data['cover_path']); ?>'; 
        // 分享标题
        var share_title = '<?php echo ($data['title']); ?>';
        // 分享内容
        var share_content ='<?php echo ($data['title']); ?>';

        $('.ss-video-cover').click(function(){
            $(this).hide();
        })
        $('.weui-mask').click(function(){
            $(this).parents('#dialog1').hide();
            $('#dialog2').hide();
        })
        $('.ss-nav-add').click(function(){
            var username = $('#ss-login').val();
            if(!username){
                location.href = $('#ss-url').val();
            }else{
                $('#dialog1').show();
            }
        })
        $('.weui-dialog__btn_default').click(function(){
            $('#dialog1').hide();
        })
        $('.ss-alert-btn').click(function(){
            $('#dialog2').show();
        })
        // 获取评论列表数据地址
        var get_url = '<?php echo U('User/Posts/comment_list');?>'+'/post_id/'+<?php echo I('get.post_id');?>+'/p/';
        // 评论地址
        var post_url = '<?php echo U('User/Posts/add_comment');?>';
        var page=1;
        var vm=new Vue({
            el: '.ss-list-data',
            data: {
                list:'',
                content:'',
                post_id:'',
            },
            ready: function () {
              this.$http.get(get_url+'1').then(function (response) {
                  this.list=response.data.data;
              })
            } 
        })
        $('.weui-dialog__btn_primary').click(function(event) {
            var formArray={};
            formArray['content'] = $('.ss-comment-box').val();
            formArray['post_id'] = $('#post_id').val();
            $.ajax({
                url: post_url,
                type: 'POST',
                data:formArray,
                dataType: 'json',
                beforeSend:beforeSend, //发送请求
                success:callback, //请求成功
                complete:complete//请求完成
            })
            function beforeSend(XMLHttpRequest){
            }
            function complete(XMLHttpRequest, textStatus){
            }
            function callback(response){
                // console.log(response)
                if(response.error_code == 1){
                    $('.ss-comment-box').val('');
                    $('#dialog1').hide();
                    $('.ss-comment-count').text(response.data.comment_count);
                    vm.list = response.data.comment_data;
                }else{
                    alert(response.error_message);
                }
            }
        });

        // 视频点赞
        $('.ss-click-out').on('click','.ss-point',function(){
            var point_url = $(this).attr('_src');
            var num = $(this).find('.ss-point-count').text();
            var obj = $(this);
            $.ajax({
                url: point_url,
                type: 'GET',
                dataType: 'json',
                beforeSend:beforeSend, //发送请求
                success:callback, //请求成功
                complete:complete//请求完成
            })
            function beforeSend(XMLHttpRequest){

            }
            function complete(XMLHttpRequest, textStatus){
                // alert('发表成功')
            }
            function callback(response){
                if(response.error_code != 1){
                    alert(response.error_message);
                }else{
                    num = num*1 + 1;
                    obj.find('.ss-point-count').text(num);
                }
            }
        })

        // 微信分享
        // wx.config({
        //     appId: '<?php echo ($signPackage["appId"]); ?>',
        //     timestamp: <?php echo ($signPackage["timestamp"]); ?>,
        //     nonceStr: '<?php echo ($signPackage["nonceStr"]); ?>',
        //     signature: '<?php echo ($signPackage["signature"]); ?>',
        //     jsApiList: [
        //         'checkJsApi',
        //         'onMenuShareTimeline',
        //         'onMenuShareAppMessage',
        //         'onMenuShareQQ',
        //         'onMenuShareWeibo'
        //       ]
        // });             
        // wx.ready(function () {
        //     // 1 判断当前版本是否支持指定 JS 接口，支持批量判断
        //     wx.checkJsApi({
        //       jsApiList: [
        //         'getNetworkType',
        //         'previewImage',
        //          'onMenuShareTimeline',
        //         'onMenuShareAppMessage',
        //         'onMenuShareQQ',
        //         'onMenuShareWeibo'
        //       ],            
        //     });
        //     var shareData = {
        //       title: share_title,
        //       desc: share_content,
        //       link: '',
        //       imgUrl: share_image_url, 
        //     };
        //     var friendline = {
        //       title: share_title,
        //       desc: '',
        //       link: '',
        //       imgUrl: share_image_url, 
        //     };
        //     wx.onMenuShareAppMessage(shareData);
        //     wx.onMenuShareTimeline(friendline);
        //     wx.onMenuShareQQ(shareData);
        //     wx.onMenuShareWeibo(shareData);
        // });

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