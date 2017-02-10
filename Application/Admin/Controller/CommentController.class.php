<?php
namespace Admin\Controller;
use Common\Controller\AdminBaseController;
/**
 * 评论管理
 */
class CommentController extends AdminBaseController{
    


    // 列表
    public function index(){
        $post_id = I('get.post_id');
        $map = array(
            'post_id' => $post_id
            );
        $data = D('Comment')->comment_list(15,$map);
        $this->assign($data);
        $this->display(); 
    }

    // 添加
    public function add(){
    	if(IS_POST){
            $data = I('post.');
            $content = $data['content'];
            $uid = $data['uid'];
            $post_id = $data['post_id'];
            $data['uid'] = isset($data['uid'])? $data['uid'] : '';
            $map = array(
                'uid' => $uid,
                'content' => $content,
                'post_id' => $post_id
                );
            $count = M('Comment')->where($map)->count();
            if($count){
                $this->error('评论不能重复');
            }else{
                $result = D('Comment')->addData($data);
                if($result){
                    $this->success('添加成功',U('Admin/Comment/add',array('post_id'=>$post_id)));
                }else{
                    $this->error(D('Comment')->getError());
                }
            }
    	}else{
            $this->display();
    	}
    }

    // 修改
    public function edit(){
        if(IS_POST){
            $data = I('post.');
            $uid = $data['uid'];
            $cid = $data['cid'];
            $post_id = $data['post_id'];
            
            $data['uid'] = isset($data['uid'])? $data['uid'] : '';
            $map = array(
                'cid' => $cid
                );
            $result = D('Comment')->editData($map,$data);
            if($result){
                $this->success('修改成功',U('Admin/Comment/edit',array('post_id'=>$post_id,'cid'=>$cid)));
            }else{
                $this->error(D('Comment')->getError());
            }
        }else{
            $cid = I('get.cid');
            $map = array(
                'c.cid' => $cid
                );
            $old_data = M('Comment')
                        ->alias('c')
                        ->field('c.post_id,c.cid,c.content,c.uid,c.click_number,u.avatar,u.username')
                        ->join('__USERS__ as u on u.id = c.uid')
                        ->where($map)
                        ->find();
            $old_data['avatar'] = C('YPY_DOMAIN').$old_data['avatar'];
            $data=array(
                'old_data'=>$old_data
                );
            $this->assign($data);
            $this->display();
        }
    }

    // 删除
    public function del(){
        $cid = I('get.cid');
        $post_id = I('get.post_id');
        $map = array(
            'cid' => $cid
            );
        $result = M('Comment')->where($map)->delete();
        if($result){
            $this->success('删除成功',U('Admin/Comment/list',array('post_id'=>$post_id)));
        }else{
            $this->error('删除失败');
        }
    }


}