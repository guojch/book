<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modules\web\controllers;

use yii\web\Controller;

/**
 * Description of AccountController
 *
 * @author guojch
 */
class AccountController extends Controller{
    
    //账户列表
    public function actionList(){
        $this->layout = false;
        return $this->render('list');
    }
    
    //账户编辑与添加
    public function actionEdit(){
        $this->layout = false;
        return $this->render('edit');
    }
    
    //账户详情
    public function actionInfo(){
        $this->layout = false;
        return $this->render('info');
    }
}
