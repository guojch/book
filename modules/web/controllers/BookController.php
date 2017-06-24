<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modules\web\controllers;

use yii\web\Controller;
/**
 * Description of BookController
 *
 * @author guojch
 */
class BookController extends Controller{

    //图书列表
    public function actionList(){
        $this->layout = false;
        return $this->render('list');
    }
    
    //图书编辑与添加
    public function actionEdit(){
        $this->layout = false;
        return $this->render('edit');
    }
    
    //图书详情
    public function actionInfo(){
        $this->layout = false;
        return $this->render('info');
    }
    
    //图书图片资源
    public function actionImages(){
        $this->layout = false;
        return $this->render('images');
    }
    
    //图书分类列表
    public function actionCat(){
        $this->layout = false;
        return $this->render('cat');
    }
    
    //图书分类的编辑与添加
    public function actionCat_edit(){
        $this->layout = false;
        return $this->render('cat_edit');
    }
}
