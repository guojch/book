<?php


namespace app\assets;

use yii\web\AssetBundle;
use app\common\services\UrlService;
use app\common\services\UtilService;

class MAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
//    public $css = [
//        'font-awesome/css/font-awesome.css',
//        'css/wap/css_style.css',
//        'css/wap/app.css?ver=20170401',
//    ];
//    public $js = [
//    ];
    public function registerAssetFiles($view) {
        
        $release_version = defined('RELEASE_VERSION')?RELEASE_VERSION:time();
        
        $this->css = [
            UrlService::buildWwwUrl( "/font-awesome/css/font-awesome.css"),
            UrlService::buildWwwUrl( "/css/m/css_style.css"),
            UrlService::buildWwwUrl( "/css/m/app.css",[ 'ver' => $release_version ] ),
        ];

        if( UtilService::isWechat() ){
            $this->js = [
                'https://res.wx.qq.com/open/js/jweixin-1.0.0.js',
                UrlService::buildWwwUrl( "/plugins/jquery-2.1.1.js"),
                UrlService::buildWwwUrl( "/js/m/TouchSlide.1.1.js"),
                UrlService::buildWwwUrl( "/js/m/common.js",[ 'ver' => $release_version ] ),
                UrlService::buildWwwUrl( "/js/m/weixin.js"),
            ];
        }else{
            $this->js = [
                UrlService::buildWwwUrl( "/plugins/jquery-2.1.1.js"),
                UrlService::buildWwwUrl( "/js/m/TouchSlide.1.1.js"),
                UrlService::buildWwwUrl( "/js/m/common.js",[ 'ver' => $release_version ] )
            ];
        }
        
        parent::registerAssetFiles($view);
    }
}
