<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modules\wap\controllers;

use app\modules\wap\controllers\common\BaseController;
/**
 * Description of ProductController
 *
 * @author guojch
 */
class ProductController extends BaseController {
    
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
