<?php
namespace app\system\controller;
/*
*
* Created by PhpStorm.
* Author: 初心 [jialin507@foxmail.com]
* Date: 2017/5/3
*/
use app\system\model\AdminUser as AdminUserModel;
use think\Controller;
use think\Loader;
use think\Session;

class Login extends Controller {
    protected $admin_user_model;

    protected function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
        $this->admin_user_model = new AdminUserModel();
    }

    //login页面
    public function index() {
        if(Session::has('system_user')){
            $this->redirect('/system');
        }
        return $this->view->fetch();
    }

    public function login() {
        $post_data = $this->request->param();
        /*$validate = Loader::validate('Login');
        if(!$validate->check($post_data)){
            return getMsg($validate->getError());
        }*/
        /*if(!$info = User::get(['username'=>$post_data['user']])){
            return getMsg('用户名或密码错误');
        }
        if($info['password'] != auth_password($post_data['pwd'])){
            return getMsg('用户名或密码错误');
        }*/
        $admin_user_id = $this->admin_user_model->checkLogin($post_data['username'],auth_password($post_data['password']));
        if($admin_user_id){
            Session::set('admin_user_id', $admin_user_id);
            Session::set('admin_user_name', $post_data['username']);
            return getMsg('登录成功', url('Index/index'));
        }
    }

    /**
     * 退出登录
     */
    public function out() {
        Session::delete('admin_user_id');
        $this->redirect('index');
    }

}