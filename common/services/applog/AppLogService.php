<?php

namespace app\common\services\applog;



use app\common\services\UtilService;
use app\models\log\AppAccessLog;
use app\models\log\AppLog;
use Yii;

class ApplogService {

    public static function addErrorLog($appname,$content){

        $error = Yii::$app->errorHandler->exception;

        $model_app_logs = new AppLog();
        $model_app_logs->app_name = $appname;
        $model_app_logs->content = $content;


        $model_app_logs->ip = UtilService::getIP();

        if( !empty($_SERVER['HTTP_USER_AGENT']) ) {
            $model_app_logs ->ua = "[UA:{$_SERVER['HTTP_USER_AGENT']}]";
        }

        if ($error) {

            if(method_exists($error,'getName' )) {
                $model_app_logs->err_name = $error->getName();
            }

            if (isset($error->statusCode)) {
                $model_app_logs->http_code = $error->statusCode;
            }

            $model_app_logs->err_code = $error->getCode();
        }

        $model_app_logs->created_time = date("Y-m-d H:i:s");
        $model_app_logs->save(0);
    }

    public static function addAppLog( $uid = 0 ){

        $get_params = \Yii::$app->request->get();
        $post_params = \Yii::$app->request->post();
        if( isset( $post_params['summary'] ) ){
            unset( $post_params['summary'] );
        }


        $target_url = isset($_SERVER['REQUEST_URI'])?$_SERVER['REQUEST_URI']:'';

        $referer = Yii::$app->request->getReferrer();
        $ua = Yii::$app->request->getUserAgent();

        $access_log = new AppAccessLog();
        $access_log->uid = $uid;
        $access_log->referer_url = $referer?$referer:'';
        $access_log->target_url = $target_url;
        $access_log->query_params = json_encode(array_merge($get_params,$post_params));
        $access_log->ua = $ua?$ua:'';
        $access_log->ip = UtilService::getIP();
        $access_log->created_time = date("Y-m-d H:i:s");
        return $access_log->save(0);
    }
}