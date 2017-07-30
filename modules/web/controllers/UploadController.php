<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/30
 * Time: 13:25
 */

namespace app\modules\web\controllers;


use app\common\services\UploadService;
use app\modules\web\controllers\common\BaseController;

class UploadController extends BaseController {
    private $allow_file_type = ['jpg', 'gif', 'png', 'jpeg'];
    /**
     * 上传接口
     * bucket:avatar/brand/book
     */
    public function actionPic(){
        $bucket = trim($this->post('bucket',''));
        $callback = "window.parent.upload";// error,success
        // 判断文件是否存在
        if(!$_FILES || !isset($_FILES['pic'])){
            return "<script>{$callback}.error('请选择文件。')</script>";
        }
        // 判断图片后缀名时候允许
        $file_name = $_FILES['pic']['name'];
        $tmp_file_extend = explode('.',$file_name);
        if(!in_array(strtolower(end($tmp_file_extend)),$this->allow_file_type)){
            return "<script>{$callback}.error('文件类型不允许，类型允许png,gif,jpg,jpeg。')</script>";
        }

        $ret = UploadService::uploadByFile($file_name,$_FILES['pic']['tmp_name'],$bucket);
        if(!$ret){
            return "<script>{$callback}.error('".UploadService::getLastErrorMsg()."')</script>";
        }

        return "<script>{$callback}.success('{$ret['path']}')</script>";
    }
}