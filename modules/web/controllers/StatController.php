<?php

namespace app\modules\web\controllers;

use app\common\services\DataHelper;
use app\common\services\UrlService;
use app\common\services\UtilService;
use app\models\book\Book;
use app\models\member\Member;
use app\models\stat\StatDailyBook;
use app\models\stat\StatDailyMember;
use app\models\stat\StatDailySite;
use app\modules\web\controllers\common\BaseController;

class StatController extends BaseController{

    public function actionIndex(){
		$date_from = $this->get("date_from",date("Y-m-d",strtotime("-30 days") ) );
		$date_to = $this->get("date_to",date("Y-m-d" ) );
		$p = intval( $this->get("p",1) );
		$p = ( $p > 0 )?$p:1;


		$query = StatDailySite::find();
		$query->where([ '>=','date',$date_from ]);
		$query->andWhere([ '<=','date',$date_to ]);

		//分页功能,需要两个参数，1：符合条件的总记录数量  2：每页展示的数量
		//60,60 ~ 11,10 - 1
		$total_res_count = $query->count();
		$total_page = ceil( $total_res_count / $this->page_size );


		$list = $query->orderBy([ 'id' => SORT_DESC ])
			->offset( ( $p - 1 ) * $this->page_size )
			->limit($this->page_size)
			->all( );

        return $this->render("index",[
			'list' => $list,
			'search_conditions' => [
				'date_from' => $date_from,
				'date_to' => $date_to,
				'p' => $p,
			],
			'pages' => [
				'total_count' => $total_res_count,
				'page_size' => $this->page_size,
				'total_page' => $total_page,
				'p' => $p
			]
		]);
    }

    public function actionProduct(){
		$date_from = $this->get("date_from",date("Y-m-d",strtotime("-30 days") ) );
		$date_to = $this->get("date_to",date("Y-m-d" ) );
		$p = intval( $this->get("p",1) );
		$p = ( $p > 0 )?$p:1;


		$query = StatDailyBook::find();
		$query->where([ '>=','date',$date_from ]);
		$query->andWhere([ '<=','date',$date_to ]);

		//分页功能,需要两个参数，1：符合条件的总记录数量  2：每页展示的数量
		//60,60 ~ 11,10 - 1
		$total_res_count = $query->count();
		$total_page = ceil( $total_res_count / $this->page_size );


		$list = $query->orderBy([ 'id' => SORT_DESC ])
			->offset(  ( $p - 1 ) * $this->page_size  )
			->limit($this->page_size)
			->all( );
		$data = [];
		if( $list ){
			$book_mapping = DataHelper::getDicByRelateID( $list,Book::className(),"book_id","id",[ "name" ] );
			foreach( $list as $_item ){
				$tmp_book_info = isset( $book_mapping[ $_item['book_id'] ] )?$book_mapping[ $_item['book_id'] ]:[];
				$data[] = [
					'date' => $_item['date'],
					'book_id' => $_item['book_id'],
					'total_count' => $_item['total_count'],
					'total_pay_money' => $_item['total_pay_money'],
					'book_info' => $tmp_book_info
				];
			}
		}

		return $this->render("product",[
			'list' => $data,
			'search_conditions' => [
				'date_from' => $date_from,
				'date_to' => $date_to,
				'p' => $p,
			],
			'pages' => [
				'total_count' => $total_res_count,
				'page_size' => $this->page_size,
				'total_page' => $total_page,
				'p' => $p
			]
		]);
	}

	public function actionMember(){
		$date_from = $this->get("date_from",date("Y-m-d",strtotime("-30 days") ) );
		$date_to = $this->get("date_to",date("Y-m-d" ) );
		$p = intval( $this->get("p",1) );
		$p = ( $p > 0 )?$p:1;


		$query = StatDailyMember::find();
		$query->where([ '>=','date',$date_from ]);
		$query->andWhere([ '<=','date',$date_to ]);

		//分页功能,需要两个参数，1：符合条件的总记录数量  2：每页展示的数量
		//60,60 ~ 11,10 - 1
		$total_res_count = $query->count();
		$total_page = ceil( $total_res_count / $this->page_size );

		$list = $query->orderBy([ 'id' => SORT_DESC ])
			->offset(  ( $p - 1 ) * $this->page_size  )
			->limit($this->page_size)
			->all( );
		$data = [];
		if( $list ){
			$member_mapping = DataHelper::getDicByRelateID( $list,Member::className(),"member_id","id",[ "nickname","mobile" ] );
			foreach( $list as $_item ){
				$tmp_member_info = isset( $member_mapping[ $_item['member_id'] ] )?$member_mapping[ $_item['member_id'] ]:[];
				$data[] = [
					'date' => $_item['date'],
					'total_pay_money' => $_item['total_pay_money'],
					'total_shared_count' => $_item['total_shared_count'],
					'member_info' => $tmp_member_info
				];
			}
		}

		return $this->render("member",[
			'list' => $data,
			'search_conditions' => [
				'date_from' => $date_from,
				'date_to' => $date_to,
				'p' => $p,
			],
			'pages' => [
				'total_count' => $total_res_count,
				'page_size' => $this->page_size,
				'total_page' => $total_page,
				'p' => $p
			]
		]);
	}

	public function actionShare(){
		$date_from = $this->get("date_from",date("Y-m-d",strtotime("-30 days") ) );
		$date_to = $this->get("date_to",date("Y-m-d" ) );
		$p = intval( $this->get("p",1) );
		$p = ( $p > 0 )?$p:1;


		$query = StatDailySite::find();
		$query->where([ '>=','date',$date_from ]);
		$query->andWhere([ '<=','date',$date_to ]);

		//分页功能,需要两个参数，1：符合条件的总记录数量  2：每页展示的数量
		//60,60 ~ 11,10 - 1
		$total_res_count = $query->count();
		$total_page = ceil( $total_res_count / $this->page_size );


		$list = $query->orderBy([ 'id' => SORT_DESC ])
			->offset(  ( $p - 1 ) * $this->page_size  )
			->limit($this->page_size)
			->all( );

		return $this->render("share",[
			'list' => $list,
			'search_conditions' => [
				'date_from' => $date_from,
				'date_to' => $date_to,
				'p' => $p,
			],
			'pages' => [
				'total_count' => $total_res_count,
				'page_size' => $this->page_size,
				'total_page' => $total_page,
				'p' => $p
			]
		]);
	}

}
