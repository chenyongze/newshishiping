<?php
namespace Common\Model;
use Common\Model\BaseModel;
/**
 * 分类model
 */
class CategoryModel extends BaseModel{
    // 自动验证
    protected $_validate=array(
        array('name','require','分类名必填',0,'',3), // 验证字段必填
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

    // 分类列表数据
    public function cate_list($limit){
        $count = $this->count();
        $page = new_page($count,$limit);
        $list = $this
                ->field('name,cate_id,create_time,update_time')
                ->limit($page->firstRow.','.$page->listRows)
                ->order('cate_id desc')
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


}
