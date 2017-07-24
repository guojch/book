<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modules\web\controllers;

use app\models\BrandSetting;
use app\modules\web\controllers\common\BaseController;

/**
 * Description of BrandController
 *
 * @author guojch
 */
class BrandController extends BaseController {
    
    public function __construct($id, $module, $config = array()) {
        parent::__construct($id, $module, $config);
        $this->layout = 'main';
    }
    
    //品牌信息
    public function actionInfo(){
        $info = BrandSetting::find()->one();
        return $this->render('info',['info'=>$info]);
    }
    
    //品牌编辑
    public function actionEdit(){
        if(\Yii::$app->request->isGet){
            $info = BrandSetting::find()->one();
            return $this->render('edit',['info'=>$info]);
        }

        $name = trim($this->post('name',''));
        $phone = trim($this->post('phone',''));
        $address = trim($this->post('address',''));
        $description = trim($this->post('description',''));

        if(mb_strlen($name,'utf-8') < 1){
            return $this->renderJson([],'请输入品牌名称。',-1);
        }
        if(mb_strlen($phone,'utf-8') < 1){
            return $this->renderJson([],'请输入手机号码。',-1);
        }
        if(mb_strlen($address,'utf-8') < 1){
            return $this->renderJson([],'请输入地址。',-1);
        }
        if(mb_strlen($description,'utf-8') < 1){
            return $this->renderJson([],'请输入品牌介绍。',-1);
        }

        $info = BrandSetting::find()->one();
        if($info){
            $model_brand = $info;
        }else{
            $model_brand = new BrandSetting();
        }
        $model_brand->name = $name;
        $model_brand->phone = $phone;
        $model_brand->address = $address;
        $model_brand->description = $description;
        $model_brand->updated_time = date('Y-m-d H:i:s');
        $model_brand->save();

        return $this->renderJson([],'操作成功。');
    }
    //品牌相册
    public function actionImages(){

        return $this->render('images');
    }
}
