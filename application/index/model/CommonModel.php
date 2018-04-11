<?php

namespace app\index\model;
use think\Model;

class CommonModel extends Model{

    /**
     * 删除数据
     * @param $table 表
     * @param $where 条件
     * @return boolean
     */
   public function del_data($table,$where){

       $res = db($table)->where($where)->delete();

       return $res;
   }

    /**
     * 添加数据
     * @param $table 表
     * @param $data 数据
     * @return boolean
     */
   public function add_data($table,$data,$all=""){

       if(empty($all)){
           $res = db($table)->insert($data);
       }else{
           $res = db($table)->insertAll($data);
       }

       return $res;

   }

    /**
     * 修改数据
     * @param $table 表
     * @param $where 条件
     * @param $data 数据
     * @return boolean
     */
   public function edit_data($table,$where,$data){

       $res = db($table)->where($where)->update($data);

       return $res;
   }
}