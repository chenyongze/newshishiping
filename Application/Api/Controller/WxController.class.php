<?php
namespace Api\Controller;
use Common\Controller\BaseController;
/**
 *  微信控制器
 */
class WxController extends BaseController{

    // 组合回调地址
    public function back_url(){
        $_SESSION['back_path'] = U('User/Posts/details',array('cate_id'=>I('get.cate_id'),'post_id'=>I('get.post_id')));
        redirect(U('Api/Wx/auth'));
    }
    //获取code，test在该链接自定义的参数
    public function auth(){
        //该字符串是获取code时自定义的参数。
        $state = 'test';
        //获取code
        if(I('get.state') != $state){
            //调用function.php中定义的get_code函数，$state是链接自带参数的 
            get_code($state); 
        }else{ 
            //获取access_token;
            $content = get_access_token(); 
            //获取用户信息
            $user = get_userinfo_by_auth($content); //$user是保存用户信息的一位数组
        }
        $data['avatar'] = $user['headimgurl'];
        $data['openid'] = $user['openid'];
        $data['username'] = $user['nickname'];
        $data['status'] = 4;
        // 更新添加微信用户信息
        $id = D('Users')->where(array('openid'=>$user['openid']))->getField('id',true);
        $id = current($id);
        if($id){
            // 修改用户数据
            D('Users')->where(array('id'=>$id))->save($data);
        }else{
            // 添加用户数据
            D('Users')->add($data);
        }
        // 存session
        $_SESSION['user']['id']=$id;
        $_SESSION['user']['username']=$user['nickname'];
        $_SESSION['user']['avatar']=$user['headimgurl'];
        redirect($_SESSION['back_path']);
    }


}

