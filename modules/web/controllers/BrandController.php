<?php

namespace app\modules\web\controllers;

use app\models\BrandSetting;
use app\models\BrandImages;
use app\modules\web\controllers\common\BaseController;
use app\common\services\ConstantMapService;
use app\common\services\UrlService;

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

    /**
     * 品牌信息
     */
    public function actionInfo(){
        $info = BrandSetting::find()->one();
        return $this->render('info',[
            'info' => $info
        ]);
    }

    /**
     * 品牌编辑
     */
    public function actionEdit(){
        if(\Yii::$app->request->isGet){
            $info = BrandSetting::find()->one();
            return $this->render('edit',['info'=>$info]);
        }

        $name = trim($this->post('name',''));
        $image_key = trim($this->post('image_key',''));
        $phone = trim($this->post('phone',''));
        $address = trim($this->post('address',''));
        $description = trim($this->post('description',''));

        if(mb_strlen($name,'utf-8') < 1){
            return $this->renderJson([],'请输入品牌名称。',-1);
        }
        if(!$image_key){
            return $this->renderJson([],'请上传品牌logo。',-1);
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
        $model_brand->logo = $image_key;
        $model_brand->phone = $phone;
        $model_brand->address = $address;
        $model_brand->description = $description;
        $model_brand->updated_time = date('Y-m-d H:i:s');
        $model_brand->save();

        return $this->renderJson([],'操作成功。');
    }

    /**
     * 品牌相册
     */
    public function actionImages(){
        $list = BrandImages::find()->orderBy(['id'=>SORT_DESC])->all();
        return $this->render("images",[
            'list' => $list
        ]);
    }

    /**
     * 编辑品牌相册
     */
    public function actionEditImage(){
        $image_key = trim( $this->post("image_key","") );
        if(!$image_key){
            return $this->renderJSON([],"请上传图片之后在提交。",-1);
        }

        $total_count = BrandImages::find()->count();
        if($total_count >= 5){
            return $this->renderJSON([],"最多上传五张。",-1);
        }

        $model = new BrandImages();
        $model->image_key = $image_key;
        $model->save();
        return $this->renderJSON([],"操作成功。");
    }

    /**
     * 删除品牌相册
     */
    public function actionImageOps(){
        if(!\Yii::$app->request->isPost){
            return $this->renderJSON( [],ConstantMapService::$default_syserror,-1 );
        }

        $id = $this->post('id',[]);
        if(!$id){
            return $this->renderJSON([],"请选择要删除的图片。",-1);
        }

        $info = BrandImages::find()->where(['id'=>$id])->one();
        if(!$info){
            return $this->renderJSON([],"指定图片不存在。",-1);
        }
        $info->delete();
        return $this->renderJSON( [],"操作成功。" );
    }
}
