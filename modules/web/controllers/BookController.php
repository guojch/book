<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modules\web\controllers;

use app\modules\web\controllers\common\BaseController;

/**
 * Description of BookController
 *
 * @author guojch
 */
class BookController extends BaseController {
    
    //图书列表
    public function actionList(){

        return $this->render('list');
    }
    
    //图书编辑与添加
    public function actionEdit(){

        return $this->render('edit');
    }
    
    //图书详情
    public function actionInfo(){

        return $this->render('info');
    }
    
    //图书图片资源
    public function actionImages(){

        return $this->render('images');
    }
    
    //图书分类列表
    public function actionCat(){

        return $this->render('cat');
    }
    
    //图书分类的编辑与添加
    public function actionCat_edit(){

        return $this->render('cat_edit');
    }
}
