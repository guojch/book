<?php
/**
 * Class JssdkController
 */

namespace app\modules\weixin\controllers;


use app\common\components\BaseWebController;
use app\common\services\weixin\RequestService;

class JssdkController extends BaseWebController {

	public function actionIndex(){
		$ticket = $this->getJsapiTicket();
		$url = $this->get("url");
		$timestamp = time();
		$noncestr = $this->createNoncestr( );
		$string = "jsapi_ticket={$ticket}&noncestr={$noncestr}&timestamp={$timestamp}&url={$url}";
		$signature = sha1( $string );
		$config = \Yii::$app->params['weixin'];
		$data = [
			'appId' => $config['appid'],
			'timestamp' => $timestamp,
			'nonceStr' => $noncestr,
			'signature' => $signature,
			'string' => $string
		];
		return $this->renderJson( $data  );
	}

	private function createNoncestr( $length = 16 ){
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$str = '';
		for( $i =0 ;$i < $length ;$i++){
			$str .= substr( $chars,mt_rand( 0,strlen( $chars ) - 1 ),1 );
		}
		return $str;
	}

	private function getJsapiTicket(){
		$cache_key = "wx_jsticket";
		$cache = \Yii::$app->cache;

		$ticket = $cache->get( $cache_key );
		if( !$ticket ){
			$config = \Yii::$app->params['weixin'];
			RequestService::setConfig( $config['appid'],$config['token'],$config['sk'] );
			$access_token = RequestService::getAccessToken();
			$res = RequestService::send("ticket/getticket?access_token={$access_token}&type=jsapi" );
			if( isset( $res['errcode'] ) && $res['errcode'] == 0  ){
				$cache->set( $cache_key,$res['ticket'],$res['expires_in'] - 200 );
				$ticket = $res['ticket'];
			}
		}
		return $ticket;
	}
}