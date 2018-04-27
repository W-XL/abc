<?php
namespace app\model;

use think\Model;
use think\Db;

class ReceptionDao extends Model{

    public function get_cate_menu($pid){
        return Db::table('tb_menues')->where('status = 0')->where('pid='.$pid)->select();
    }

    public function get_admin_info($mobile){
        return Db::table('tb_admins')
                ->where('mobile="'.$mobile.'"')
                ->find();
    }

    public function insert_admins($params){
        $data = ['account'=>$params['mobile'],'mobile'=>$params['mobile'],'add_time'=>time(),'pwd'=>md5($params['password'])];
        $id = Db::name('tb_admins')
            ->insertGetId($data);
        return $id;
    }

    public function update_menu($params){
        Db::table('tb_menues')
            ->where('id',$params['id'])
            ->update(['name'=>$params['name'],'pid'=>$params['pid'],'url'=>$params['url'],'status'=>$params['status']]);
    }

    public function get_new_words($user_id){
        return Db::query('select * from tb_word_list where find_in_set("'.$user_id.'",user_list)');
    }

 }