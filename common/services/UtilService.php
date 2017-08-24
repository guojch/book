<?php

namespace app\common\services;
use  yii\helpers\Html;

class UtilService {
	public static function getRootPath(){
		$vendor_path = \Yii::$app->vendorPath;
		return dirname($vendor_path);
	}

	public static function encode( $dispaly_text ){
		return  Html::encode($dispaly_text);
	}

	public static function getIP(){
		if (!empty($_SERVER["HTTP_X_FORWARDED_FOR"]))
			return $_SERVER["HTTP_X_FORWARDED_FOR"];
		return isset($_SERVER["REMOTE_ADDR"]) ? $_SERVER["REMOTE_ADDR"]:'';
	}

	public static  function isWechat(){
		$ug= isset($_SERVER['HTTP_USER_AGENT'])?$_SERVER['HTTP_USER_AGENT']:'';
		if( stripos($ug,'micromessenger') !== false ){
			return true;
		}
		return false;
	}
}