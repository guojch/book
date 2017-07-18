<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modules\web\controllers;

use app\modules\web\controllers\common\BaseController;

/**
 * Description of BrandController
 *
 * @author guojch
 */
class BrandController extends BaseController {
    
    public function __construct($id, $module, $config = array()) {
        parent::__construct($id, $module, $config);
        $this->layout = 'main';
    }
    
    //品牌信息
    public function actionInfo(){

        return $this->render('info');
    }
    
    //品牌编辑
    public function actionEdit(){
        if(\Yii::$app->request->isGet){
            return $this->render('edit');
        }

    }
    //品牌相册
    public function actionImages(){

        return $this->render('images');
    }
}
