<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modules\web\controllers;

use app\modules\web\controllers\common\BaseController;

/**
 * Description of AccountController
 *
 * @author guojch
 */
class AccountController extends BaseController {
    
    public function __construct($id, $module, $config = array()) {
        parent::__construct($id, $module, $config);
        $this->layout = 'main';
    }
    
    //账户列表
    public function actionList(){
        
        return $this->render('list');
    }
    
    //账户编辑与添加
    public function actionEdit(){
        
        return $this->render('edit');
    }
    
    //账户详情
    public function actionInfo(){
        
        return $this->render('info');
    }
}
