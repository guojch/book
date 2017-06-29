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
    
    public function __construct($id, $module, $config = array()) {
        parent::__construct($id, $module, $config);
        $this->layout = 'main';
    }
    
    //用户登录
    public function actionLogin(){
        $this->layout = false;
        return $this->render('login');
    }
    
    //用户编辑
    public function actionEdit(){

        return $this->render('edit');
    }
    
    //用户重置密码
    public function actionResetPwd(){

        return $this->render('reset_pwd');
    }
}
