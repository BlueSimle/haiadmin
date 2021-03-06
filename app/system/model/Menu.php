<?php
namespace app\system\model;
/*
* 
* Created by PhpStorm.
* Author: 初心 [jialin507@foxmail.com]
* Date: 2017/3/27
*/

use think\Model;

class Menu extends Model {
    // 关闭自动写入update_time字段
    protected $updateTime = false;
    protected $createTime = false;

    //设置当前模型的数据表名称
    protected $table = 'system_auth_rule';

    public function getLinkAttr($value)
    {
        !$value && $value = '无';
        return $value;
    }

    public function getMenu($pid = 0, $start = 0, $limit = 10){
        $data = $this->where(['pid'=>$pid])->limit($start, $limit)->order('orders ASC')->select();

        return $data;
    }

    public function getPage($pid = 0, $limit = 10){
        $page = $this->where(['pid'=>$pid])->count();
        $page = floor($page / $limit);
        return $page;
    }
    public function setCreateTimeAttr($value)
    {
        return $value && strtotime($value);
    }

    /**
     * 检测是否存在下级菜单
     * @param $pid
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function getSubMenu($pid){
        $res = $this->where(['pid'=>$pid])->select();
        return $res;
    }
}