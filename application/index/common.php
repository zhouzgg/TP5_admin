<?php

/**
 * 无限限分类
 * @param array $data 数组
 * @param string $class_id 主键ID
 * @param string $pid 父ID
 * @param string $child_str 节点字符串
 * @return array
 */
function get_child($data=array(),$parent_id = 0,$class_id='function_id',$pid="pid",$child_str="child"){

    $list = array();
    $res = array();
    foreach ($data as $key=>$val){
        if($val[$pid] == $parent_id){
            $list[$val[$class_id]] = $val;
            $res[$val[$class_id]] = &$list[$val[$class_id]];
        }else{
            $list[$val[$pid]][$child_str][$val[$class_id]] = $val;
            $list[$val[$class_id]] = &$list[$val[$pid]][$child_str][$val[$class_id]];
        }
    }

    return $res;

}

function tree_data($data,$role_id=''){

    $info = db('admin_role')->where(array('role_id'=>$role_id))->find();
    $function_ids = explode(',',$info['role_function_ids']);
    foreach ($data as $k=>$v){
        $list[$k]['id'] = $v['function_id'];
        $list[$k]['pId'] = $v['pid'];
        $list[$k]['name'] = $v['function_name'];
        $list[$k]['open'] = true;
        if(strtolower($info['role_function_ids']) == 'all'){
            $list[$k]['checked'] = true;
        }else{
            foreach ($function_ids as $key=>$val){

                if($v['function_id'] == $val){
                    $list[$k]['checked'] = true;
                }

            }

        }
    }

    $list = json_encode($list);

    return $list;

}

function return_json_data($msg='',$code='',$data=array()){

    $res = array(
        'msg'=>$msg,
        'code'=>$code,
        'data'=>$data
    );

    // $res = json_encode($res);
    return $res;

}