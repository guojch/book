<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modules\web\controllers;

use yii\web\Controller;
/**
 * Description of MemberController
 *
 * @author guojch
 */
class MemberController extends Controller{
    //会员列表
    public function actionIndex(){
        $this->layout = false;
        return $this->render('index');
    }
    
    //会员详情
    public function actionInfo(){
        $this->layout = false;
        return $this->render('info');
    }
    
    //会员编辑与添加
    public function actionSet(){
        $this->layout = false;
        return $this->render('set');
    }
    
    //会员评论列表
    public function actionComment(){
        $this->layout = false;
        return $this->render('comment');
    }
}
