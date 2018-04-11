<?php
namespace app\index\controller;
use think\Controller;

class Login extends Controller
{
	public function _initialize(){
		$this->view->engine->layout(false); 
	}

    public function index()
    {   
        return view('login/index');
    }

    public function post_login(){

    	$user_name = input('?post.user_name') ? input('post.user_name') : '';
    	$passpwd = input('?post.user_pwd') ? input('post.user_pwd') : '';

    	$where = array(
    		'admin_name'=>$user_name,
    		'admin_pwd'=>$passpwd
    	);

    	$row = db('admin')->where($where)->find();

    	if(empty($row)){
    		return return_json_data('用户不存在',1);
    	}

    	session('admin_name',$user_name);
    	session('admin_pwd',$passpwd);
    	return return_json_data('登录成功',0);

    }

    public function login_out(){
    	session(null);
    	header('location:'.url('Login/index'));exit;
    }
}
