<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modules\wap\controllers;

use yii\web\Controller;
/**
 * Description of ProductController
 *
 * @author guojch
 */
class ProductController extends Controller{
    
    public function __construct($id, $module, $config = array()) {
        parent::__construct($id, $module, $config);
        $this->layout = 'main';
    }
    
    //商品列表
    public function actionList(){

        return $this->render('list');
    }
    
    //商品详情
    public function actionInfo(){

        return $this->render('info');
    }
    
    //用户下单页面
    public function actionOrder(){

        return $this->render('order');
    }
}
