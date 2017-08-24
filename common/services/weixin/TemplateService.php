<?php

namespace app\common\services\weixin;

use app\common\services\BaseService;
use app\common\services\DataHelper;
use app\common\services\UrlService;
use app\models\book\Book;
use app\models\member\Member;
use app\models\member\OauthMemberBind;
use \app\models\pay\PayOrder;
use app\models\pay\PayOrderItem;
use Yii;


class TemplateService extends  BaseService
{
    /**
     * 支付完成提醒
     */
    public static function payNotice( $pay_order_id ){

        $pay_order_info =PayOrder::findOne( $pay_order_id );

        if( !$pay_order_info ){
            return false;
        }

		$config = \Yii::$app->params['weixin'];
		RequestService::setConfig( $config['appid'],$config['token'],$config['sk'] );

        $open_id = self::getOpenId( $pay_order_info['member_id'] );
        if(!$open_id){
            return false;
        }

		$template_id = "7vn0ChP_xFm2uq72_Dtsk33kjWiQQzJed65UDq8oKkQ";
        $pay_money = $pay_order_info["pay_price"];

        $data = [
            "first" => [
                "value" => "您的订单已支付成功",
                "color" => "#173177"
            ],
			"keyword1" =>[
				"value" => date("Ymd",strtotime( $pay_order_info['created_time'] ) ).$pay_order_info['id'],
				"color" => "#173177"
			],
            "keyword2" =>[
                "value" => date("Y-m-d H:i",strtotime( $pay_order_info['pay_time'] ) ),
                "color" => "#173177"
            ],
            "keyword3" =>[
                "value" => $pay_money,
                "color" => "#173177"
            ],
            "remark" => [
                "value" => "点击查看详情",
                "color" => "#173177"
            ]
        ];

        return self::send($open_id,$template_id,UrlService::buildMUrl( "/user/order" ),$data);
    }

	/**
	 * 发货通知提醒
	 */
	public static function expressNotice( $pay_order_id ){

		$pay_order_info = PayOrder::findOne( $pay_order_id );
		if( !$pay_order_info ){
			return self::_err( "订单不存在~~" );
		}

		$pay_order_items = PayOrderItem::find()->where([ 'pay_order_id' => $pay_order_id ])->all();
		if( !$pay_order_items ){
			return self::_err( "订单不存在~~" );
		}

		$config = \Yii::$app->params['weixin'];
		RequestService::setConfig( $config['appid'],$config['token'],$config['sk'] );

		$open_id = self::getOpenId( $pay_order_info['member_id'] );
		if( !$open_id ){
			return self::_err( "openid 没找到~~" );
		}

		$template_id = "cmFsbU-Bqwm-EVvfLgj2QfQGewp0uAelqgM9HFMa9DE";
		$pay_money = $pay_order_info["pay_price"];

		$book_items = [];
		$book_mapping = DataHelper::getDicByRelateID( $pay_order_items,Book::className(),"target_id","id",[ 'name' ] );
		foreach( $pay_order_items as $_pay_order_item_info ){
			if( !isset( $book_mapping[ $_pay_order_item_info['target_id'] ]) ){
				continue;
			}
			$book_items[] = $book_mapping[ $_pay_order_item_info['target_id'] ]['name'];
		}

		$data = [
			"first" => [
				"value" => "您的订单已经标记发货，请留意查收",
				"color" => "#173177"
			],
			"orderProductPrice" =>[
				"value" => $pay_money,
				"color" => "#173177"
			],
			"orderProductName" =>[
				"value" => implode(",",$book_items),
				"color" => "#173177"
			],
			"orderName" =>[
				"value" => date("Ymd",strtotime( $pay_order_info['created_time'] ) ).$pay_order_info['id'],
				"color" => "#173177"
			],
			"remark" => [
				"value" => "快递信息：".$pay_order_info['express_info'],
				"color" => "#173177"
			]
		];

		return self::send($open_id,$template_id,UrlService::buildMUrl( "/user/order" ),$data);
	}

	/**
	 * 微信绑定通知提醒
	 */
	public static function bindNotice( $member_id ){

		$member_info  = Member::findOne( [ 'id' => $member_id ] );
		if( !$member_info ){
			return false;
		}

		$config = \Yii::$app->params['weixin'];
		RequestService::setConfig( $config['appid'],$config['token'],$config['sk'] );

		$open_id = self::getOpenId( $member_id );
		if(!$open_id){
			return false;
		}

		$template_id = "ywuQ7CgzvDURT4vOLZ8NYVNR4i1Ow5b7nWpKmUFfVQI";

		$data = [
			"first" => [
				"value" => "您好，您已注册并成功绑定微信",
				"color" => "#173177"
			],
			"keyword1" =>[
				"value" => $member_info['mobile'],
				"color" => "#173177"
			],
			"keyword2" =>[
				"value" => date("Y-m-d H:i",strtotime( $member_info['created_time'] ) ),
				"color" => "#173177"
			],
			"remark" => [
				"value" => "感谢您支持".Yii::$app->params['title'],
				"color" => "#173177"
			]
		];

		return self::send($open_id,$template_id,UrlService::buildMUrl( "/user/index" ),$data);
	}


    /**
     * 获取微信公众平台的微信公众号id
     */
    protected static function getOpenId( $member_id ){
        $open_infos = OauthMemberBind::findAll([ 'member_id' => $member_id,'type' => 1 ]);

        if( !$open_infos ){
            return false;
        }

        foreach($open_infos as $open_info){
            if( self::getPublicByOpenId($open_info['openid']) ) {
                return $open_info['openid'];
            }
        }
        return false;
    }

    public  static function send($openid,$template_id,$url,$data){
        $msg = [
            "touser" => $openid,
            "template_id" => $template_id,
            "url" => $url,
            "data" => $data
        ];

        $token = RequestService::getAccessToken();
        return RequestService::send("message/template/send?access_token=".$token,json_encode( $msg ),'POST');
    }


    protected static function getPublicByOpenId($openid){
        $token = RequestService::getAccessToken();
		$info = RequestService::send("user/info?access_token={$token}&openid={$openid}&lang=zh_CN","GET");
        if(!$info || isset($info['errcode']) ){
            return false;
        }

        if($info['subscribe']){
            return true;
        }
        return false;
    }
}

