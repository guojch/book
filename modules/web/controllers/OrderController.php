<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modules\web\controllers;

use yii\web\Controller;
/**
 * Description of OrderController
 *
 * @author guojch
 */
class OrderController extends Controller{
    //订单列表
    public function actionIndex(){
        $this->layout = false;
        return $this->render('index');
    }
    
    //财务流水
    public function actionFinance(){
        $this->layout = false;
        return $this->render('finance');
    }
    
    //订单详情
    public function actionPayInfo(){
        $this->layout = false;
        return $this->render('pay_info');
    }
}
