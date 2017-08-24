<?php
namespace app\modules\weixin\controllers;

use app\common\components\BaseWebController;
use app\common\services\UrlService;
use app\common\services\weixin\RequestService;

class MenuController extends BaseWebController {

	public function actionSet(){
		$menu  = [
			"button" => [
				[
					"name" => "商城",
					"type" => "view",
					"url"  => UrlService::buildMUrl("/default/index")
				],
				[
					"name" => "我",
					"type" => "view",
					"url" => UrlService::buildMUrl("/user/index")
				]
			]
		];
		$config = \Yii::$app->params['weixin'];
		RequestService::setConfig( $config['appid'],$config['token'],$config['sk'] );
		$access_token = RequestService::getAccessToken();
		if( $access_token ){
			$url = "menu/create?access_token={$access_token}";
			$ret = RequestService::send( $url,json_encode($menu,JSON_UNESCAPED_UNICODE), 'POST' );
			var_dump( $ret );
		}
	}
}
