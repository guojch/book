<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modules\web\controllers;

use app\modules\web\controllers\common\BaseController;
use app\common\services\UrlService;
use app\models\User;

/**
 * Description of UserController
 *
 * @author guojch
 */
class UserController extends BaseController {
    
    // 用户登录
    public function actionLogin(){
        $this->layout = false;

        // 如果是get请求，直接渲染登录页面
        if(\Yii::$app->request->isGet){
            return $this->render('login');
        }

        // 获取输入的用户名和密码
        $login_name = trim($this->post('login_name',''));
        $login_pwd = trim($this->post('login_pwd',''));
        if(!$login_name || !$login_pwd){
            return $this->renderJs('用户名或密码不能为空。',UrlService::buildWebUrl('/user/login'));
        }

        // 查看数据库中是否存在该用户
        $user_info = User::find()->where(['login_name'=>$login_name])->one();
        if(!$user_info){
            return $this->renderJs('该用户不存在。',UrlService::buildWebUrl('/user/login'));
        }

        // 验证密码
        // 密码加密算法：md5(login_pwd + md5(login_salt))
        $auth_pwd = md5($login_pwd . md5($user_info['login_salt']));
        if($auth_pwd != $user_info['login_pwd']){
            return $this->renderJs('密码错误。',UrlService::buildWebUrl('/user/login'));
        }

        // 保存用户的登录状态
        // cookies进行保存用户登录状态
        // 加密字符串 + '#' + id
        $this->setLoginStatus($user_info);
        return $this->redirect(UrlService::buildWebUrl('/dashboard/info'));
    }
    
    // 用户编辑
    public function actionEdit(){

        return $this->render('edit');
    }
    
    // 用户重置密码
    public function actionResetPwd(){

        return $this->render('reset_pwd');
    }

    // 用户退出
    public function actionLogout(){
        $this->removeLoginStatus();
        return $this->redirect(UrlService::buildWebUrl('/user/login'));
    }
}
