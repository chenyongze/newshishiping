<?php
namespace Common\Model;
use Common\Model\BaseModel;
/**
 * 视频评论model
 */
class CommentModel extends BaseModel{
    // 自动验证
    protected $_validate=array(
        array('content','require','评论内容必须填写',0,'',3), // 验证字段必填
        array('uid','require','必须选择一个用户',0,'',3),
    );

    // 自动完成
    protected $_auto=array(
        array('create_time','time',1,'function') ,
        array('update_time','time',2,'function'),
    );

    /**
     * 添加
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

    // 评论列表数据
    public function comment_list($limit,$map){
        $count = $this->where($map)->count();
        $page = new_page($count,$limit);
        $list = $this
                ->field('cid,uid,post_id,content,create_time,update_time,click_number')
                ->where($map)
                ->limit($page->firstRow.','.$page->listRows)
                ->order('cid desc')
                ->select();
        foreach ($list as $k => $v) {
            $list[$k]['create_time'] = date('Y-m-d H:i:s',$v['create_time']);
            $list[$k]['update_time'] = date('Y-m-d H:i:s',$v['update_time']);
        }
        $data = array(
            'list' => $list,
            'page' => $page->show()
            );
        return $data;
    }

    // 前台评论列表数据
    public function home_comment_list($limit,$map){
        $count = $this
                ->alias('c')
                ->join('__USERS__ as u on c.uid = u.id')
                ->where($map)
                ->count();
        $page = new_page($count,$limit);
        $list = $this
                ->alias('c')
                ->field('c.cid,c.uid,c.post_id,c.content,create_time,c.click_number,u.username,u.avatar,u.status')
                ->join('__USERS__ as u on c.uid = u.id')
                ->where($map)
                ->limit($page->firstRow.','.$page->listRows)
                ->order('c.cid desc')
                ->select();
        foreach ($list as $k => $v) {
            $list[$k]['create_time'] = date('Y-m-d H:i:s',$v['create_time']);
            if($v['status'] != 4){
                $list[$k]['avatar'] = C('YPY_DOMAIN').$v['avatar'].'!50x50';
            }
            $list[$k]['point_url'] = U('User/Posts/add_point',array('cid'=>$v['cid']));
        }
        return $list;
    }


}
