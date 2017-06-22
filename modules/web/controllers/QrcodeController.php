<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modules\web\controllers;

use yii\web\Controller;
/**
 * Description of QrcodeController
 *
 * @author guojch
 */
class QrcodeController extends Controller{
    //渠道二维码列表
    public function actionIndex(){
        $this->layout = false;
        return $this->render('index');
    }
    
    //渠道二维码添加与编辑
    public function actionEdit(){
        $this->layout = false;
        return $this->render('edit');
    }
}
