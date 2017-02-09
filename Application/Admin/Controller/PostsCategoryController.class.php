<?php
namespace Admin\Controller;
use Common\Controller\AdminBaseController;
/**
 *  视频分类管理
 */
class PostsCategoryController extends AdminBaseController{
    
    // 列表
    public function index(){
        $data = D('Category')->cate_list(15);
        $this->assign($data);
        $this->display();
    }

    // 添加
    public function add(){
        if(IS_POST){
            $data = I('post.');
            $result = D('Category')->addData($data);
            if($result){
                $this->success('添加成功',U('Admin/PostsCategory/add'));
            }else{
                $this->error(D('Category')->getError());
            }
        }else{
            $this->display();
        }
    }

    // 修改
    public function edit(){
        if(IS_POST){
            $data = I('post.');
            $map = array(
                'cate_id'=>$data['cate_id']
                );
            $result = D('Category')->editData($map,$data);
            if($result){
                $this->success('修改成功',U('Admin/PostsCategory/edit',array('cate_id'=>$data['cate_id'])));
            }else{
                $this->error(D('Category')->getError());
            }
        }else{
            $cate_id = I('get.cate_id');
            $map = array(
                'cate_id'=>$cate_id
                );
            $old_data = M('Category')
                        ->field('cate_id,name')
                        ->where($map)
                        ->find();
            $this->assign($old_data);
            $this->display();
        }
    }

    // 删除
    public function del(){
        $cate_id = I('get.cate_id');
        $map = array(
            'cate_id'=>$cate_id
            );
        $count = M('Posts')->where($map)->count();
        if($count){
            $this->error('请先删除该分类下的视频');
        }else{
            $result = M('Category')->where($map)->delete();
            if($result){
                $this->success('删除成功',U('Admin/PostsCategory/index'));
            }else{
                $this->error('删除失败');
            }
        }
    }


}