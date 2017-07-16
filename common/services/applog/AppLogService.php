<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/3
 * Time: 23:24
 */

namespace app\common\services\applog;


use app\common\services\UtilService;
use app\models\AppAccessLog;
use app\models\AppLog;

class AppLogService{

    // 记录错误日志
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

    // 记录用户访问日志
    public static function addAppAccessLog($user_id = 0){
        $get_params = \Yii::$app->request->get();
        $post_params = \Yii::$app->request->post();

        $target_url = $_SERVER['REQUEST_URI']?$_SERVER['REQUEST_URI']:'';
        $referer = $_SERVER['HTTP_REFERER']?$_SERVER['HTTP_REFERER']:'';
        $ua = $_SERVER['HTTP_USER_AGENT']?$_SERVER['HTTP_USER_AGENT']:'';

        $access_log = new AppAccessLog();
        $access_log->user_id = $user_id;
        $access_log->referer_url = $referer;
        $access_log->target_url = $target_url;
        $access_log->query_params = json_encode(array_merge($get_params,$post_params));
        $access_log->ua = $ua;
        $access_log->ip = UtilService::getIP();
        $access_log->save();
    }
}