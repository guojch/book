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
    
    public function __construct($id, $module, $config = array()) {
        parent::__construct($id, $module, $config);
        $this->layout = 'stat';
    }
    
    //财务统计
    public function actionFinance(){

        return $this->render('finance');
    }
    
    //商品售卖统计
    public function actionProduct(){

        return $this->render('product');
    }
    
    //会员消费统计
    public function actionMember(){

        return $this->render('member');
    }
    
    //分享统计
    public function actionShare(){

        return $this->render('share');
    }
}
