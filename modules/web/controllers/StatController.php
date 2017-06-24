<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modules\web\controllers;

use yii\web\Controller;
/**
 * Description of StatController
 *
 * @author guojch
 */
class StatController extends Controller{
    
    //财务统计
    public function actionFinance(){
        $this->layout = false;
        return $this->render('finance');
    }
    
    //商品售卖统计
    public function actionProduct(){
        $this->layout = false;
        return $this->render('product');
    }
    
    //会员消费统计
    public function actionMember(){
        $this->layout = false;
        return $this->render('member');
    }
    
    //分享统计
    public function actionShare(){
        $this->layout = false;
        return $this->render('share');
    }
}
