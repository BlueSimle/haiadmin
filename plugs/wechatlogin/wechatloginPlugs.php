<?php
/*
* 微信登录插件
* Author: 初心 [jialin507@foxmail.com]
*/
namespace plugs\wechatlogin;
use app\base\controller\Plugs;
use think\Db;
class wechatloginPlugs extends Plugs{

    public $info =[
        'name'=>'wechatlogin',
        'title'=>'微信登录',
        'description'=>'可以通过网页授权方式获得微信登录者昵称头像等。',
        'webvisit'=>1,
        'status'=>1,
        'author'=>'初心',
        'version'=>'1.0'
    ];

    public function install(){
        //写入钩子
        Db::execute("INSERT INTO `system_hooks` VALUES ('', 'wechatlogin', '微信登录钩子', '1', ".time().", '')");
        return true;
    }

    public function uninstall(){
        //移除钩子
        Db::execute("delete from `system_hooks` where name='wechatlogin'");
        return true;
    }

    //实现的wechatlogin钩子方法
    //使用方法，在控制器或模板里直接调用 plugs('wechatlogin'); 登录后的信息会存在session中
    public function wechatlogin(){
        $this->wehcat_config = Db::name('system_addons')->where(['name' => 'wechatlogin'])->find();
        $this->wehcat_config = json_decode($this->wehcat_config['config'],true);
        $redirect_uri = $this->wehcat_config['wechat_host'] . url('system/plugs/open',['plugname'=>'wechatlogin','plugaction'=>'wechatlogin','plugfun'=>'index']);
        header("Location:".$redirect_uri);exit;
    }
}