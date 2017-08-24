<?php

namespace app\modules\web\controllers;

use app\common\services\UrlService;
use app\common\services\UtilService;
use app\models\Images;
use app\modules\web\controllers\common\BaseController;
use app\common\services\UploadService;

class UploadController extends BaseController{

	protected  $allow_file = ["gif","jpg","png","jpeg"];

	/**
	 * 上传接口
	 * bucket: avatar/brand/book
	 */
	public function actionPic(){
		$uid = $this->post('uid',0);
		if( !$uid ){
			$uid = $this->getUid();
		}

		$bucket = $this->post('bucket','');
		$type = $this->post('type');
		$call_back_target = 'window.parent.upload';

		if( !$uid ){
			return "<script type='text/javascript'>{$call_back_target}.error('系统繁忙请稍后再试');</script>";
		}

		if(!$_FILES || !isset($_FILES['pic'])){
			return "<script type='text/javascript'>{$call_back_target}.error('没有选择文件');</script>";
		}

		$file_name = $_FILES['pic']['name'];

		$tmp_file_extend = explode(".", $file_name);
		if(!in_array( strtolower( end( $tmp_file_extend ) ),$this->allow_file) ){
			return "<script type='text/javascript'>{$call_back_target}.error('请上传图片文件,jpg,png,jpeg,gif');</script>";
		}

		$ret = UploadService::uploadByFile( $_FILES['pic']['name'],$_FILES['pic']['tmp_name'],$bucket );
		if( !$ret ){
			return "<script type='text/javascript'>{$call_back_target}.error('".UploadService::getLastErrorMsg()."');</script>";
		}
		return "<script type='text/javascript'>{$call_back_target}.success('{$ret['path']}','$type');</script>";
	}

}
