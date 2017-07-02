<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modules\web\controllers;

use app\modules\web\controllers\common\BaseController;

/**
 * Description of DashboardController
 *
 * @author guojch
 */
class DashboardController extends BaseController {
    
    public function __construct($id, $module, $config = array()) {
        parent::__construct($id, $module, $config);
        $this->layout = 'main';
    }
    
    //仪表盘
    public function actionInfo(){

        return $this->render('info');
    }
}
