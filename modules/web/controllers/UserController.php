<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modules\web\controllers;

use yii\web\Controller;
/**
 * Description of UserController
 *
 * @author guojch
 */
class UserController extends Controller{
    
    //用户登录
    public function actionLogin(){
        $this->layout = false;
        return $this->render('login');
    }
    
    //用户编辑
    public function actionEdit(){
        $this->layout = false;
        return $this->render('edit');
    }
    
    //用户重置密码
    public function actionResetPwd(){
        $this->layout = false;
        return $this->render('reset_pwd');
    }
}
