<?php
namespace app\model;

use think\Model;
use think\Db;

class UserDao extends Model{

        public function get_user_list(){
            return Db::table('tb_admins')
                ->where('is_del','0')
                ->paginate(10);

        }

        public function get_user_by_id($id){
            return Db::table('tb_admins')
                ->where('id='.$id)
                ->find();
        }

        public function get_user_edit($params){
            return Db::table('tb_admins')
                ->where('id','neq',$params['id'])
                ->where('account','eq',$params['account'])
                ->find();
        }

        public function update_user_pwd($id,$pwd){
            Db::table('tb_admins')
                ->where('id',$id)
                ->update(['pwd'=>$pwd]);
        }

        public function update_user_info($params){
            Db::table('tb_admins')
                ->where('id',$params['id'])
                ->update(['account'=>$params['account'],'pwd'=>md5($params['password'])]);
        }

 }