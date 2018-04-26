<?php
namespace app\controller;

use think\Controller;
use think\Session;
use think\Request;
use think\Loader;

class Word extends Controller{

    public function _initialize(){
    }

    public function index(){
        $word_dao = Loader::model("WordDao");
        $word_list = $word_dao->get_word_list();
        $this->assign('word_list',$word_list);
        $this->assign("pages",$word_list->render());
        return view();
    }

    public function add_view(){
        return view('add');
    }

    public function do_add(){
        $params = Request::instance()->param();
        if(!$params['word'] || !$params['meaning']){
            return error_msg('缺少必填项');
        }
        $word_dao = Loader::model("WordDao");
        $word_dao->insert_word($params);
        return succeed_msg();
    }

    public function edit_view(){
        $id = Request::instance()->param('id');
        if (!$id){
            return '单词id不存在';
        }
        $word_dao = Loader::model("WordDao");
        $word_info = $word_dao->get_word_info($id);
        $this->assign("word_info",$word_info);
        return view('edit');
    }

    public function do_edit(){
        $params = Request::instance()->param();
        if(!$params['word'] || !$params['meaning']){
            return error_msg('缺少必填项');
        }
        $word_dao = Loader::model("WordDao");
        $word_dao->update_word($params);
        return succeed_msg();
    }

    public function delete_view(){
        $id = Request::instance()->param('id');
        if(!$id){
            return error_msg('单词ID不存在');
        }
        $this->assign('id',$id);
        return view('delete');
    }

    public function do_del(){
        $id = Request::instance()->param('id');
        $word_dao = Loader::model("WordDao");
        $info = $word_dao->get_word_info($id);
        if(!$info){
            return error_msg('删除出错啦！');
        }
        $word_dao->delete_word($id);
        return succeed_msg();
    }


}