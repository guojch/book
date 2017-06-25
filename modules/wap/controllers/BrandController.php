<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modules\wap\controllers;

use yii\web\Controller;
/**
 * Description of BrandController
 *
 * @author guojch
 */
class BrandController extends Controller{
    
    //品牌首页
    public function actionIndex(){
        $this->layout = false;
        return $this->render('index');
    }
}
