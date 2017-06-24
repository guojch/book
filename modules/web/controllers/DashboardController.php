<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modules\web\controllers;

use yii\web\Controller;
/**
 * Description of DashboardController
 *
 * @author guojch
 */
class DashboardController extends Controller{
    //仪表盘
    public function actionInfo(){
        $this->layout = false;
        return $this->render('info');
    }
}
