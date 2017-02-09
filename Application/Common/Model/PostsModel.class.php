<?php
namespace Common\Model;
use Common\Model\BaseModel;
/**
 * 视频model
 */
class PostsModel extends BaseModel{
    // 自动验证
    protected $_validate=array(
        array('cover_path','require','视频封面图必须上传',0,'',3), // 验证字段必填
        array('title','require','标题必填',0,'',3),
        array('uid','require','用户必选',0,'',3),
        array('video_path','require','视频必选上传',0,'',3),
    );

    // 自动完成
    protected $_auto=array(
    	array('create_time','time',1,'function') , // 对password字段在新增的时候使md5函数处理
        array('update_time','time',2,'function'), // 对date字段在新增的时候写入当前时间戳
    );


     /**
     * 添加用户
     */
    public function addData($data){
        // 对data数据进行验证
        if(!$data=$this->create($data)){
            // 验证不通过返回错误
            return false;
        }else{
            // 验证通过
            $result=$this->add($data);
            return $result;
        }
    }
    
    /**
     * 修改数据
     * @param   array   $map    where语句数组形式
     * @param   array   $data   数据
     * @return  boolean         操作是否成功
     */
    public function editData($map,$data){
        if(!$data=$this->create($data)){
            // 验证不通过返回错误
            return false;
        }else{
            // 去除键值首位空格
            foreach ($data as $k => $v) {
                $data[$k]=trim($v);
            }
            $result=$this->where($map)->save($data);
            return $result;
        }
    }

    // 视频列表数据
    public function video_list($limit){
        $count = $this->count();
        $page = new_page($count,$limit);
        $list = $this
                ->alias('p')
                ->field('p.post_id,p.title,p.cover_path,p.create_time,p.uid,p.cate_id,p.click_number,p.see_number,u.username,u.avatar')
                ->join('__USERS__ as u on p.uid = u.id')
                ->limit($page->firstRow.','.$page->listRows)
                ->order('p.post_id desc')
                ->select();
        foreach ($list as $k => $v) {
             $list[$k]['cover_path'] = C('YPY_DOMAIN').$v['cover_path'];
             $list[$k]['create_time'] = date('Y-m-d H:i:s',$v['create_time']);
             $list[$k]['avatar'] = C('YPY_DOMAIN').$v['avatar'];
             $list[$k]['comment_count'] = M('Comment')->where(array('post_id'=>$v['post_id']))->count();
             $list[$k]['point_count'] = M('Point')->where(array('post_id'=>$v['post_id'],'status'=>0))->count();
             $list[$k]['url'] = U('User/Posts/details',array('post_id'=>$v['post_id'],'cate_id'=>$v['cate_id']));
         } 
        $data = array(
            'list' => $list,
            'page' => $page->show()
            );
        return $data;
    }


    // 视频列表数据
    public function home_video_list($limit,$map){
        $count = $this
                ->alias('p')
                ->join('__USERS__ as u on p.uid=u.id')
                ->where($map)
                ->count();
        $page = new_page($count,$limit);
        $list = $this
                ->alias('p')
                ->field('p.click_number,p.post_id,p.title,p.cover_path,p.create_time,p.uid,p.cate_id,p.click_number,p.see_number,u.username,u.avatar')
                ->join('__USERS__ as u on p.uid = u.id')
                ->where($map)
                ->limit($page->firstRow.','.$page->listRows)
                ->order('p.post_id desc')
                ->select();
        foreach ($list as $k => $v) {
             $list[$k]['cover_path'] = C('YPY_DOMAIN').$v['cover_path'].'!375x200';
             $list[$k]['create_time'] = date('Y-m-d H:i:s',$v['create_time']);
             $list[$k]['avatar'] = C('YPY_DOMAIN').$v['avatar'].'!50x50';
             $list[$k]['comment_count'] = M('Comment')->where(array('post_id'=>$v['post_id']))->count();
             $list[$k]['url'] = U('User/Posts/details',array('post_id'=>$v['post_id'],'cate_id'=>$v['cate_id']));
         } 
        return $list;
    }

    // 一条视频数据
    public function home_video_one($map){
        $data = $this
                ->field('cover_path,post_id,title,uid,click_number,video_path')
                ->where($map)
                ->find();
        $data['cover_path'] = C('YPY_DOMAIN').$data['cover_path'].'!375x200';
        $data['comment_count'] = M('Comment')->where($map)->count();
        $data['video_path'] = C('YPY_DOMAIN').$data['video_path'];
        return $data;
    }


}
