<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-8-11
 * Time: 10:49
 */

namespace app\service\controller;

use think\Controller;
use think\facade\Session;

class Base extends Controller
{
    //从缓存中获取uid
    protected function getUid($type)
    {
        $uid = '';
        if($type == 1){
            $uid = Session::get('user_id');
        } elseif ($type == 2){
            $uid = Session::get('u_id');
        }
        return $uid;
    }
}