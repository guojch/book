<?php

namespace app\modules\m\controllers\common;
use app\common\components\BaseWebController;
use app\common\services\UrlService;
use app\common\services\UtilService;
use app\models\member\Member;

class BaseController extends BaseWebController {

	protected $auth_cookie_current_openid = "shop_m_openid";
	protected  $auth_cookie_name = "mooc_book_member";
	protected  $salt = "dm3HsNYz3Uyddd46Rjg";
	protected $current_user = null;

	/*这部分永远不用登录*/
	protected $allowAllAction = [
		'm/oauth/login',
		'm/oauth/logout',
		'm/oauth/callback',
		'm/user/bind',
		'm/pay/callback',
		'm/product/ops',
		'm/product/search',
	];

	/**
	 * 以下特殊url
	 * 如果在微信中,可以不用登录(但是必须要有openid)
	 * 如果在H5浏览器,可以不用登录
	 */
	public $special_AllowAction = [
		'm/default/index',
		'm/product/index',
		'm/product/info'
	];

	public function __construct($id, $module, $config = []){
		parent::__construct($id, $module, $config = []);
		$this->layout = "main";

		\Yii::$app->view->params['share_info'] = json_encode( [
			'title' => \Yii::$app->params['title'],
			'desc' => \Yii::$app->params['title'],
			'img_url' => UrlService::buildWwwUrl("/images/common/guojch.jpg"),
		] );
	}

	public function beforeAction( $action ){
		$login_status = $this->checkLoginStatus();
		$this->setMenu();

		if ( in_array($action->getUniqueId(), $this->allowAllAction ) ) {
			return true;
		}

		if( !$login_status ){
			if( \Yii::$app->request->isAjax ){
				$this->renderJSON([],"未登录,系统将引导您重新登录~~",-302);
			}else{
				$redirect_url = UrlService::buildMUrl( "/user/bind" );
				if( UtilService::isWechat() ){
					$openid = $this->getCookie( $this->auth_cookie_current_openid );
					if( $openid ){
						if( in_array( $action->getUniqueId() ,$this->special_AllowAction ) ){
							return true;
						}
					}else{
						$redirect_url = UrlService::buildMUrl( "/oauth/login" );
					}
				}else{
					if( in_array( $action->getUniqueId() ,$this->special_AllowAction ) ){
						return true;
					}
				}
				$this->redirect( $redirect_url );
			}
			return false;
		}
		return true;
	}

	protected function checkLoginStatus(){

		$auth_cookie = $this->getCookie( $this->auth_cookie_name );

		if( !$auth_cookie ){
			return false;
		}
		list($auth_token,$member_id) = explode("#",$auth_cookie);
		if( !$auth_token || !$member_id ){
			return false;
		}
		if( $member_id && preg_match("/^\d+$/",$member_id) ){
			$member_info = Member::findOne([ 'id' => $member_id,'status' => 1 ]);
			if( !$member_info ){
				$this->removeAuthToken();
				return false;
			}
			if( $auth_token != $this->geneAuthToken( $member_info ) ){
				$this->removeAuthToken();
				return false;
			}
			$this->current_user = $member_info;
			\Yii::$app->view->params['current_user'] = $member_info;
			return true;
		}
		return false;
	}

	public function setLoginStatus( $user_info ){
		$auth_token = $this->geneAuthToken( $user_info );
		$this->setCookie($this->auth_cookie_name,$auth_token."#".$user_info['id']);
	}

	protected  function removeLoginStatus(){
		$this->removeCookie($this->auth_cookie_name);
	}

	public function geneAuthToken( $member_info ){
		return md5( $this->salt."-{$member_info['id']}-{$member_info['mobile']}-{$member_info['salt']}");
	}

	protected function setMenu(){

		$menu_hide = false;
		$url = \Yii::$app->request->getPathInfo();
		if( stripos($url,"product/info") !== false ){
			$menu_hide = true;
		}

		\Yii::$app->view->params['menu_hide'] = $menu_hide;
	}

	public function goHome(){
		return $this->redirect( UrlService::buildMUrl( "/default/index" ) );
	}


}