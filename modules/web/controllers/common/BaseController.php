<?php

namespace app\modules\web\controllers\common;
use app\common\components\BaseWebController;
use app\common\services\UrlService;
use app\models\User;
use app\common\services\applog\ApplogService;
class BaseController extends BaseWebController {
	protected $page_size = 50;
	protected  $auth_cookie_name = "mooc_book";
	protected $current_user = null;

	public $allowAllAction = [
		'web/user/login',
		'web/user/logout'
	];

	public function __construct($id, $module, $config = []){
		parent::__construct($id, $module, $config = []);
		$this->layout = "main";
	}

	public function beforeAction( $action ){
		$is_login = $this->checkLoginStatus();

		if ( in_array($action->getUniqueId(), $this->allowAllAction ) ) {
			return true;
		}

		if(!$is_login) {
			if ( \Yii::$app->request->isAjax) {
				$this->renderJSON([], "未登录,请返回用户中心", -302);
			} else {
				$this->redirect( UrlService::buildWebUrl("/user/login") );
			}
			return false;
		}

		ApplogService::addAppLog( $this->current_user['uid'] );
		return true;
	}

	/**
	 * 目的：验证是否当前登录态有效 true or  false
	 */

	protected function checkLoginStatus(){

		$auth_cookie = $this->getCookie( $this->auth_cookie_name );

		if( !$auth_cookie ){
			return false;
		}
		list($auth_token,$uid) = explode("#",$auth_cookie);
		if( !$auth_token || !$uid ){
			return false;
		}
		if( $uid && preg_match("/^\d+$/",$uid) ){
			$user_info = User::findOne([ 'uid' => $uid,'status' => 1 ]);
			if( !$user_info ){
				$this->removeAuthToken();
				return false;
			}
			if( $auth_token != $this->geneAuthToken( $user_info ) ){
				$this->removeAuthToken();
				return false;
			}
			$this->current_user = $user_info;
			\Yii::$app->view->params['current_user'] = $user_info;
			return true;
		}
		return false;
	}

	public function setLoginStatus( $user_info ){
		$auth_token = $this->geneAuthToken( $user_info );
		$this->setCookie($this->auth_cookie_name,$auth_token."#".$user_info['uid']);
	}

	protected  function removeAuthToken(){
		$this->removeCookie($this->auth_cookie_name);
	}

	//统一生成加密字段 ,加密字符串 = md5( login_name + login_pwd + login_salt )
	public function geneAuthToken( $user_info ){
		return md5( "{$user_info['login_name']}-{$user_info['login_pwd']}-{$user_info['login_salt']}");
	}

	public function getUid(){
		return $this->current_user?$this->current_user['uid']:0;
	}

}