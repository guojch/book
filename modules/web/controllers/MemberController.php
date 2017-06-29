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
    
    public function __construct($id, $module, $config = array()) {
        parent::__construct($id, $module, $config);
        $this->layout = 'main';
    }
    
    //会员列表
    public function actionList(){

        return $this->render('list');
    }
    
    //会员详情
    public function actionInfo(){

        return $this->render('info');
    }
    
    //会员编辑与添加
    public function actionEdit(){

        return $this->render('edit');
    }
    
    //会员评论列表
    public function actionComment(){

        return $this->render('comment');
    }
}
