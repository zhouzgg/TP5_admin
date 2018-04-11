<?php
namespace app\index\controller;
use think\Controller;

class Base extends Controller
{

    public function _initialize(){

        $admin_name = session('admin_name');
        $admin_pwd = session('admin_pwd');

        if(empty($admin_name) || empty($admin_pwd)){
        	header('location:'.url('Login/index'));exit;
        }

        $menu_list = session('?menu_list') ? session('menu_list') : '';

        if(empty($menu_list)){

        	$list = db('admin_function')->order('pid asc')->select();

            $list = get_child($list,0);

            session('menu_list',$list);

            $menu_list = $list;
        }

        $this->assign('username',$admin_name);
        $this->assign('menu_list',$menu_list);
    }


}
