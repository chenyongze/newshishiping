<?php
namespace Admin\Controller;
use Common\Controller\AdminBaseController;
/**
 * 时时评
 */
class PostsController extends AdminBaseController{
    
    // 列表
    public function index(){
        $data = D('Posts')->video_list(15);
        $this->assign($data);
        $this->display();
    }

    // 图片上传
    public function ajax_upload_image(){
        upyun_ajax_upload('cover');
    }

    // 添加
    public function add(){
    	if(IS_POST){
            $data = I('post.');
            $data['uid'] = isset($data['uid'])? $data['uid']: '';
            $cover_path = $data['images'][0];
            $video_name = $_FILES['video']['name'];
            if($cover_path == ''){
                $data['cover_path'] = '';
            }else{
                $data['cover_path'] = $cover_path;
            }
            $result = D('Posts')->addData($data);
            if($result){
                $this->success('添加成功',U('Admin/Posts/add'));
            }else{
                $this->error(D('Posts')->getError());
            }
    	}else{
            // 调取分类数据
            $data = D('Category')->cate_list(100);
            // 空间名
            $bucket = 'shishipingvideo';
            //表单密钥通过后台——>服务——>功能配置——>高级功能——>表单API密钥获取
            $form_api_secret = 'iqZpqTbKEMX5i5vzoHwfFRia93M=';
            //上传API地址
            $api= 'http://v0.api.upyun.com/' . $bucket.'/';
            $options = array();
            $options['bucket'] = $bucket;
            // 授权过期时间：以页面加载完毕开始计时，10分钟内有效
            $options['expiration'] = time()+600;
            // 保存路径：最终将以"/年/月/日/upload_待上传文件名"的形式进行保存
            $options['save-key'] = '/{year}/{mon}/{day}/upload_{filename}{.suffix}';
            $policy = base64_encode(json_encode($options));
            // 计算签名值，具体说明请参阅"Signature 签名"
            $sign = md5($policy.'&'.$form_api_secret);
            $data['policy'] = $policy;
            $data['sign'] = $sign;
            $data['api'] = $api;
            $data['bucket'] = $bucket;
            $this->assign($data);
    		$this->display();
    	}
    }
    // 修改
    public function edit(){
        if(IS_POST){
            $data = I('post.');
            $video_name = $_FILES['video']['name'];
            if(isset($data['images'])){
                $data['cover_path'] = $data['images'][0];
            }
            if($video_name == ''){
                $data['video_path'] = $data['video_path'];
            }else{
                $video_path = upyun_video('video');
                $data['video_path'] = $video_path;
            }
            $map = array(
                'post_id' => $data['post_id']
                );
            $result = D('Posts')->editData($map,$data);
            if($result){
                $this->success('修改成功',U('Admin/Posts/edit',array('post_id'=>$data['post_id'])));
            }else{
                $this->error(D('Posts')->getError());
            }
        }else{
            $post_id = I('get.post_id');
            $map = array(
                'p.post_id' => $post_id
                );
            // 调取分类数据
            $cate = D('Category')->cate_list(100);
            // 调取旧数据
            $old_data = D('Posts')
                        ->alias('p')
                        ->field('p.click_number,p.post_id,p.title,p.cover_path,p.video_path,p.uid,p.cate_id,u.username,u.avatar')
                        ->join('__USERS__ as u on p.uid = u.id')
                        ->where($map)
                        ->find();
            $old_data['avatar'] = C('YPY_DOMAIN').$old_data['avatar'];
            $old_data['cover_path_bak'] = C('YPY_DOMAIN').$old_data['cover_path'];
            $data = array(
                'cate' => $cate['list'],
                'old_data' => $old_data
                );
            $this->assign($data);
            $this->display();
        }
    }

    // 删除
    public function del(){
        $post_id = I('get.post_id');
        $count = M('Comment')->where(array('post_id'=>$post_id))->count();
        if($count){
            $this->error('请先删除该视频下的评论');
        }else{  
            $result = M('Posts')->where(array('post_id'=>$post_id))->delete();
            if($result){
                $this->success('删除成功',U('Admin/Posts/index'));
            }else{
                $this->error('删除失败');
            }   
        }
    }


}