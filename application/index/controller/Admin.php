<?php
namespace app\index\controller;
use app\index\model\AdminModel;
use app\index\model\CommonModel;

class Admin extends Base
{
    var $admin_model;

    public function _initialize(){
        parent::_initialize();
        $this->admin_model = new AdminModel();
        $this->common_model = new CommonModel();

    }

	//用户列表
    public function index()
    {

        // $list = $this->admin_model->get_admin_list();

        // $this->assign('list',$list);

        return view('/admin/index');
    }

    public function get_admin_list(){

        $this->view->engine->layout(false);
        $page = input('?page') ? input('get.page') : 0;
        $limit = input('?limit') ? input('get.limit') : 10;

        $list = db('admin')->page($page,$limit)->select();

        $count = db('admin')->count();

        $data = array(
            'code'=>0,
            'count'=>1000,
            'data'=>array(),
            'msg'=>''
        );

        $data['data'] = $list;
        $data['count'] = $count;

        return $data;
    }

    //用户添加
    public function add(){

        if(empty(input('post.'))){

            $list = $this->admin_model->get_admin_role_list();//角色列表

            $this->assign('role_list',$list);

            return view('/admin/add');
        }

        $admin_name = input('post.user_name');
        $admin_pwd = input('post.password');
        $confirm_pwd = input('post.confirm_pwd');
        $role_id = input('post.role_id');

        if(empty($admin_name) || empty($admin_pwd) || empty($confirm_pwd) || empty($role_id) ){
            $this->error('非法参数');
        }

        if(strlen($admin_pwd) < 6){
            $this->error('密码不能小于6位数');
        }

        if($admin_pwd != $confirm_pwd){
            $this->error('二次密码不一致');
        }

        $data = array(
            'admin_name'=>$admin_name,
            'admin_pwd'=>$admin_pwd,
            'role_id'=>$role_id
        );

        $res = db('admin')->insert($data);
        if(empty($res)){
            $this->error('添加用户失败');
        }

        $this->success('添加用户成功',url('admin/index'));
    }

    //用户编辑
    public function edit(){

        $admin_id = input('get.admin_id');

    	if(empty(input('post.'))){

            if(empty($admin_id)){
                $this->error('非法参数',url('admin/index'));
            }

            $admin = $this->admin_model->get_admin_one(array('admin_id'=>$admin_id));
            if(empty($admin)){
                $this->error('用户不存在',url('admin/index'));
            }

            $list = $this->admin_model->get_admin_role_list();//角色列表

            $this->assign('data',$admin);
            $this->assign('role_list',$list);
            return view('/admin/add');
        }

        $admin_name = input('post.user_name');
        $admin_pwd = input('post.password');
        $confirm_pwd = input('post.confirm_pwd');
        $role_id = input('post.role_id');

        if(empty($admin_id) || empty($admin_name) || empty($admin_pwd) || empty($confirm_pwd) || empty($role_id) ){
            $this->error('非法参数');
        }

        if(strlen($admin_pwd) < 6){
            $this->error('密码不能小于6位数');
        }

        if($admin_pwd != $confirm_pwd){
            $this->error('二次密码不一致');
        }

        $data = array(
            'admin_name'=>$admin_name,
            'admin_pwd'=>$admin_pwd,
            'role_id'=>$role_id
        );

        $res = db('admin')->where(array('admin_id'=>$admin_id))->update($data);
        if(empty($res)){
            $this->error('修改用户失败');
        }

        $this->success('修改用户成功',url('admin/index'));
    }

    //用户删除
    public function del(){

        $admin_id = (int)input('get.admin_id');

        if(empty($admin_id)){
            $this->error('非法参数');
        }

        $Rwhere = array(
            'admin_id' => $admin_id 
        );

        $res = db('admin')->where($Rwhere)->delete();
        if(empty($res)){
            $this->error('删除用户失败');
        }

        $this->success('删除用户成功');
    }

    //角色列表
    public function role(){

    	return view();
    }

    public function get_role_list(){

       $this->view->engine->layout(false);
        $page = input('?page') ? input('get.page') : 0;
        $limit = input('?limit') ? input('get.limit') : 10;

        $list = db('admin_role')->page($page,$limit)->select();

        $count = db('admin_role')->count();

        $data = array(
            'code'=>0,
            'count'=>1000,
            'data'=>array(),
            'msg'=>''
        );

        $data['data'] = $list;
        $data['count'] = $count;

        return $data;

    }

    //添加角色
    public function add_role(){

    	$role_name = input('post.role_name');

    	if(empty($role_name)){
            $data = $this->admin_model->get_function_list();

            $list = tree_data($data);

            $this->assign('list',$list);

            $this->assign('url',url('admin/add_role'));
            $this->assign('title','添加角色');
    		return view('admin/add_role');
    	}

    	$res = db('admin_role')->insert(array('role_name'=>$role_name));
    	if(empty($res)){
    		$this->error('添加角色失败');
    	}

    	$this->success('添加角色成功',url('admin/role'));
    	
    }

	//修改角色
    public function edit_role(){

    	$role_id = (int)input('role_id');
    	$role_name = input('post.role_name');
    	if(empty($role_id)){
    		$this->error('非法参数','admin/role');
    	}

    	if(empty($role_name) && !empty($role_id)){

            $data = $this->admin_model->get_function_list();

           $list = tree_data($data,1);

            $this->assign('list',$list);

            $role = $this->admin_model->get_admin_role_one(array('role_id'=>$role_id));
    	    if(empty($role)){
                $this->error('角色不存在','admin/role');
            }

            $this->assign('url',url('admin/edit_role',['role_id'=>$role_id]));
            $this->assign('role',$role);

            $this->assign('title','修改角色');
    		return view('admin/add_role');
    	}

    	$Rwhere = array(
    		'role_id' => $role_id 
    	);

    	$data = array(
    		'role_name' => $role_name
    	);

    	$res = db('admin_role')->where($Rwhere)->update($data);
    	if($res === false){
			$this->error('修改角色失败');
    	}

    	$this->success('修改角色成功');
    }

    //删除角色
    public function del_role(){

    	$role_id = (int)input('role_id');

    	if(empty($role_id)){
    		$this->error('非法参数');
    	}

    	$Rwhere = array(
    		'role_id' => $role_id 
    	);

    	$res = db('admin_role')->where($Rwhere)->delete();
    	if(empty($res)){
			$this->error('删除角色失败');
    	}

    	$this->success('删除角色成功');
    }


    public function function_list(){

        $data = $this->admin_model->get_function_list();

//        $list = get_child($data);
        foreach ($data as $k=>$v){
            $list[$k]['id'] = $v['function_id'];
            $list[$k]['pId'] = $v['pid'];
            $list[$k]['name'] = $v['function_name'];
        }

        $list = json_encode($list);

        $this->assign('list',$list);
        return view();

    }

    public function add_function(){

        $function_name = input('post.function_name');
        $controller = input('post.controller');
        $action = input('post.action');
        $pid = (int)input('post.pid');

        $data = array(
            'function_name'=>$function_name,
            'controller'=>$controller,
            'action'=>$action,
            'pid'=>$pid,
        );

        $res = $this->common_model->add_data('admin_function',$data);

        if(empty($res)){
            $this->error('添加栏目失败',url('admin/function_list'));
        }

        $this->success('添加栏目成功',url('admin/function_list'));
    }

    public function edit_function(){

        $id = input('get.id');
        if(empty($id)){
            $this->error('非法参数',url('admin/function_list'));
        }

        $where = array('function_id'=>$id);
        $row = $this->admin_model->get_function_one();
        if(empty($row)){
            $this->error('栏目不存在',url('admin/function_list'));
        }

        $function_name = input('post.function_name');
        $controller = input('post.controller');
        $action = input('post.action');
        $pid = (int)input('post.pid');

        $data = array(
            'function_name'=>$function_name,
            'controller'=>$controller,
            'action'=>$action,
            'pid'=>$pid,
        );

        $res = $this->common_model->edit_data('admin_function',$where,$data);

        if(empty($res)){
            $this->error('修改栏目失败',url('admin/function_list'));
        }

        $this->success('修改栏目成功',url('admin/function_list'));
    }

    public function del_function(){

        $id = input('get.id');
        if(empty($id)){
            $this->error('非法参数',url('admin/function_list'));
        }

        $where = array('function_id'=>$id);
        $row = $this->admin_model->get_function_one();
        if(empty($row)){
            $this->error('栏目不存在',url('admin/function_list'));
        }

        $res = $this->common_model->del_data('admin_function',$where);

        if(empty($res)){
            $this->error('修改栏目失败',url('admin/function_list'));
        }

        $this->success('修改栏目成功',url('admin/function_list'));
    }

}
