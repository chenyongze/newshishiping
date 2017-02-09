<?php
namespace Common\Model;
use Common\Model\BaseModel;
/**
 * ModelName
 */
class UsersModel extends BaseModel{
    // 自动验证
    protected $_validate=array(
        array('username','require','用户名必须填写',0,'',3), // 验证字段必填
        array('avatar','require','头像必须上传',0,'',3),
    );

    // 自动完成
    protected $_auto=array(
        array('password','md5',1,'function') , // 对password字段在新增的时候使md5函数处理
        array('register_time','time',1,'function'), // 对date字段在新增的时候写入当前时间戳
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

    // 用户列表数据
    public function users_list($limit){
        $count = $this->count();
        $page = new_page($count,$limit);
        $list = $this
                ->field('username,avatar,register_time,id')
                ->limit($page->firstRow.','.$page->listRows)
                ->order('id desc')
                ->where(array('status'=>3))
                ->select();
        foreach ($list as $k => $v) {
            $list[$k]['avatar'] = C('YPY_DOMAIN').$v['avatar'];
        }
        $data = array(
            'list' => $list,
            'page' => $page->show()
            );
        return $data;
    }



}
