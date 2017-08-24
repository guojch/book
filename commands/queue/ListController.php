<?php

namespace app\commands\queue;


use app\commands\BaseController;
use app\common\services\UploadService;
use app\common\services\weixin\TemplateService;
use app\models\market\MarketQrcode;
use app\models\market\QrcodeScanHistory;
use app\models\member\Member;
use app\models\QueueList;


class ListController extends  BaseController {
	/**
	 * php yii queue/list/run
	 */
	public function actionRun( ){
		$list = QueueList::find()->where([ 'status' => -1  ])->orderBy([ 'id' =>SORT_ASC ])->limit( 10 )->all();
		if( !$list ){
			return $this->echoLog( 'no data to handle ~~' );
		}

		foreach( $list as $_item ){
			$this->echoLog("queue_id:{$_item['id']}");

			switch ( $_item['queue_name'] ){
				case "member_avatar":
					$this->handleMemberAvatar( $_item );
					break;
				case  "bind":
					$this->handleBind( $_item );
					break;
				case  "pay":
					$this->handlePay( $_item );
					break;
				case "express":
					$this->handleExpress( $_item );
					break;
			}

			$_item->status = 1;
			$_item->updated_time = date("Y-m-d H:i:s");
			$_item->update( 0 );
		}

		return $this->echoLog("it's over ~~");
	}

	private function handleMemberAvatar( $item ){
		$data = @json_decode( $item['data'],true );

		if( !isset( $data['member_id'] ) || !isset( $data['avatar_url']) ){
			return false;
		}


		if( !$data['member_id'] || !$data['avatar_url'] ){
			return false;
		}

		$member_info = Member::findOne([ 'id' => $data['member_id'] ]);
		if( !$member_info ){
			return false;
		}

		$ret = UploadService::uploadByUrl( $data['avatar_url'],"avatar" );
		if( $ret ){
			$member_info->avatar = $ret['path'];
			$member_info->update( 0 );
		}
		return true;
	}

	/**
	 * 绑定微信相关通知
	 */
	private function handleBind( $item ){
		$data = @json_decode( $item['data'],true );

		if( !isset( $data['member_id'] ) || !isset( $data['openid']) ){
			return false;
		}


		if( !$data['member_id'] || !$data['openid'] ){
			return false;
		}


		$member_info = Member::findOne([ 'id' => $data['member_id'] ]);
		if( !$member_info ){
			return false;
		}

		$scan_info = QrcodeScanHistory::find()->where([ 'openid' => $data['openid'] ])->one();
		if( !$scan_info ){
			return false;
		}

		$qrcode_info = MarketQrcode::find()->where([ 'id' => $scan_info['qrcode_id'] ])->one();
		if( !$qrcode_info ){
			return false;
		}

		$qrcode_info->total_reg_count += 1;
		$qrcode_info->update( 0 );

		TemplateService::bindNotice( $data['member_id'] );
		return true;
	}

	/**
	 * 支付完成相关通知
	 */
	private function handlePay( $item ){
		$data = @json_decode( $item['data'],true );
		if( !isset( $data['member_id'] ) || !isset( $data['pay_order_id']) ){
			return false;
		}


		if( !$data['member_id'] || !$data['pay_order_id'] ){
			return false;
		}

		TemplateService::payNotice( $data['pay_order_id'] );
		return true;
	}

	/**
	 * 确认发货通知
	 */
	private function handleExpress( $item ){
		$data = @json_decode( $item['data'],true );
		if( !isset( $data['member_id'] ) || !isset( $data['pay_order_id']) ){
			return false;
		}


		if( !$data['member_id'] || !$data['pay_order_id'] ){
			return false;
		}

		$ret = TemplateService::expressNotice( $data['pay_order_id'] );
		if( !$ret ){
			$this->echoLog( TemplateService::getLastErrorMsg() );
		}
		return $ret;
	}
}