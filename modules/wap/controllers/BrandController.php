<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modules\wap\controllers;

use app\models\BrandImages;
use app\models\BrandSetting;
use app\modules\wap\controllers\common\BaseController;
/**
 * Description of BrandController
 *
 * @author guojch
 */
class BrandController extends BaseController {
    //品牌首页
    public function actionIndex(){
        $info = BrandSetting::find()->one();
        $image_list = BrandImages::find()->orderBy(['id'=>SORT_DESC])->all();
        return $this->render('index',[
            'info' => $info,
            'image_list' => $image_list
        ]);
    }
}
