<?php

namespace app\controllers;


use app\common\components\BaseWebController;
use app\common\services\applog\ApplogService;
use Yii;
use yii\log\FileTarget;

class ErrorController extends BaseWebController {

    public function actionError(){
        $error = Yii::$app->errorHandler->exception;
        $err_msg = "";
        if ($error) {
            $code = $error->getCode();
            $msg = $error->getMessage();
            $file = $error->getFile();
            $line = $error->getLine();

            $time = microtime(true);
            $log = new FileTarget();
            $log->logFile = Yii::$app->getRuntimePath() . '/logs/err.log';

            $err_msg = $msg . " [file: {$file}][line: {$line}][err code:$code.]".
                "[url:{$_SERVER['REQUEST_URI']}][post:".http_build_query($_POST)."]";


            $log->messages[] = [
                $err_msg,
                1,
                'application',
                $time
            ];
            $log->export();
            ApplogService::addErrorLog(Yii::$app->id,$err_msg);
        }

        return $this->render("error",[
            "err_msg" => $err_msg
        ]);
    }

    public function actionCapture(){
        $yii_cookies = [];
        $cookies = Yii::$app->request->cookies;
        foreach( $_COOKIE as $_c_key => $_c_val ){
            $yii_cookies[] = $_c_key.":".$cookies->get($_c_key);
        }

        $referer = isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'';
        $ua = isset($_SERVER['HTTP_USER_AGENT'])?$_SERVER['HTTP_USER_AGENT']:'';
        $url = $this->post("url","");
        $message = $this->post("message","");
        $error = $this->post("error","");
        $err_msg = "JS ERROR：[url:{$referer}],[ua:{$ua}],[js_file:{$url}],[error:{$message}],[error_info:{$error}]";

        if( !$url ){
            $err_msg .= ",[cookie:{".implode(";",$yii_cookies)."}]";
        }

        ApplogService::addErrorLog("app-js",$err_msg);
    }

}