<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/9
 * Time: 22:01
 */

namespace app\modules\wap\controllers\common;


use app\common\components\BaseWebController;

class BaseController extends BaseWebController {
    public function __construct($id, $module, array $config = []){
        parent::__construct($id, $module, $config);
        $this->layout = 'main';
    }

    public function beforeAction($action){
        return true;
    }
}