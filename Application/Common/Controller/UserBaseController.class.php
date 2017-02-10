<?php
namespace Common\Controller;
use Common\Controller\BaseController;
/**
 * 用户基类控制器
 */
class UserBaseController extends BaseController{
	/**
	 * 初始化方法
	 */
	public function _initialize(){
       	parent::_initialize();
        // 分享SDK
        $jssdk = new \Org\Xb\Wxjssdk("wx876aeff91e86d828","27da9a3a367718b6c236db6bc1c20207");
        $signPackage = $jssdk->GetSignPackage();
        // p($signPackage);die;
        $this->assign('signPackage',$signPackage);
	}



}

