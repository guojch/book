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
    
    //我的
    public function actionIndex(){
        $this->layout = false;
        return $this->render('index');
    }
    
    //我的地址列表
    public function actionAddress(){
        $this->layout = false;
        return $this->render('address');
    }
    
    //添加或编辑我的地址
    public function actionAddress_Edit(){
        $this->layout = false;
        return $this->render('address_edit');
    }
    
    //我的收藏
    public function actionFavorite(){
        $this->layout = false;
        return $this->render('favorite');
    }
    
    //帐号绑定
    public function actionBind(){
        $this->layout = false;
        return $this->render('bind');
    }
    
    //我的购物车
    public function actionCart(){
        $this->layout = false;
        return $this->render('cart');
    }
    
    //我的订单页面
    public function actionOrder(){
        $this->layout = false;
        return $this->render('order');
    }
    
    //用户评论
    public function actionComment(){
        $this->layout = false;
        return $this->render('comment');
    }
    
    //评论编辑
    public function actionComment_set(){
        $this->layout = false;
        return $this->render('comment_set');
    }
}
