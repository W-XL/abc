<?php
namespace app\controller;

use think\Controller;
use think\Request;
use think\Loader;

class User extends Controller{

    public function _initialize(){
        if (!check_login_common()){
            $this->redirect('Login/index');
        }
    }

    public function index(){
        $user_dao = Loader::model('UserDao');
        $user_list = $user_dao->get_user_list();
        $this->assign("list", $user_list);
        $this->assign("pages",$user_list->render());
        return view('index');
    }

    public function edit_view(){
        $id = Request::instance()->param('id');
        if (!$id){
            return '用户id不存在';
        }
        $user_dao = Loader::model('UserDao');
        $user_info = $user_dao->get_user_by_id($id);
        $this->assign('info',$user_info);
        return view('edit');
    }

    public function do_edit(){
        $params = Request::instance()->param();
        if (!$params['id']){
            return error_msg('用户id不存在');
        }
        if (!$params['password'] || !$params['re_pwd'] || !$params['account']){
            return error_msg('缺少必填项');
        }
        if ($params['password'] != $params['re_pwd']){
            return error_msg('两次密码不一致');
        }
        $user_dao = Loader::model('UserDao');
        $user_check = $user_dao->get_user_edit($params);
        if ($user_check){
            return error_msg('用户账号已经被使用');
        }
        $user_dao->update_user_info($params);
        return succeed_msg();
    }





}