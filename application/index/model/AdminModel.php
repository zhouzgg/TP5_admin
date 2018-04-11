<?php

namespace app\index\model;
use think\Model;

class AdminModel extends Model{

    //用户列表
	public function get_admin_list($where='',$field="*"){

		$model = db('admin');

		if(!empty($where)){
			$model->where($where);
		}

		$model->field($field);

		$list = $model->select();
		return $list;

	}

	//单个用户信息
	public function get_admin_one($where='',$field="*"){

		$model = db('admin');

		if(!empty($where)){
			$model->where($where);
		}

		$model->field($field);

		$list = $model->find();

		return $list;

	}

	//角度列表
	public function get_admin_role_list($where='',$field="*"){

        $model = db('admin_role');

        if(!empty($where)){
            $model->where($where);
        }

        $model->field($field);

        $list = $model->select();
        return $list;

    }

    //获取单个角色
    public function get_admin_role_one($where='',$field="*"){

        $model = db('admin_role');

        if(!empty($where)){
            $model->where($where);
        }

        $model->field($field);

        $list = $model->find();
        return $list;

    }

    //获取栏目列表
    public function get_function_list($where='',$field="*"){

        $model = db('admin_function');

        if(!empty($where)){
            $model->where($where);
        }

        $model->field($field);

        $list = $model->select();
        return $list;

    }

    public function get_function_one($where='',$field="*"){

        $model = db('admin_function');

        if(!empty($where)){
            $model->where($where);
        }

        $model->field($field);

        $list = $model->find();
        return $list;

    }
}