<?php
namespace User\Controller;
use Common\Controller\UserBaseController;
/**
 *  时时评控制器
 */
class PostsController extends UserBaseController{
    
    public function test(){
        $this->display();
    }

    // 视频列表
    public function index(){
        // 调取分类信息
        $cate_list = M('Category')->select();
        $assign=array(
            'cate_list'=>$cate_list,
            );
        $this->assign($assign);
        $this->display();
    }

    // 获取列表数据
    public function list_data(){
        // 调取视频列表数据
        $cate_id = I('get.cate_id');
        if($cate_id){
           $map = array(
            'p.cate_id' => $cate_id
            ); 
        }
        $data = D('Posts')->home_video_list(3,$map);
        ajax_return($data,'视频列表数据',1);
    }

    // 详情页
    public function details(){
        $post_id = I('get.post_id');
        $map = array(
            'post_id' => $post_id,
            );
        $data = D('Posts')->home_video_one($map);
        $assign=array(
            'data'=>$data,
            );
        $this->assign($assign);
        $this->display();
    }

    // 评论列表数据
    public function comment_list(){
        $map = array(
            'c.post_id' => I('get.post_id')
            );
        $data = D('Comment')->home_comment_list(13,$map);
        ajax_return($data,'评论列表数据',1);
    }

    // 添加评论
    public function add_comment(){
        if(IS_POST){
            $data = I('post.');
            $data['uid'] = $_SESSION['user']['id'];
            $where = array(
                'uid' => $data['uid'],
                'post_id'=>$data['post_id'],
                'content'=>$data['content']
                );
            $count = M('Comment')->where($where)->count();
            if(!$count){
                $result = D('Comment')->addData($data);
                if($result){
                    $map = array(
                        'c.post_id' => $data['post_id']
                        );
                    $comment_data = D('Comment')->home_comment_list(15,$map);
                    $comment_count = M('Comment')
                                        ->where(array('post_id'=>$data['post_id']))
                                        ->count();
                    $return_data = array(
                        'comment_count'=>$comment_count,
                        'comment_data'=>$comment_data,
                        );
                    ajax_return($return_data,'发表成功',1);
                }else{
                    ajax_return('','发表失败',0);
                }
            }else{
                ajax_return('','你已经发表过该评论',0);
            }
        }
    }

    // 点赞
    public function add_point(){
        $post_id = I('get.post_id');
        $cid = I('get.cid');
        $uid = '88';
        $data['uid'] = $uid;
        $data['post_id'] = $post_id;
        $data['cid'] = isset($cid) ? $cid : 0;
        if($post_id && !$data['cid']){
            $count = M('Point')->where(array('uid'=>$data['uid'],'post_id'=>$data['post_id']))->count();
            if(!$count){
                $data['status'] = 0;
                M('Posts')->where(array('post_id'=>$data['post_id']))->setInc('click_number',1);
                M('Point')->add($data);
                ajax_return('','点赞成功',1);
            }else{
                ajax_return('','你已点过赞',0);
            }
        }else{
            $count = M('Point')->where(array('uid'=>$data['uid'],'cid'=>$data['cid']))->count();
            if(!$count){
                $data['status'] = 1;
                M('Comment')->where(array('cid'=>$data['cid']))->setInc('click_number',1);
                M('Point')->add($data);
                ajax_return('','点赞成功',1);
            }else{
                ajax_return('','你已点过赞',0);
            }
        }
    }
}

