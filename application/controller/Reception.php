<?php
namespace app\controller;

use think\Controller;
use think\Session;
use think\Request;
use think\Loader;

class Reception extends Controller{

    public function _initialize(){
    }

    public function index(){
        $this->assign('usr_id',Session::get('usr_id'));
        return $this->fetch();
    }

    public function login(){
        if(Session::get('usr_id')){
            $this->redirect('Reception/index');
        }else{
            return $this->fetch();
        }
    }

    public function register(){
        if(Session::get('usr_id')){
            $this->redirect('Reception/index');
        }else{
            return $this->fetch();
        }
    }

    public function do_register(){
        $params = Request::instance()->param();
        $array = array('code'=>0,'msg'=>'网络异常');
        if(!$params['mobile'] || !$params['password']){
            $array['msg'] = "请填写必填项";
            return die(json_encode($array));
        }
        if($params['password'] != $params['again_pwd']){
            $array['msg'] = "两次输入的密码不一致";
            return die(json_encode($array));
        }
        $rep_dao = Loader::model('ReceptionDao');
        $user_info = $rep_dao->get_admin_info($params['mobile']);
        if($user_info){
            $array['msg'] = "该手机号已存在，请重新输入";
            return die(json_encode($array));
        }
        $id = $rep_dao->insert_admins($params);
        $array['code'] = 1;
        $array['msg'] = '注册成功';
        Session::set('usr_id',$id);
        Session::set('account',$user_info['account']);
        return die(json_encode($array));
    }

    public function do_logout(){
        Session::delete('usr_id');
        Session::delete('account');
        $this->redirect('Reception/index');
    }

    public function do_login(){
        $params = Request::instance()->param();
        if(Session::get('usr_id')){
            $this->redirect("Reception/index");
            exit;
        }
        $array = array('code'=>0,'msg'=>'网络异常');
        if(!$params['mobile'] || !$params['password']){
            $array['msg'] = "请填写必填项";
            return die(json_encode($array));
        }
        $rep_dao = Loader::model('ReceptionDao');
        $user_info = $rep_dao->get_admin_info($params['mobile']);
        if(!$user_info){
            $array['msg'] = "该手机号尚未注册，无法登录";
            return die(json_encode($array));
        }elseif($user_info['pwd'] != md5($params['password'])){
            $array['msg'] = "密码错误，请重新输入";
            return die(json_encode($array));
        }
        $array['code'] = 1;
        $array['msg'] = '登录成功';
        Session::set('usr_id',$user_info['id']);
        Session::set('account',$user_info['account']);
        return die(json_encode($array));
    }

    public function new_words(){
        $user_id = Request::instance()->param('user_id');
        $rep_dao = Loader::model("ReceptionDao");
        $new_words = $rep_dao->get_new_words($user_id);
    }


}