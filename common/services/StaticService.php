<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/9
 * Time: 16:35
 */

namespace app\common\services;

//只用于加载应用本身的资源文件
class StaticService{
    /*
     * 加载Js文件
     */
    public static function includeAppJsStatic($path,$depend){
        self::includeAppStatic('js',$path,$depend);
    }

    /*
     * 加载Css文件
     */
    public static function includeAppCssStatic($path,$depend){
        self::includeAppStatic('css',$path,$depend);
    }
    /*
     * 加载App资源
     * @type:类型（js、css）
     * @path:路径
     * @depend:依赖
     */
    protected static function includeAppStatic($type,$path,$depend){
        $release_version = defined('RELEASE_VERSION')?RELEASE_VERSION:time();
        $path = $path.'?ver='.$release_version;
        if($type == 'css'){
            \Yii::$app->getView()->registerCssFile($path,['depends'=>$depend]);
        }else{
            \Yii::$app->getView()->registerJsFile($path,['depends'=>$depend]);
        }
    }
}