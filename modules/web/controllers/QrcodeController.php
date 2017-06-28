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
    
    public function __construct($id, $module, $config = array()) {
        parent::__construct($id, $module, $config);
        $this->layout = 'qrcode';
    }
    
    //渠道二维码列表
    public function actionList(){
        $this->layout = false;
        return $this->render('list');
    }
    
    //渠道二维码添加与编辑
    public function actionEdit(){
        $this->layout = false;
        return $this->render('edit');
    }
}
