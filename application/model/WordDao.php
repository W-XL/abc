<?php
namespace app\model;

use think\Model;
use think\Db;

class WordDao extends Model{

    public function get_word_list(){
        return Db::table('tb_word_list')->where('is_del = 0')->paginate(20);;
    }

    public function get_word_info($id){
        return Db::table('tb_word_list')
                ->where('id="'.$id.'"')
                ->find();
    }

    public function insert_word($params){
        $data = ['word'=>$params['word'],'meaning'=>$params['meaning'],'add_time'=>time()];
        $id = Db::name('tb_word_list')
            ->insertGetId($data);
        return $id;
    }

    public function update_word($params){
        Db::table('tb_word_list')
            ->where('id',$params['id'])
            ->update(['word'=>$params['word'],'meaning'=>$params['meaning']]);
    }

    public function delete_word($id){
        Db::table('tb_word_list')
            ->where('id',$id)
            ->update(['is_del'=>1]);
    }
 }