<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/3
 * Time: 23:27
 */

namespace app\common\services;

/*
 * 封装通用方法
 */
class UtilService{
    /*
     * 获取IP
     */
    public static function getIP(){
        if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
            //设置了反向代理
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        return $_SERVER['REMOTE_ADDR'];
    }
}