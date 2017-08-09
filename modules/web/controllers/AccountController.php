<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modules\web\controllers;

use app\common\services\ConstantMapService;
use app\common\services\UrlService;
use app\models\AppAccessLog;
use app\models\User;
use app\modules\web\controllers\common\BaseController;

/**
 * Description of AccountController
 *
 * @author guojch
 */
class AccountController extends BaseController {
    
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
        $page_size = 10;
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

        if(\Yii::$app->request->isGet){
            $id = intval($this->get('id',0));
            $user_info = null;
            if($id){
                $user_info = User::find()->where(['id'=>$id])->one();
            }
            return $this->render("edit",[
                'user_info' => $user_info
            ]);
        }

        $username = trim($this->post('username',''));
        $phone = trim($this->post('phone',''));
        $email = trim($this->post('email',''));
        $login_name = trim($this->post('login_name',''));
        $login_pwd = trim($this->post('login_pwd',''));
        $user_id = $this->post('user_id',0);

        if(mb_strlen($username,'utf-8') < 1){
            return $this->renderJson([],'请输入符合规范的姓名。',-1);
        }
        if(mb_strlen($phone,'utf-8') < 1){
            return $this->renderJson([],'请输入符合规范的手机号。',-1);
        }
        if(mb_strlen($email,'utf-8') < 1){
            return $this->renderJson([],'请输入符合规范的邮箱。',-1);
        }
        if(mb_strlen($login_name,'utf-8') < 1){
            return $this->renderJson([],'请输入符合规范的登录名。',-1);
        }
        if(mb_strlen($login_pwd,'utf-8') < 1){
            return $this->renderJson([],'请输入符合规范的登录密码。',-1);
        }

        $has_in = User::find()->where(['login_name'=>$login_name])->andWhere(['!=','id',$user_id])->count();
        if($has_in){
            return $this->renderJson([],'登录名已存在，请重新输入。',-1);
        }

        $info = User::find()->where(['id'=>$user_id])->one();
        if($info){
            // 编辑
            $model_user = $info;
        }else{
            // 添加
            $model_user = new User();
            $model_user->setSalt();
        }

        $model_user->username = $username;
        $model_user->phone = $phone;
        $model_user->email = $email;
        $model_user->avatar = ConstantMapService::$default_avatar;
        $model_user->login_name = $login_name;
        if($login_pwd != ConstantMapService::$default_password){
            $model_user->setPassword($login_pwd);
        }
        $model_user->updated_time = date('Y-wap-d H:i:s');
        $model_user->save();

        return $this->renderJson([],'操作成功。');
    }
    
    //账户详情
    public function actionInfo(){

        $id = intval($this->get('id',0));
        $reback_url = UrlService::buildWebUrl('/account/list');
        if(!$id){
            return $this->redirect($reback_url);
        }

        $user_info = User::find()->where(['id'=>$id])->one();
        if(!$user_info){
            return $this->redirect($reback_url);
        }

        $access_log = AppAccessLog::find()->where(['user_id'=>$user_info['id']])->orderBy(['id'=>SORT_DESC])->limit(10)->asArray()->all();

        return $this->render('info',[
            'user_info' => $user_info,
            'access_log' => $access_log
        ]);
    }

    // 操作方法
    public function actionOps(){
        if(!\Yii::$app->request->isPost){
            return $this->renderJson([],'系统繁忙，请稍后再试。',-1);
        }
        $id = intval($this->post('id',0));
        $act = trim($this->post('act',''));

        if(!$id){
            return $this->renderJson([],'请选择要操作的帐号。',-1);
        }
        if(!in_array($act,['remove','recover'])){
            return $this->renderJson([],'该操作无效。',-1);
        }


        $user_info = User::find()->where(['id'=>$id])->one();
        if(!$user_info){
            return $this->renderJson([],'该帐号不存在。',-1);
        }

        switch($act){
            case 'remove':
                $user_info->status = 0;
                break;
            case 'recover':
                $user_info->status = 1;
                break;
        }
        $user_info->updated_time = date('Y-wap-d H:i:s');
        $user_info->update();

        return $this->renderJson([],'操作成功。');
    }
}
