<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers;

use yii\web\Controller;
use yii\log\FileTarget;
/**
 * Description of ErrorController
 *
 * @author guojch
 */
class ErrorController extends Controller{
    
    public function actionError(){
        //记录错误信息到文件和数据库
        $error = \Yii::$app->errorHandler->exception;
        $err_msg = '';
        if($error){
            $file = $error->getFile();
            $line = $error->getLine();
            $message = $error->getMessage();
            $code = $error->getCode();
            
            //写入到日志文件中
            $log = new FileTarget();
            $log->logFile = \Yii::$app->getRuntimePath()."/logs/err.log";
            
            $err_msg = $message."[file:{$file}][line:{$line}][code:{$code}][url:{$_SERVER['REQUEST_URI']}][POST_DATA:".http_build_query($_POST)."]";
        
            $log->messages[] = [
                $err_msg,
                1,
                'application',
                microtime(true)
            ];
            
            $log->export();
            
            //写入到数据库中
        }
        
        $this->layout = false;
        return $this->render('error',['err_msg'=>$err_msg]);
    }
}
