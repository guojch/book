<?php
namespace app\modules\web\controllers;


use app\common\services\ConstantMapService;
use app\common\services\UrlService;
use app\models\User;
use app\modules\web\controllers\common\BaseController;

class UserController extends  BaseController{
	public function actionLogin(){
		if( \Yii::$app->request->isGet ){
			if( $this->checkLoginStatus() ){
				return $this->redirect( UrlService::buildWebUrl("/") );
			}
			$this->layout = "user";
			return $this->render("login");
		}

		$login_name = trim( $this->post("login_name","") );
		$login_pwd = trim( $this->post("login_pwd","") );

		if( mb_strlen($login_name,"utf-8") < 1 ){
			return $this->renderJS("请输入正确的登录用户名~~",UrlService::buildWebUrl("/user/login"));
		}

		if( mb_strlen($login_pwd,"utf-8") < 1 ){
			return $this->renderJS("请输入正确的登录密码~~",UrlService::buildWebUrl("/user/login"));
		}

		$user_info = User::find()->where([ 'login_name' => $login_name ])->one();
		if( !$user_info ){
			return $this->renderJS("请输入正确的用户名和密码~~",UrlService::buildWebUrl("/user/login"));
		}

		if( !$user_info->verifyPassword($login_pwd) ){
			return $this->renderJS("请输入正确的用户名和密码~~",UrlService::buildWebUrl("/user/login") );
		}

		$this->setLoginStatus( $user_info );
		return $this->redirect( UrlService::buildWebUrl("/default/index") );
	}

	public function actionEdit(){
		if( \Yii::$app->request->isGet){
			$this->layout  = "main";
			return $this->render("edit",[
				'info' => $this->current_user
			]);
		}

		$nickname = trim($this->post('nickname',''));
		$email = trim( $this->post('email','') );

		if( mb_strlen( $nickname,"utf-8" ) < 1 ){
			return $this->renderJSON( [],"请输入符合规范的姓名~~",-1 );
		}

		if( mb_strlen( $email,"utf-8" ) < 1 ){
			return $this->renderJSON( [],"请输入符合规范的邮箱地址~~",-1 );
		}

		$user_info = $this->current_user;

		$user_info->nickname = $nickname;
		$user_info->email = $email;
		$user_info->updated_time = date("Y-m-d H:i:s");
		$user_info->update(0);

		return $this->renderJSON([],"操作成功~~");
	}

	public function actionResetPwd(){

		if( \Yii::$app->request->isGet){
			return $this->render("reset_pwd",[
				'info' => $this->current_user
			]);
		}

		$old_password = trim($this->post('old_password',''));
		$new_password = trim($this->post('new_password',''));
		if(!$old_password){
			return $this->renderJSON([],"请输入原密码！",-1);
		}

		if( mb_strlen($new_password,"utf-8") < 6 ){
			return $this->renderJSON([],"请输入不少于6位的新密码！",-1);
		}

		if($old_password == $new_password){
			return $this->renderJSON([],"请重新输入一个吧，新密码和原密码不能相同哦！",-1);
		}

		$current_user = $this->current_user;
		if (!$current_user->verifyPassword($old_password)) {
			return $this->renderJSON([],"请检查原密码是否正确~~",-1);
		}

		if( $current_user['uid'] == 2 ){
			return $this->renderJSON([],"该账号为测试账号，请不要修改密码~~",-1);
		}

		$current_user->setPassword($new_password);
		$current_user->updated_time = date("Y-m-d H:i:s");
		$current_user->update(0);

		$this->setLoginStatus( $current_user );

		return $this->renderJSON([],"修改成功~~");
	}

	public function actionLogout(){
		$this->removeAuthToken();
		return $this->redirect( UrlService::buildWebUrl("/user/login") );
	}

}