<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/2
 * Time: 18:16
 */

namespace app\modules\web\controllers\common;

use app\common\components\BaseWebController;
use app\common\services\applog\AppLogService;
use app\common\services\UrlService;
use app\models\User;

class BaseController extends BaseWebController {

    protected $auth_token_name = 'guojch_book';
    public $current_user = null;//当前登录人信息

    public $allowAllAction = [
        'web/user/login'
    ];

    public function __construct($id, $module, $config = array()) {
        parent::__construct($id, $module, $config);
        $this->layout = 'main';
    }

    /*
     * 登录统一验证
     */
    public function beforeAction($action){
        //如果在允许的action中，那就不要验证了
        if(in_array($action->getUniqueId(),$this->allowAllAction)){
            return true;
        }

        //验证是否登录
        $is_login = $this->checkLoginStatus();
        if(!$is_login){
            if(\Yii::$app->request->isAjax){
                $this->renderJson([],'未登录，请先登录。',-302);
            }else{
                $this->redirect(UrlService::buildWebUrl('/user/login'));
            }
            return false;
        }

        // 记录用户访问日志
        AppLogService::addAppAccessLog($this->current_user['id']);

        return true;
    }

    /*
     * 验证是否当前登录状态有效 true or false
     */
    public function checkLoginStatus(){
        // 获取登录cookie
        $auth_cookie = $this->getCookie($this->auth_token_name,'');
        if(!$auth_cookie){
            return false;
        }
        // 分解cookie
        list($auth_token,$id) = explode('#',$auth_cookie);
        if(!$auth_token || !$id){
            return false;
        }
        // 验证id是否为整数
        if(!preg_match("/^\d+$/",$id)){
            return false;
        }
        // 验证用户信息是否存在
        $user_info = User::find()->where(['id'=>$id])->one();
        if(!$user_info){
            return false;
        }
        // 验证当前cookie是否正确
        if($auth_token != $this->setAuthToken($user_info)){
            return false;
        }

        $this->current_user = $user_info;

        return true;
    }

    /*
     * 设置登录状态方法
     */
    public function setLoginStatus($user_info){
        $auth_token = $this->setAuthToken($user_info);
        $this->setCookie($this->auth_token_name,$auth_token.'#'.$user_info['id']);
    }

    /*
     * 删除登录状态
     */
    public function removeLoginStatus(){
        $this->removeCookie($this->auth_token_name);
    }

    /*
     * 统一生成加密字段
     * 加密字符串 = md5(login_name + login_pwd + login_salt)
     */
    public function setAuthToken($user_info){
        return md5($user_info['login_name'].$user_info['login_pwd'].$user_info['login_salt']);
    }
}