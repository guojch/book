<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\common\components;

use yii\web\Controller;
use yii\web\Cookie;

/**
 * Description of BaseWebController
 *
 * @author guojch
 */
class BaseWebController extends Controller{
    public $enableCsrfValidation = false;//关闭csrf

    //获取get参数
    public function get($key,$default_val = ''){
        return \Yii::$app->request->get($key,$default_val);
    }

    //获取post参数
    public function post($key,$default_val = ''){
        return \Yii::$app->request->post($key,$default_val);
    }

    //设置cookie值
    public function setCookie($name,$value,$expire = 0){
        $cookies = \Yii::$app->response->cookies;
        $cookies->add(new Cookie([
            'name' => $name,
            'value' => $value,
            'expire' => $expire
        ]));
    }

    //获取cookie值
    public function getCookie($name,$default_val = ''){
        $cookies = \Yii::$app->request->cookies;
        return $cookies->getValue($name,$default_val);
    }

    //删除cookie
    public function removeCookie($name){
        $cookies = \Yii::$app->response->cookies;
        $cookies->remove($name);
    }

    //api统一返回json格式方法
    public function renderJson($data = [],$msg = 'ok',$code = 200){
        echo json_encode([
            'code' => $code,
            'msg' => $msg,
            'data' => $data,
            'req_id' => uniqid() //序列号，该方法确保每次生成的序列号一定不一样。
        ]);
    }

    //统一JS提示方法
    public function renderJs($msg,$url){
        return $this->renderPartial('@app/views/common/jsTip',['msg'=>$msg,'url'=>$url]);
    }
}
