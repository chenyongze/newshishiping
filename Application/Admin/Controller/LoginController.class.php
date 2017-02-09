<?php
namespace Admin\Controller;
use Common\Controller\BaseController;
/**
 * 后台登录控制器
 */
class LoginController extends BaseController{
    // 登录页面
    public function login(){
        if(IS_POST){
            // 获取post数据
            $data=I('post.');
            // 检测验证码
            $verify_code = check_verify($data['verify_code']);
            empty($verify_code)? $this->error('验证码错误'):$verify_code;
            // where条件
            $map = array(
                'password' => md5($data['password']),
                'username' => $data['username']
                );
            // 数据库查询
            $data=M('Users')->where($map)->find();
            if (empty($data)) {
                $this->error('账号或密码错误');
            }else{
                $_SESSION['user']=array(
                    'id'=>$data['id'],
                    'username'=>$data['username'],
                    'avatar'=>$data['avatar']
                    );
                $this->success('登录成功、前往管理后台',U('Admin/Index/index'));
            }
        }else{
            $this->display();
        }
    }

    // 生成验证码
    public function verify_code(){
        make_verifycode();
    }

    // 退出登录
    public function logout(){
        session('user',null);
        $this->success('退出成功、前往登录页面',U('Admin/Login/login'));
    }
}