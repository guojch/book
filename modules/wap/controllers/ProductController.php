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
    
    //商品列表
    public function actionList(){
        $this->layout = false;
        return $this->render('list');
    }
    
    //商品详情
    public function actionInfo(){
        $this->layout = false;
        return $this->render('info');
    }
    
    //用户下单页面
    public function actionOrder(){
        $this->layout = false;
        return $this->render('order');
    }
}
