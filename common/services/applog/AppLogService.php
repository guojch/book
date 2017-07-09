<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/3
 * Time: 23:24
 */

namespace app\common\services\applog;


use app\common\services\UtilService;
use app\models\AppLog;

class AppLogService{
    /*
     * 记录错误日志
     */
    public static function addErrorLog($appname,$content){
        $error = \Yii::$app->errorHandler->exception;
        $model_app_log = new AppLog();
        $model_app_log->app_name = $appname;
        $model_app_log->content = $content;
        $model_app_log->ip = UtilService::getIP();

        if(!empty($_SERVER['HTTP_USER_AGENT'])){
            $model_app_log->ua = $_SERVER['HTTP_USER_AGENT'];
        }

        if($error){
            $model_app_log->err_code = $error->getCode();
            if(isset($error->statusCode)){
                $model_app_log->http_code = $error->statusCode;
            }
            if(method_exists($error,'getName')){
                $model_app_log->err_name = $error->getName();
            }
        }

        $model_app_log->save();
    }
}