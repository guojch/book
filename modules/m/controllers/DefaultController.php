<?php

namespace app\modules\m\controllers;

use app\models\brand\BrandImages;
use app\models\brand\BrandSetting;
use app\models\WxShareHistory;
use app\modules\m\controllers\common\BaseController;


class DefaultController extends BaseController {

    public function actionIndex(){
    	$info = BrandSetting::find()->one();
    	$image_list = BrandImages::find()->all();

        return $this->render('index',[
        	'info' => $info,
			'image_list' => $image_list
		]);
    }

    public function actionShared(){
    	$url = $this->post( "url","" );
    	if( !$url ){
			$url = isset( $_SERVER['HTTP_REFERER'] )?$_SERVER['HTTP_REFERER']:'';
		}

		$model_wx_shared = new WxShareHistory();
		$model_wx_shared->member_id = $this->current_user?$this->current_user['id']:0;
		$model_wx_shared->share_url = $url;
		$model_wx_shared->created_time = date("Y-m-d H:i:s");
		$model_wx_shared->save( 0 );
		return $this->renderJSON( [] );
	}

}
