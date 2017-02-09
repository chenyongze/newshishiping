<?php
namespace Admin\Controller;
use Common\Controller\AdminBaseController;
/**
 * 用户管理控制器
 */
class UsersController extends AdminBaseController{

	/**
	 * 用户列表
	 */
	public function index(){
		// 调取用户数据
		$assign = D('Users')->users_list(15);
		$this->assign($assign);
		$this->display();
	}

	// 添加
	public function add(){
		if(IS_POST){
			$data = I('post.');
			// 图片上传
			$avatar = upyun_image('avatar');
			$data['avatar'] = $avatar[0];
			$data['password'] = 'e10adc3949ba59abbe56e057f20f883e';
			$data['status'] = '3';
			$result = D('Users')->addData($data);
			if($result){
				$this->success('添加成功',U('Admin/Users/add'));
			}else{
				$this->error(D('Users')->getError());
			}
		}else{
			$this->display();
		}
	}

	// 修改
	public function edit(){

	}

	// 删除
	public function del(){
		$id = I('get.id');
		$result = M('Users')->where(array('id'=>$id))->delete();
		$this->success('删除成功',U('Admin/Users/index'));
	}

	// 获取用户列表数据
	public function get_users_list(){
		$data = D('Users')->users_list(15);
		$data = $data['list'];
		ajax_return($data,'用户列表数据',1);
	}
	// 搜索用户数据
	public function search_users_list(){
		$data = I('post.');
		$username = $data['username'];
		$map = array(
			'username' => array('like',"%$username%"),
			'status'   => 3
			);
		$list = M('Users')
				->field('id,username,avatar')
				->where($map)
				->order('id desc')
				->select();

		foreach ($list as $k => $v) {
			$list[$k]['avatar'] = C('YPY_DOMAIN').$v['avatar'];
		}

		ajax_return($list,'搜索用户数据',1);
	}




}
