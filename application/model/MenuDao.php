<?php
namespace app\model;

use think\Model;
use think\Db;

class MenuDao extends Model{

    public function get_cate_menu($pid){
        return Db::table('tb_menues')->where('status = 0')->where('pid='.$pid)->select();
    }

    public function get_menu($pid){
        return Db::table('tb_menues')
            ->alias('a')
            ->join(['tb_menues'=>'b'],'a.pid=b.id','left')
            ->where('a.id="'.$pid.'"')
            ->field('a.*,b.pid as pp_id')
            ->find();
    }

    public function insert_menu($params){
        $data = ['pid'=>$params['pid'],'name'=>$params['name'],'url'=>$params['url'],'status'=>$params['status']];
        Db::name('tb_menues')
            ->data($data)
            ->insert();
    }

    public function update_menu($params){
        Db::table('tb_menues')
            ->where('id',$params['id'])
            ->update(['name'=>$params['name'],'pid'=>$params['pid'],'url'=>$params['url'],'status'=>$params['status']]);
    }


 }