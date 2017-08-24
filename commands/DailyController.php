<?php

namespace app\commands;

use app\models\book\Book;
use app\models\book\BookSaleChangeLog;
use app\models\member\Member;
use app\models\pay\PayOrder;
use app\models\stat\StatDailyBook;
use app\models\stat\StatDailyMember;
use app\models\stat\StatDailyShare;
use app\models\stat\StatDailySite;
use app\models\WxShareHistory;
use Yii;

class DailyController extends BaseController {

	/*
	 * 全站日统计
	 * php yii daily/site
	 * */
	public function actionSite( $date = 'now' ){
		$date = date('Y-m-d', strtotime($date) );
		$date_now = date("Y-m-d H:i:s");
		$time_start = $date.' 00:00:00';
		$time_end = $date.' 23:59:59';
		$this->echoLog( "ID_ACTION:".__CLASS__."_".__FUNCTION__.",date:{$date} " );

		$stat_pay_info = PayOrder::find()->select([ 'SUM(pay_price) as total_pay_money' ])
			->where([ 'status' => 1 ])
			->andWhere([ 'between','created_time',$time_start,$time_end ])
			->asArray()->one();


		$total_member_count = Member::find()->where([ '<=','created_time',$time_end ])->count();
		$total_new_member_count = Member::find()->where([ 'between','created_time',$time_start,$time_end ])->count();
		$total_order_count = PayOrder::find()->where([ 'status' => 1 ])->andWhere([  'between','created_time',$time_start,$time_end ])->count();
		$total_shared_count = WxShareHistory::find()->where( [ 'between','created_time',$time_start,$time_end  ] )->count();

		$stat_site_info = StatDailySite::findOne([ 'date' => $date ]);
		if( $stat_site_info ){
			$model_stat_site = $stat_site_info;
		}else{
			$model_stat_site = new StatDailySite();
			$model_stat_site->date = $date;
			$model_stat_site->created_time = $date_now;
		}

		$model_stat_site->total_pay_money = ( $stat_pay_info && $stat_pay_info['total_pay_money'] )?$stat_pay_info['total_pay_money']:0;
		$model_stat_site->total_member_count = $total_member_count?$total_member_count:0;
		$model_stat_site->total_new_member_count = $total_new_member_count?$total_new_member_count:0;
		$model_stat_site->total_order_count = $total_order_count?$total_order_count:0;
		$model_stat_site->total_shared_count = $total_shared_count?$total_shared_count:0;

		//伪造数据
		$model_stat_site->total_pay_money = mt_rand(1000,1010);
		$model_stat_site->total_new_member_count = mt_rand(50,100);
		$model_stat_site->total_member_count = $model_stat_site->total_member_count + $model_stat_site->total_new_member_count;
		$model_stat_site->total_order_count = mt_rand(900,1000);
		$model_stat_site->total_shared_count = mt_rand(1000,2000);

		$model_stat_site->updated_time = $date_now;
		$model_stat_site->save( 0 );
		$this->echoLog( "it's over ~~" );
	}


	/**
	 * 书籍售卖统计
	 * php yii daily/book
	 */
	public function actionBook( $date = 'now' ){
		$date = date('Y-m-d', strtotime($date) );
		$date_now = date("Y-m-d H:i:s");
		$time_start = $date.' 00:00:00';
		$time_end = $date.' 23:59:59';
		$this->echoLog( "ID_ACTION:".__CLASS__."_".__FUNCTION__.",date:{$date} " );

		$stat_book_list = BookSaleChangeLog::find()->select( [ 'book_id','SUM(quantity) AS total_count','SUM(price) AS total_pay_money' ] )
			->andWhere([  'between','created_time',$time_start,$time_end ])
			->groupBy("book_id")->asArray()->all();
		if( !$stat_book_list ){
			return $this->echoLog("no data");
		}

		foreach( $stat_book_list as $_item ){
			$tmp_stat_book_info = StatDailyBook::findOne([ 'date' => $date,'book_id' => $_item['book_id'] ]);
			if( $tmp_stat_book_info ){
				$tmp_model_stat_book = $tmp_stat_book_info;
			}else{
				$tmp_model_stat_book = new StatDailyBook();
				$tmp_model_stat_book->date = $date;
				$tmp_model_stat_book->book_id = $_item['book_id'];
				$tmp_model_stat_book->created_time = $date_now;
			}

			$tmp_model_stat_book->total_count = $_item['total_count']?$_item['total_count']:0;
			$tmp_model_stat_book->total_pay_money = $_item['total_pay_money']?$_item['total_pay_money']:0;

			//伪造数据
			$tmp_model_stat_book->total_count = mt_rand(1000,1010);
			$tmp_model_stat_book->total_pay_money = mt_rand(50,100);

			$tmp_model_stat_book->updated_time = $date_now;
			$tmp_model_stat_book->save( 0 );
		}
		return $this->echoLog( "it's over ~~" );
	}

	/**
	 * 会员统计
	 * php yii daily/member
	 */
	public function actionMember( $date = 'now' ){
		$date = date('Y-m-d', strtotime($date) );
		$date_now = date("Y-m-d H:i:s");
		$time_start = $date.' 00:00:00';
		$time_end = $date.' 23:59:59';
		$this->echoLog( "ID_ACTION:".__CLASS__."_".__FUNCTION__.",date:{$date} " );

		$member_list = Member::find()->asArray()->all();
		if( !$member_list ){
			return $this->echoLog("no member list");
		}

		foreach( $member_list as $_member_info ){

			$tmp_stat_member = StatDailyMember::findOne([ 'date' => $date,'member_id' => $_member_info['id'] ]);
			if( $tmp_stat_member ){
				$tmp_model_stat_member = $tmp_stat_member;
			}else{
				$tmp_model_stat_member = new StatDailyMember();
				$tmp_model_stat_member->date = $date;
				$tmp_model_stat_member->member_id = $_member_info['id'];
				$tmp_model_stat_member->created_time = $date_now;
			}

			$tmp_pay = PayOrder::find()
				->where([ 'status' => 1,'member_id' => $_member_info['id'] ])
				->andWhere([ 'between','created_time',$time_start,$time_end ])
				->asArray()->sum( 'pay_price' );
			$tmp_total_shared_count = WxShareHistory::find()
				->where([ 'member_id' => $_member_info['id'] ])
				->andWhere( [ 'between','created_time',$time_start,$time_end  ] )->count();

			$tmp_model_stat_member->total_pay_money = $tmp_pay?$tmp_pay:0;
			$tmp_model_stat_member->total_shared_count = $tmp_total_shared_count?$tmp_total_shared_count:0;

			//伪造数据
			$tmp_model_stat_member->total_pay_money = mt_rand(1000,1010);
			$tmp_model_stat_member->total_shared_count = mt_rand(50,100);

			$tmp_model_stat_member->updated_time = $date_now;
			$tmp_model_stat_member->save( 0 );
		}
		return $this->echoLog( "it's over ~~" );
	}


	public function actionTest(){
		//$date_from = '2017-01-01';
		$date_from = date("Y-m-d");
		$date_to = date("Y-m-d");
		for( $i = $date_from; $i <= $date_to; $i = date("Y-m-d",strtotime( "+1 days",strtotime( $i ) ) ) ){
			$this->actionSite( $i );
			$this->geneSale( $i );
			$this->actionBook( $i );
			$this->actionMember( $i );
		}
	}


	private function geneSale( $date = '' ){
		$book_list = Book::find()->all();
		foreach( $book_list as $_book_info  ){
			$model = new BookSaleChangeLog();
			$model->book_id = $_book_info['id'];
			$model->quantity = mt_rand(1,10);
			$model->price = $model->quantity * $_book_info['price'];
			$model->member_id = 1;
			$model->created_time = $date." ".date("H:i:s");
			$model->save( 0 );
		}

	}
}
