<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modules\web\controllers;

use app\modules\web\controllers\common\BaseController;

/**
 * Description of StatController
 *
 * @author guojch
 */
class StatController extends BaseController {
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
