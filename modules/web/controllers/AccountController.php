<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modules\web\controllers;

use app\common\services\ConstantMapService;
use app\common\services\StaticService;
use app\models\User;
use app\modules\web\controllers\common\BaseController;

/**
 * Description of AccountController
 *
 * @author guojch
 */
class AccountController extends BaseController {
    
    public function __construct($id, $module, $config = array()) {
        parent::__construct($id, $module, $config);
        $this->layout = 'main';
    }
    
    //账户列表
    public function actionList(){

        $status = intval($this->get('status',ConstantMapService::$status_default));
        $mix_kw = trim($this->get('mix_kw',''));
        $page_cur = intval($this->get('page_cur',1));

        $query = User::find();
        //状态搜索
        if($status > ConstantMapService::$status_default){
            $query->andWhere(['status'=>$status]);
        }
        //关键字搜索
        if($mix_kw){
            $where_username = ['LIKE','username','%'.$mix_kw.'%',false];
            $where_phone = ['LIKE','phone','%'.$mix_kw.'%',false];//不加false，会默认添加2个百分号。
            $query->andWhere(['OR',$where_username,$where_phone]);
        }

        //分页功能
        $page_size = 1;
        $total_count = $query->count();
        $total_page = ceil($total_count/$page_size);

        $list = $query->orderBy(['id' => SORT_DESC])
            ->offset(($page_cur - 1) * $page_size)
            ->limit($page_size)
            ->asArray()
            ->all();

        return $this->render('list',[
            'list' => $list,
            'status_mapping' => ConstantMapService::$status_mapping,
            'search_conditions' => [
                'mix_kw' => $mix_kw,
                'status' => $status
            ],
            'pages' => [
                'total_page' => $total_page,
                'page_size' => $page_size,
                'total_count' => $total_count,
                'page_cur' => $page_cur
            ]
        ]);
    }
    
    //账户编辑与添加
    public function actionEdit(){
        
        return $this->render('edit');
    }
    
    //账户详情
    public function actionInfo(){
        
        return $this->render('info');
    }
}
