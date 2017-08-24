<?php

namespace app\modules\m\controllers;

use app\common\services\ConstantMapService;
use app\common\services\DataHelper;
use app\common\services\QueueListService;
use app\common\services\UrlService;
use app\common\services\UtilService;
use app\models\book\Book;
use app\models\City;
use app\models\member\Member;
use app\models\member\MemberAddress;
use app\models\member\MemberComments;
use app\models\member\MemberFav;
use app\models\member\OauthMemberBind;
use app\models\pay\PayOrder;
use app\models\pay\PayOrderItem;
use app\models\sms\SmsCaptcha;
use app\modules\m\controllers\common\BaseController;
use app\common\services\AreaService;


class UserController extends BaseController {

    public function actionIndex(){
        return $this->render('index',[
        	'current_user' => $this->current_user
		]);
    }

	//账号绑定
	public function actionBind(){
		if( \Yii::$app->request->isGet ){
			return $this->render( "bind" );
		}

		$mobile = trim( $this->post("mobile") );
		$img_captcha = trim( $this->post("img_captcha") );
		$captcha_code = trim( $this->post("captcha_code") );
		$date_now = date("Y-m-d H:i:s");

		$openid = $this->getCookie( $this->auth_cookie_current_openid );

		if( mb_strlen($mobile,"utf-8") < 1 || !preg_match("/^[1-9]\d{10}$/",$mobile) ){
			return $this->renderJSON([],"请输入符合要求的手机号码~~",-1);
		}

		if (mb_strlen( $img_captcha, "utf-8") < 1) {
			return $this->renderJSON([], "请输入符合要求的图像校验码~~", -1);
		}

		if (mb_strlen( $captcha_code, "utf-8") < 1) {
			return $this->renderJSON([], "请输入符合要求的手机验证码~~", -1);
		}


		if ( !SmsCaptcha::checkCaptcha($mobile, $captcha_code ) ) {
			return $this->renderJSON([], "请输入正确的手机验证码~~", -1);
		}

		$member_info = Member::find()->where([ 'mobile' => $mobile,'status' => 1 ])->one();

		if( !$member_info ){
			if( Member::findOne([ 'mobile' => $mobile]) ){
				$this->renderJSON([], "手机号码已注册，请直接使用手机号码登录~~", -1);
			}

			$model_member = new Member();
			$model_member->nickname = $mobile;
			$model_member->mobile = $mobile;
			$model_member->setSalt();
			$model_member->avatar = ConstantMapService::$default_avatar;
			$model_member->reg_ip = sprintf("%u",ip2long( UtilService::getIP() ) );
			$model_member->status = 1;
			$model_member->created_time = $model_member->updated_time = date("Y-m-d H:i:s");
			$model_member->save( 0 );
			$member_info = $model_member;
		}

		if ( !$member_info || !$member_info['status']) {
			return $this->renderJSON([], "您的账号已被禁止，请联系客服解决~~", -1);
		}

		if( $openid ){
			$bind_info = OauthMemberBind::find()->where([ 'member_id' => $member_info['id'],'openid' => $openid,'type' => ConstantMapService::$client_type_wechat  ])->one();

			if( !$bind_info ){
				$model_bind = new OauthMemberBind();
				$model_bind->member_id = $member_info['id'];
				$model_bind->type = ConstantMapService::$client_type_wechat;
				$model_bind->client_type = "weixin";
				$model_bind->openid = $openid;
				$model_bind->unionid = '';
				$model_bind->extra = '';
				$model_bind->updated_time = $date_now;
				$model_bind->created_time = $date_now;
				$model_bind->save( 0 );
				//绑定之后要做的事情
				QueueListService::addQueue( "bind",[
					'member_id' => $member_info['id'],
					'type' => 1,
					'openid' => $model_bind->openid
				] );
			}
		}

		if( UtilService::isWechat() && $member_info['nickname']  == $member_info['mobile'] ){
			return $this->renderJSON([ 'url' => UrlService::buildMUrl( "/oauth/login",[ 'scope' => 'snsapi_userinfo' ] )  ],"绑定成功~~");
		}
		//todo设置登录态
		$this->setLoginStatus( $member_info );
		return $this->renderJSON([ 'url' => UrlService::buildMUrl( "/default/index" )  ],"绑定成功~~");
	}

	public function actionOrder(){
    	$pay_order_list = PayOrder::find()->where([ 'member_id' => $this->current_user['id'] ])
			->orderBy([ 'id' => SORT_DESC ])->asArray()->all();

    	$list = [];
    	if( $pay_order_list ) {
			$pay_order_items_list = PayOrderItem::find()->where(['member_id' => $this->current_user['id'], 'pay_order_id' => array_column($pay_order_list, 'id')])->asArray()->all();

			$book_mapping = Book::find()->where(['id' => array_column($pay_order_items_list, 'target_id')])->indexBy('id')->all();

			$pay_order_items_mapping = [];
			foreach ($pay_order_items_list as $_pay_order_item) {
				$tmp_book_info = $book_mapping[ $_pay_order_item['target_id'] ];
				if (!isset( $pay_order_items_mapping[ $_pay_order_item['pay_order_id'] ] ) ) {
					$pay_order_items_mapping[$_pay_order_item['pay_order_id']] = [];
				}
				$pay_order_items_mapping[$_pay_order_item['pay_order_id']][] = [
					'pay_price'       => $_pay_order_item['price'],
					'book_name'       => UtilService::encode($tmp_book_info['name']),
					'book_main_image' => UrlService::buildPicUrl("book", $tmp_book_info['main_image']),
					'book_id' => $_pay_order_item['target_id'],
					'comment_status' => $_pay_order_item['comment_status']
				];
			}

			foreach ($pay_order_list as $_pay_order_info) {
				$list[] = [
					'id' => $_pay_order_info['id'],
					'sn' => date("Ymd", strtotime($_pay_order_info['created_time'])) . $_pay_order_info['id'],
					'created_time' => date("Y-m-d H:i", strtotime($_pay_order_info['created_time'])),
					'pay_order_id' => $_pay_order_info['id'],
					'pay_price'    => $_pay_order_info['pay_price'],
					'items' => $pay_order_items_mapping[$_pay_order_info['id']],
					'status' => $_pay_order_info[ 'status' ],
					//'comment_status' => $_pay_order_info[ 'comment_status' ],
					'express_status' => $_pay_order_info[ 'express_status' ],
					'express_info' => $_pay_order_info[ 'express_info' ],
					'express_status_desc' => ConstantMapService::$express_status_mapping_for_member[ $_pay_order_info[ 'express_status' ] ],
					'status_desc' => ConstantMapService::$pay_status_mapping[ $_pay_order_info[ 'status' ] ],
					'pay_url' => UrlService::buildMUrl("/pay/buy/?pay_order_id={$_pay_order_info['id']}")
				];

			}
		}

		return $this->render('order',[
			'list' => $list
		]);
	}

	public function actionFav(){
		$list = MemberFav::find()->where([ 'member_id' => $this->current_user['id'] ])->orderBy([ 'id' => SORT_DESC ])->all();
		$data = [];
		if( $list ){
			$book_mapping = DataHelper::getDicByRelateID( $list ,Book::className(),"book_id","id",[ 'name','price','main_image','stock' ] );
			foreach( $list as $_item ){
				$tmp_book_info = $book_mapping[ $_item['book_id'] ];
				$data[] = [
					'id' => $_item['id'],
					'book_id' => $_item['book_id'],
					'book_price' => $tmp_book_info['price'],
					'book_name' => UtilService::encode( $tmp_book_info['name'] ),
					'book_main_image' => UrlService::buildPicUrl( "book",$tmp_book_info['main_image'] )
				];
			}
		}
		return $this->render("fav",[
			'list' => $data
		]);
	}

	public function actionAddress(){

		$list = MemberAddress::find()->where([ 'member_id' => $this->current_user['id'],'status' => 1 ])
			->orderBy([ 'is_default' => SORT_DESC,'id' => SORT_DESC ])->asArray()->all();
		$data = [];
		if( $list ){
			$area_mapping = DataHelper::getDicByRelateID( $list,City::className(),"area_id","id",[ 'province','city','area' ] );
			foreach( $list as $_item){
				$tmp_area_info = $area_mapping[ $_item['area_id'] ];
				$tmp_area = $tmp_area_info['province'].$tmp_area_info['city'];
				if( $_item['province_id'] != $_item['city_id'] ){
					$tmp_area .= $tmp_area_info['area'];
				}

				$data[] = [
					'id' => $_item['id'],
					'is_default' => $_item['is_default'],
					'nickname' => UtilService::encode( $_item['nickname'] ),
					'mobile' => UtilService::encode( $_item['mobile'] ),
					'address' => $tmp_area.UtilService::encode( $_item['address'] ),
				];
			}
		}
		return $this->render('address',[
			'list' => $data
		]);
	}

	public function actionAddress_set(){
		if( \Yii::$app->request->isGet ){
			$id = intval( $this->get("id",0) );
			$info = [];
			if( $id ){
				$info = MemberAddress::find()->where([ 'id' => $id,'member_id' => $this->current_user['id'] ])->one();
			}
			return $this->render('address_set',[
				"province_mapping" => AreaService::getProvinceMapping(),
				'info' => $info
			]);
		}

		$id = intval( $this->post("id",0) );
		$nickname = trim( $this->post("nickname","") );
		$mobile = trim( $this->post("mobile","") );
		$province_id = intval( $this->post("province_id",0) );
		$city_id = intval( $this->post("city_id",0) );
		$area_id = intval( $this->post("area_id",0) );
		$address = trim( $this->post("address","" ) );
		$date_now = date("Y-m-d H:i:s");

		if( mb_strlen( $nickname,"utf-8" ) < 1 ){
			return $this->renderJSON([],"请输入符合规范的收货人姓名~~",-1);
		}

		if( !preg_match("/^[1-9]\d{10}$/",$mobile) ){
			return $this->renderJSON([],"请输入符合规范的收货人手机号码~~",-1);
		}

		if( $province_id < 1 ){
			return $this->renderJSON([],"请选择省~~",-1);
		}

		if( $city_id < 1 ){
			return $this->renderJSON([],"请选择市~~",-1);
		}

		if( $area_id < 1 ){
			return $this->renderJSON([],"请选择区~~",-1);
		}

		if( mb_strlen( $address,"utf-8" ) < 3 ){
			return $this->renderJSON([],"请输入符合规范的收货人详细地址~~",-1);
		}

		$info = [];
		if( $id ){
			$info = MemberAddress::find()->where([ 'id' => $id,'member_id' => $this->current_user['id'] ])->one();
		}

		if( $info ){
			$model_address = $info;
		}else{
			$model_address = new MemberAddress();
			$model_address->member_id = $this->current_user['id'];
			$model_address->status = 1;
			$model_address->created_time = $date_now;
		}

		$model_address->nickname = $nickname;
		$model_address->mobile = $mobile;
		$model_address->province_id = $province_id;
		$model_address->city_id = $city_id;
		$model_address->area_id = $area_id;
		$model_address->address = $address;
		$model_address->updated_time = $date_now;
		$model_address->save( 0 );

		return $this->renderJSON([],"操作成功");
	}

	public function actionAddress_ops(){
		$act = trim( $this->post("act","") );
		$id = intval( $this->post("id",0) );

		if( !in_array( $act,[ "del","set_default" ] ) ){
			return $this->renderJSON( [],ConstantMapService::$default_syserror,-1 );
		}

		if( !$id ){
			return $this->renderJSON( [],ConstantMapService::$default_syserror,-1 );
		}

		$info = MemberAddress::find()->where([ 'member_id' => $this->current_user['id'],'id' => $id ])->one();
		switch ( $act ){
			case "del":
				$info->is_default = 0;
				$info->status = 0;
				break;
			case "set_default":
				$info->is_default = 1;
				break;
		}

		$info->updated_time = date("Y-m-d H:i:s");
		$info->update( 0 );

		if( $act == "set_default" ){
			MemberAddress::updateAll(
				[ 'is_default' => 0  ],
				[ 'AND',[ 'member_id' => $this->current_user['id'],'status' => 1 ] ,[ '!=','id',$id ] ]
			);
		}
		return $this->renderJSON( [],"操作成功~~" );
	}

	public function actionComment(){
		$list = MemberComments::find()->where([ 'member_id' => $this->current_user['id'] ])
			->orderBy([ 'id' => SORT_DESC ])->asArray()->all();

		return $this->render('comment',[
			'list' => $list
		]);
	}

	public function actionComment_set(){
		if( \Yii::$app->request->isGet ){
			$pay_order_id = intval( $this->get("pay_order_id",0) );
			$book_id = intval( $this->get("book_id",0) );
			$pay_order_info = PayOrder::findOne([ 'id' => $pay_order_id,'status' => 1,'express_status' => 1 ]);
			$reback_url = UrlService::buildMUrl("/user/index");
			if( !$pay_order_info ){
				return $this->redirect( $reback_url );
			}

			$pay_order_item_info  = PayOrderItem::findOne([ 'pay_order_id' => $pay_order_id,'target_id' => $book_id ]);
			if( !$pay_order_item_info ){
				return $this->renderJSON( [],ConstantMapService::$default_syserror,-1 );
			}

			if(  $pay_order_item_info['comment_status'] ){
				return $this->renderJS( "您已经评论过啦，不能重复评论~~",$reback_url );
			}


			return $this->render('comment_set',[
				'pay_order_info' => $pay_order_info,
				'book_id' => $book_id
			]);
		}

		$pay_order_id = intval( $this->post("pay_order_id",0) );
		$book_id = intval( $this->post("book_id",0) );
		$score = intval( $this->post("score",0) );
		$content = trim( $this->post('content','') );
		$date_now  = date("Y-m-d H:i:s");

		if( $score <= 0 ){
			return $this->renderJSON([],"请打分~~",-1);
		}

		if( mb_strlen( $content,"utf-8" ) < 3 ){
			return $this->renderJSON([],"请输入符合要求的评论内容~~",-1);
		}

		$pay_order_info = PayOrder::findOne([ 'id' => $pay_order_id,'status' => 1,'express_status' => 1 ]);
		if( !$pay_order_info ){
			return $this->renderJSON( [],ConstantMapService::$default_syserror,-1 );
		}

		$pay_order_item_info  = PayOrderItem::findOne([ 'pay_order_id' => $pay_order_id,'target_id' => $book_id ]);
		if( !$pay_order_item_info ){
			return $this->renderJSON( [],ConstantMapService::$default_syserror,-1 );
		}

		if(  $pay_order_item_info['comment_status'] ){
			return $this->renderJSON( [],"您已经评论过啦，不能重复评论~~",-1 );
		}

		$book_info = Book::findOne([ 'id' => $book_id ]);
		if( !$book_info ){
			return $this->renderJSON( [],ConstantMapService::$default_syserror,-1 );
		}

		$model_comment = new MemberComments();
		$model_comment->member_id = $this->current_user['id'];
		$model_comment->book_id = $book_id;
		$model_comment->pay_order_id = $pay_order_id;
		$model_comment->score = $score * 2;
		$model_comment->content = $content;
		$model_comment->created_time = $date_now;
		$model_comment->save( 0 );

		$pay_order_item_info->comment_status = 1;
		$pay_order_item_info->update( 0 );

		$book_info->comment_count += 1;
		$book_info->update( 0 );


		return $this->renderJSON([],"评论成功~~");
	}

}
