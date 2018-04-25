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
        $this->assign('user_id',Session::get('user_id'));
        return view();
    }

    public function add_view(){
        return view('add');
    }






}