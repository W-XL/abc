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
        $array = array('code'=>0,'msg'=>"网络错误");
        $user_id = Request::instance()->param('user_id');
        if(!$user_id){
            $array['msg'] = "请先登录";
            die(json_encode($array));
        }
        $rep_dao = Loader::model("ReceptionDao");
        $new_words = $rep_dao->get_new_words($user_id);
        $array['code'] = 1;
        $array['new_words'] = $new_words;
        return die(json_encode($array));
    }

    public function translate(){
        $array = array('code'=>0,'msg'=>'网络错误');
        $text = Request::instance()->param('text');
        if(!$text){
            $array['msg'] = '请先输入需要翻译的词语';
            die(json_encode($array));
        }
        $rep_dao = Loader::model("ReceptionDao");
        if(preg_match("/[\x7f-\xff]/", $text)){
            $only_word = $rep_dao->get_chinese_word($text);
            $type = 1;
        }elseif (preg_match('/[a-zA-Z]/',$text)){
            $only_word = $rep_dao->get_english_word($text);
            $type = 2;
        }else{
            $array['msg'] = "输入的词语有误";
            die(json_encode($array));
        }
        $similar_words = $rep_dao->get_aimilar_words($text,$type);
        $array['code'] = 1;
        $array['msg'] = '查询成功';
        $array['text'] = $text;
        $array['type'] = $type;
        $array['only_word'] = $only_word;
        $array['similar_words'] = $similar_words;
        die(json_encode($array));
    }

    public function add_new_word(){
        $array = array("code"=>0,'msg'=>"网络错误");
        if(!Session::get('usr_id')){
            $array['msg'] = "请先登录";
            die(json_encode($array));
        }
        $id = Request::instance()->param('word_id');
        if(!$id){
            $array['msg'] = "单词ID错误啦";
            die(json_encode($array));
        }
        $rep_dao = Loader::model('ReceptionDao');
        $info = $rep_dao->get_new_word_info($id,Session::get('usr_id'));

        if($info){
            $array['msg'] = "该单词已经在你的生词本中咯";
            die(json_encode($array));
        }else{
            $word_info = $rep_dao->gwt_word_info($id);
            if($word_info["user_list"] ){
                $user_list = $word_info['user_list'].','.Session::get('usr_id');
            }else{
                $user_list = Session::get('usr_id');
            }
            $rep_dao->update_new_list($id,$user_list);
        }
        $array['code'] = 1;
        $array['msg'] = "成功添加到生词本";
        die(json_encode($array));
    }


}