<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/1
 * Time: 23:29
 */

namespace app\common\services;

//构建链接
use yii\helpers\Url;

class UrlService {
    //构建web的链接
    public static function buildWebUrl($path,$params = []){
        $domain_config = \Yii::$app->params['domain'];
        $path = Url::toRoute(array_merge([$path],$params));
        return $domain_config['web'].$path;
    }

    //构建wap的链接
    public static function buildWapUrl($path,$params = []){
        $domain_config = \Yii::$app->params['domain'];
        $path = Url::toRoute(array_merge([$path],$params));
        return $domain_config['wap'].$path;
    }

    //构建官网的链接
    public static function buildIndexUrl($path,$params = []){
        $domain_config = \Yii::$app->params['domain'];
        $path = Url::toRoute(array_merge([$path],$params));
        return $domain_config['index'].$path;
    }

    //构建空链接
    public static function buildNullUrl(){
        return 'javascript:void(0);';
    }
}