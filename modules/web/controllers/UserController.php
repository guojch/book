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
        if(!$user_info->verifyPassword($login_pwd)){
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
        //get请求，渲染页面
        if(\Yii::$app->request->isGet){
            return $this->render('edit',['user_info'=>$this->current_user]);
        }

        $username = trim($this->post('username',''));
        $email = trim($this->post('email',''));
        if(mb_strlen($username,'utf-8') < 1){
            return $this->renderJson([],'请输入合法的姓名。','-1');
        }
        if(mb_strlen($email,'utf-8') < 1){
            return $this->renderJson([],'请输入合法的邮箱地址。','-1');
        }

        $user_info = $this->current_user;
        $user_info->username = $username;
        $user_info->email = $email;
        $user_info->updated_time = date('Y-wap-d H:i:s');
        $user_info->update();

        return $this->renderJson([],'编辑成功。');
    }
    
    // 用户重置密码
    public function actionResetPwd(){
        //get请求，渲染页面
        if(\Yii::$app->request->isGet){
            return $this->render('reset_pwd',['user_info'=>$this->current_user]);
        }

        $old_password = trim($this->post('old_password',''));
        $new_password = trim($this->post('new_password',''));
        if(mb_strlen($old_password,'utf-8') < 1){
            return $this->renderJson([],'请输入原密码。','-1');
        }
        if(mb_strlen($new_password,'utf-8') < 6){
            return $this->renderJson([],'请输入不少于6位字符的新密码。','-1');
        }
        if($old_password == $new_password){
            return $this->renderJson([],'新密码不能与原密码相同。','-1');
        }
        //判断原密码是否正确
        $user_info = $this->current_user;
        if(!$user_info->verifyPassword($old_password)){
            return $this->renderJson([],'原密码错误，请重新输入。','-1');
        }

        $user_info->setPassword($new_password);
        $user_info->update();

        // 修改用户的登录状态(cookie做了改变)：
        $this->setLoginStatus($user_info);

        return $this->renderJson([],'重置密码成功。');
    }

    // 用户退出
    public function actionLogout(){
        $this->removeLoginStatus();
        return $this->redirect(UrlService::buildWebUrl('/user/login'));
    }
}
