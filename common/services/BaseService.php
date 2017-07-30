<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/30
 * Time: 14:29
 */

namespace app\common\services;

/**
 * Class BaseService
 * @package app\common\services
 * 所有服务的基类
 */
class BaseService {
    protected static $_error_msg = null;
    protected static $_error_code = null;

    public static function _err($msg='',$code=-1){
        self::$_error_msg = $msg;
        self::$_error_code = $code;
        return false;
    }

    public static function getLastErrorMsg(){
        return self::$_error_msg;
    }

    public static function getLastErrorCode(){
        return self::$_error_code;
    }
}