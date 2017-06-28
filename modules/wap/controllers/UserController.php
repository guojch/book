<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modules\wap\controllers;

use yii\web\Controller;
/**
 * Description of UserController
 *
 * @author guojch
 */
class UserController extends Controller{
    
    public function __construct($id, $module, $config = array()) {
        parent::__construct($id, $module, $config);
        $this->layout = 'main';
    }
    
    //我的
    public function actionIndex(){

        return $this->render('index');
    }
    
    //我的地址列表
    public function actionAddress(){

        return $this->render('address');
    }
    
    //添加或编辑我的地址
    public function actionAddress_Edit(){

        return $this->render('address_edit');
    }
    
    //我的收藏
    public function actionFavorite(){

        return $this->render('favorite');
    }
    
    //帐号绑定
    public function actionBind(){

        return $this->render('bind');
    }
    
    //我的购物车
    public function actionCart(){

        return $this->render('cart');
    }
    
    //我的订单页面
    public function actionOrder(){

        return $this->render('order');
    }
    
    //用户评论
    public function actionComment(){

        return $this->render('comment');
    }
    
    //评论编辑
    public function actionComment_set(){

        return $this->render('comment_set');
    }
}
