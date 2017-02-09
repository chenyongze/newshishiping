<?php
namespace Home\Controller;
use Common\Controller\HomeBaseController;
/**
 * 话题Controller
 */
class IndexController extends HomeBaseController{
	
    public function index(){
        $url = U('Admin/Index/index');
        redirect($url);
    }

    

}

