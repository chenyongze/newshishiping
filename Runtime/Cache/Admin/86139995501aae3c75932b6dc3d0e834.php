<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <title>话题列表 — 时时评后台管理</title>
    <link rel="stylesheet" href="/Public/statics/webuploader-0.1.5/xb-webuploader.css">
<script src="/Public/statics/js/jquery-1.10.2.min.js"></script>
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
    添加视频
</div>

<!-- 导航栏结束 -->
<ul id="myTab" class="nav nav-tabs" style="margin-top: 15px;">
   <li>
         <a href="<?php echo U('Admin/Posts/index');?>">视频列表</a>
   </li>
   <li class="active" >
         <a href="<?php echo U('Admin/Posts/add');?>">视频添加</a>
   </li>
</ul>
<form method="post" enctype="multipart/form-data" class="form-inline post-submit">
    <table class="table table-bordered table-condensed">
        <tr>
            <th>选择分类</th>
            <td>
                <select name="cate_id" class="form-control" style="min-width: 400px;">
                    <?php if(is_array($list)): foreach($list as $key=>$v): ?><option value="<?php echo ($v['cate_id']); ?>"><?php echo ($v['name']); ?></option><?php endforeach; endif; ?> 
                </select>
            </td>
            <th width="40%">选择用户</th>
        </tr>
        <tr>
            <th>视频标题</th>
            <td>
                <input type="text" class="form-control" style="min-width: 400px;" placeholder="请输入视频标题" name="title">
            </td>
            <td rowspan="4" class="lqk-add-salary">
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
            <th>点赞量</th>
            <td>
                <input type="text" class="form-control" name="click_number" placeholder="请输入点赞量">
            </td>
        </tr>
        <tr>
            <th>选择视频</th>
            <td>
                <!-- <input type="file" name="video"> -->
                <div id="uploader-demo">
                    <!--用来存放item-->
                    <div id="fileList" class="uploader-list"></div>
                    <div id="filePicker1">选择视频</div>
                </div>
            </td>
        </tr>
        <tr>
            <th>视频封面</th>
            <td >
                <div class="lqk-imgout-box">
                    <div id="upload-589f1d913dce2" class="xb-uploader">
    <div class="queueList">
        <div class="placeholder">
            <div class="filePicker"></div>
            <p></p>
        </div>
    </div>
    <div class="statusBar" style="display:none;">
        <div class="progress">
            <span class="text">0%</span>
            <span class="percentage"></span>
        </div>
        <div class="info"></div>
        <div class="btns">
            <div class="webuploader-container filePicker2">
                <div style="position: absolute; top: 0px; left: 0px; width: 1px; height: 1px; overflow: hidden;" id="rt_rt_1armv2159g1o1i9c2a313hadij6">
                </div>
            </div>
        </div>
    </div>
</div>
<script>
jQuery(function() {
    var $ = jQuery,    // just in case. Make sure it's not an other libaray.

        $goonuploader=false,

        $wrap = $("#upload-589f1d913dce2"),

        // 图片容器
        $queue = $('<ul class="filelist"></ul>')
            .appendTo( $wrap.find('.queueList') ),

        // 状态栏，包括进度和控制按钮
        $statusBar = $wrap.find('.statusBar'),

        // 文件总体选择信息。
        $info = $statusBar.find('.info'),

        // 上传按钮
        $upload = $('.uploadBtn'),

        // 没选择文件之前的内容。
        $placeHolder = $wrap.find('.placeholder'),

        // 总体进度条
        $progress = $statusBar.find('.progress').hide(),

        // 添加的文件数量
        fileCount = 0,

        // 添加的文件总大小
        fileSize = 0,

        // 优化retina, 在retina下这个值是2
        ratio = window.devicePixelRatio || 1,

        // 缩略图大小
        thumbnailWidth = 385 * ratio,
        thumbnailHeight = 200 * ratio,

        // 可能有pedding, ready, uploading, confirm, done.
        state = 'pedding',

        // 所有文件的进度信息，key为file id
        percentages = {},

        supportTransition = (function(){
            var s = document.createElement('p').style,
                r = 'transition' in s ||
                      'WebkitTransition' in s ||
                      'MozTransition' in s ||
                      'msTransition' in s ||
                      'OTransition' in s;
            s = null;
            return r;
        })(),
        thisSuccess,
        // WebUploader实例
        uploader;

    if ( !WebUploader.Uploader.support() ) {
        alert( 'Web Uploader 不支持您的浏览器！如果你使用的是IE浏览器，请尝试升级 flash 播放器');
        throw new Error( 'WebUploader does not support the browser you are using.' );
    }

    // 实例化
    uploader = WebUploader.create({
        pick: {
            id: "#upload-589f1d913dce2 .filePicker",
            label: '点击选择图片',
            multiple : false
        },
        dnd: "#upload-589f1d913dce2 .queueList",
        paste: document.body,
        accept: {
             title: 'Images',
             extensions: 'gif,jpg,jpeg,bmp,png',
             mimeTypes: 'image/*'
         },

        // swf文件路径
        swf: BASE_URL + '/Uploader.swf',

        disableGlobalDnd: true,

        chunked: true,
        server: "<?php echo U('Admin/Posts/ajax_upload_image');?>",
        fileNumLimit: 300,
        fileSizeLimit: 200 * 1024 * 1024,    // 200 M
        fileSingleSizeLimit: 50 * 1024 * 1024    // 50 M
    });

    // 添加“添加文件”的按钮，
    if(false==true){
        uploader.addButton({
           id: "#upload-589f1d913dce2 .filePicker2",
           label: '继续添加'
        });
    }else{
        uploader.addButton({
           id: "#upload-589f1d913dce2 .filePicker2",
        });
    }

    // 当有文件添加进来时执行，负责view的创建
    function addFile( file ) {
        var $li = $( '<li id="' + file.id + '" style="margin-right:10px;">' +
                '<p class="title">' + file.name + '</p>' +
                '<p class="imgWrap"></p>'+
                '<p class="progress"><span></span></p>' +
                '<input class="lqk-filename" type="radio" name="goods_image" value="' + file.id + '">'+
                '</li>' ),
            $btns = $('<div class="file-panel">' +
                '<span class="cancel">删除</span>' +
                // '<span class="rotateRight">向右旋转</span>' +
                // '<span class="rotateLeft">向左旋转</span>' +
                '</div>').appendTo( $li ),
            $prgress = $li.find('p.progress span'),
            $wrap = $li.find( 'p.imgWrap' ),
            $info = $('<p class="error"></p>'),

            showError = function( code ) {
                switch( code ) {
                    case 'exceed_size':
                        text = '文件大小超出';
                        break;

                    case 'interrupt':
                        text = '上传暂停';
                        break;

                    default:
                        text = '上传失败，请重试';
                        break;
                }

                $info.text( text ).appendTo( $li );
            };

        if ( file.getStatus() === 'invalid' ) {
            showError( file.statusText );
        } else {
            // @todo lazyload
            $wrap.text( '预览中' );
            uploader.makeThumb( file, function( error, src ) {
                if ( error ) {
                    $wrap.text( '不能预览' );
                    return;
                }

                var img = $('<img src="'+src+'">');
                $wrap.empty().append( img );
            }, thumbnailWidth, thumbnailHeight );

            percentages[ file.id ] = [ file.size, 0 ];
            file.rotation = 0;
        }

        file.on('statuschange', function( cur, prev ) {
            if ( prev === 'progress' ) {
                $prgress.hide().width(0);
            } else if ( prev === 'queued' ) {
                $li.off( 'mouseenter mouseleave' );
                $btns.remove();
            }

            // 成功
            if ( cur === 'error' || cur === 'invalid' ) {
                showError( file.statusText );
                percentages[ file.id ][ 1 ] = 1;
            } else if ( cur === 'interrupt' ) {
                showError( 'interrupt' );
            } else if ( cur === 'queued' ) {
                percentages[ file.id ][ 1 ] = 0;
            } else if ( cur === 'progress' ) {
                $info.remove();
                $prgress.css('display', 'block');
            } else if ( cur === 'complete' ) {
                $li.append( '<span class="success"></span>' );
            }

            $li.removeClass( 'state-' + prev ).addClass( 'state-' + cur );
        });

        $li.on( 'mouseenter', function() {
            $btns.stop().animate({height: 30});
        });

        $li.on( 'mouseleave', function() {
            $btns.stop().animate({height: 0});
        });

        $btns.on( 'click', 'span', function() {
            var index = $(this).index(),
                deg;

            switch ( index ) {
                case 0:
                    uploader.removeFile( file );
                    return;

                case 1:
                    file.rotation += 90;
                    break;

                case 2:
                    file.rotation -= 90;
                    break;
            }

            if ( supportTransition ) {
                deg = 'rotate(' + file.rotation + 'deg)';
                $wrap.css({
                    '-webkit-transform': deg,
                    '-mos-transform': deg,
                    '-o-transform': deg,
                    'transform': deg
                });
            } else {
                $wrap.css( 'filter', 'progid:DXImageTransform.Microsoft.BasicImage(rotation='+ (~~((file.rotation/90)%4 + 4)%4) +')');
                // use jquery animate to rotation
                // $({
                //     rotation: rotation
                // }).animate({
                //     rotation: file.rotation
                // }, {
                //     easing: 'linear',
                //     step: function( now ) {
                //         now = now * Math.PI / 180;

                //         var cos = Math.cos( now ),
                //             sin = Math.sin( now );

                //         $wrap.css( 'filter', "progid:DXImageTransform.Microsoft.Matrix(M11=" + cos + ",M12=" + (-sin) + ",M21=" + sin + ",M22=" + cos + ",SizingMethod='auto expand')");
                //     }
                // });
            }


        });

        $li.appendTo( $queue );
    }

    // 负责view的销毁
    function removeFile( file ) {
        var $li = $('#'+file.id);

        delete percentages[ file.id ];
        updateTotalProgress();
        $li.off().find('.file-panel').off().end().remove();
    }

    function updateTotalProgress() {
        var loaded = 0,
            total = 0,
            spans = $progress.children(),
            percent;

        $.each( percentages, function( k, v ) {
            total += v[ 0 ];
            loaded += v[ 0 ] * v[ 1 ];
        } );

        percent = total ? loaded / total : 0;

        spans.eq( 0 ).text( Math.round( percent * 100 ) + '%' );
        spans.eq( 1 ).css( 'width', Math.round( percent * 100 ) + '%' );
        updateStatus();
    }

    function updateStatus() {
        var text = '', stats;

        if ( state === 'ready' ) {
            text = '选中' + fileCount + '张图片，共' +
                    WebUploader.formatSize( fileSize ) + '。';
        } else if ( state === 'confirm' ) {
            stats = uploader.getStats();
            if ( stats.uploadFailNum ) {
                text = '已成功上传' + stats.successNum+ '个文件，'+
                    stats.uploadFailNum + '个上传失败，<a class="retry" href="#">重新上传</a>失败文件或<a class="ignore" href="#">忽略</a>'
            }

        } else {
            stats = uploader.getStats();
            text = '共' + fileCount + '个（' +
                    WebUploader.formatSize( fileSize )  +
                    '），已上传' + stats.successNum + '个';

            if ( stats.uploadFailNum ) {
                text += '，失败' + stats.uploadFailNum + '个';
            }
            if (fileCount==stats.successNum && stats.successNum!=0) {
                $('#upload-589f1d913dce2 .webuploader-element-invisible').remove();
            }
        }

        $info.html( text );
    }

    uploader.onUploadAccept=function(object ,ret){
        if(ret.error_info){
            fileError=ret.error_info;
            return false;
        }
    }
    uploader.onUploadSuccess=function(file ,response){
        $('#'+file.id +' .bjy-filename').val(response.name);
        $('.post-submit').append('<input class="form-control ss-images-icon" type="text" name="images[]" value="'+response.file.image_url+'">');
    }
    uploader.onUploadFinished=function(file){
        $('.post-submit').submit();
    }
    uploader.onUploadError=function(file){
        alert(fileError);
    }
    function setState( val ) {
        var file, stats;
        if ( val === state ) {
            return;
        }
        $upload.removeClass( 'state-' + state );
        $upload.addClass( 'state-' + val );
        state = val;
        switch ( state ) {
            case 'pedding':
                $placeHolder.removeClass( 'element-invisible' );
                $queue.parent().removeClass('filled');
                $queue.hide();
                $statusBar.addClass( 'element-invisible' );
                uploader.refresh();
                break;

            case 'ready':
                $placeHolder.addClass( 'element-invisible' );
                $( "#upload-589f1d913dce2 .filePicker2" ).removeClass( 'element-invisible');
                $queue.parent().addClass('filled');
                $queue.show();
                $statusBar.removeClass('element-invisible');
                uploader.refresh();
                break;

            case 'uploading':
                $( "#upload-589f1d913dce2 .filePicker2" ).addClass( 'element-invisible' );
                $progress.show();
                $upload.text( '暂停上传' );
                break;

            case 'paused':
                $progress.show();
                $upload.text( '继续上传' );
                break;

            case 'confirm':
                $progress.hide();
                $upload.text( '开始上传' ).addClass( 'disabled' );

                stats = uploader.getStats();
                if ( stats.successNum && !stats.uploadFailNum ) {
                    setState( 'finish' );
                    return;
                }
                break;
            case 'finish':
                stats = uploader.getStats();
                if ( stats.successNum ) {
                    
                } else {
                    // 没有成功的图片，重设
                    state = 'done';
                    location.reload();
                }
                break;
        }
        updateStatus();
    }

    uploader.onUploadProgress = function( file, percentage ) {
        var $li = $('#'+file.id),
            $percent = $li.find('.progress span');

        $percent.css( 'width', percentage * 100 + '%' );
        percentages[ file.id ][ 1 ] = percentage;
        updateTotalProgress();
    };

    uploader.onFileQueued = function( file ) {
        fileCount++;
        fileSize += file.size;

        if ( fileCount === 1 ) {
            $placeHolder.addClass( 'element-invisible' );
            $statusBar.show();
        }

        addFile( file );
        //设置默认主图
        var is_checked = $('.sl-show-box').find("input[checked='checked']").attr("checked");
        if(!is_checked){
            $('.filelist').find('li').eq(0).find('.lqk-filename').attr("checked","checked");
        }
        if(!false){
            $('.filelist').find("input[class='lqk-filename']").remove();
        }
        setState( 'ready' );
        updateTotalProgress();
    };

    uploader.onFileDequeued = function( file ) {
        fileCount--;
        fileSize -= file.size;

        if ( !fileCount ) {
            setState( 'pedding' );
        }

        removeFile( file );
        updateTotalProgress();

    };

    uploader.on( 'all', function( type ) {
        var stats;
        switch( type ) {
            case 'uploadFinished':
                setState( 'confirm' );
                break;

            case 'startUpload':
                setState( 'uploading' );
                break;

            case 'stopUpload':
                setState( 'paused' );
                break;

        }
    });

    uploader.onError = function( code ) {
        alert( 'Eroor: ' + code );
    };

    $upload.on('click', function() {
        if ( $(this).hasClass( 'disabled' ) ) {
            return false;
        }

        if ( state === 'ready' ) {
            uploader.upload();
        } else if ( state === 'paused' ) {
            uploader.upload();
        } else if ( state === 'uploading' ) {
            uploader.stop();
        }
    });

    $info.on( 'click', '.retry', function() {
        uploader.retry();
    } );

    $info.on( 'click', '.ignore', function() {
        alert( 'todo' );
    } );

    $upload.addClass( 'state-' + state );
    updateTotalProgress();
});
</script>
                </div>
            </td>
        </tr> 
        <tr>
            <td colspan="2"></td>
            <td>
                <div class="btn btn-success btn-sm uploadBtn">添加</div>
            </td>
        </tr>
    </table>
    <input type="hidden" id="video_path" value="" name="video_path">
</form>

<input id="api" type="hidden" value="<?php echo ($api); ?>">
<input id="sign" type="hidden" value="<?php echo ($sign); ?>">
<input id="policy" type="hidden" value="<?php echo ($policy); ?>">
<input id="bucket" type="hidden" value="<?php echo ($bucket); ?>">
<!-- 引入bootstrjs部分开始 -->
<script src="/Public/statics/js/jquery-1.10.2.min.js"></script>
<script src="/Public/statics/bootstrap-3.3.5/js/bootstrap.min.js"></script>
<script src="/tpl/Public/js/base.js"></script>
<script>
    var BASE_URL = '/Public/statics/webuploader-0.1.5';
</script>
<script src="//cdn.staticfile.org/webuploader/0.1.5/webuploader.min.js"></script>
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
// 图片上传demo
jQuery(function() {
    var $ = jQuery,
        $list = $('#fileList'),
        $btn = $('#ctlBtn'),
        $policy = $('#policy').val(),
        $sign = $('#sign').val(),
        $api = $('#api').val(),
        $bucket = $('#bucket').val(),
        state = 'pending',      
        // Web Uploader实例
        uploader;
        uploader = WebUploader.create({

        // swf文件路径
        swf: '/webuploader/Uploader.swf',

        // 文件接收服务端。
        server: $api,
        auto:true,
        // 选择文件的按钮。可选。
        // 内部根据当前运行是创建，可能是input元素，也可能是flash.
        pick: '#filePicker1',
        formData: {
            policy: $policy,
            signature: $sign
        }
    });

    // 当有文件添加进来的时候
    uploader.on( 'fileQueued', function( file ) {
        $list.append( '<div id="' + file.id + '" class="item">' +
            '<h4 class="info">' + file.name + '</h4>' +
            '<p class="state">等待上传...</p>' +
            '</div>' );
    });

    // 文件上传过程中创建进度条实时显示。
    uploader.on( 'uploadProgress', function( file, percentage ) {
        var $li = $( '#'+file.id ),
            $percent = $li.find('.progress .progress-bar');
        // 避免重复创建
        if ( !$percent.length ) {
            $percent = $('<div class="progress progress-striped active">' +
              '<div class="progress-bar" role="progressbar" style="width: 0%">' +
              '</div>' +
            '</div>').appendTo( $li ).find('.progress-bar');
        }
        $li.find('p.state').text('上传中');
        $percent.css( 'width', percentage * 100 + '%' );
    });
    uploader.on( 'uploadSuccess', function( file,response ) {
        $( '#'+file.id ).find('p.state').text('已上传');
        var url='http://'+$bucket+'.'+'b0.upaiyun.com'+response.url;
        $('#video_path').val(url);
    });

    uploader.on( 'uploadError', function( file ) {
        $( '#'+file.id ).find('p.state').text('上传出错');
    });

    uploader.on( 'uploadComplete', function( file ) {
        $( '#'+file.id ).find('.progress').fadeOut();
    });

    uploader.on( 'all', function( type ) {
        if ( type === 'startUpload' ) {
            state = 'uploading';
        } else if ( type === 'stopUpload' ) {
            state = 'paused';
        } else if ( type === 'uploadFinished' ) {
            state = 'done';
        }

        if ( state === 'uploading' ) {
            $btn.text('暂停上传');
        } else {
            $btn.text('开始上传');
        }
    });

    $btn.on( 'click', function() {
        if ( state === 'uploading' ) {
            uploader.stop();
        } else {
            uploader.upload();
        }
    });
});
</script>
</body>
</html>