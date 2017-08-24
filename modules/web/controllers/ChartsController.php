<?php

namespace app\modules\web\controllers;

use app\common\services\UrlService;
use app\models\stat\StatDailySite;
use app\modules\web\controllers\common\BaseController;

class ChartsController extends BaseController{

	public function actionDashboard(){
		$date_from = $this->get("date_from",date("Y-m-d",strtotime("-30 days") ) );
		$date_to = $this->get("date_to",date("Y-m-d" ) );

		$query = StatDailySite::find();
		$query->where([ '>=','date',$date_from ]);
		$query->andWhere([ '<=','date',$date_to ]);
		$list = $query->orderBy([ 'id' => SORT_ASC ])->all( );
		$data = [
			'categories' => [],
			'series' => [
				[
					'name' => '会员总数',
					'data' => []
				],
				[
					'name' => '订单总数',
					'data' => []
				]
			]
		];
		if( $list ){
			foreach(  $list as $_item ){
				$data['categories'][] = $_item['date'];
				$data['series'][0]['data'][] = floatval( $_item['total_member_count'] );
				$data['series'][1]['data'][] = floatval( $_item['total_order_count'] );
			}
		}
		return $this->renderJSON( $data );
	}

    public function actionFinance(){
		$date_from = $this->get("date_from",date("Y-m-d",strtotime("-30 days") ) );
		$date_to = $this->get("date_to",date("Y-m-d" ) );

		$query = StatDailySite::find();
		$query->where([ '>=','date',$date_from ]);
		$query->andWhere([ '<=','date',$date_to ]);
		$list = $query->orderBy([ 'id' => SORT_ASC ])->all( );
		$data = [
			'categories' => [],
			'series' => [
				[
					'name' => '日营收报表',
					'data' => []
				]
			]
		];
		if( $list ){
			foreach(  $list as $_item ){
				$data['categories'][] = $_item['date'];
				$data['series'][0]['data'][] = floatval( $_item['total_pay_money'] );
			}
		}
        return $this->renderJSON( $data );
    }

	public function actionShare(){
		$date_from = $this->get("date_from",date("Y-m-d",strtotime("-30 days") ) );
		$date_to = $this->get("date_to",date("Y-m-d" ) );

		$query = StatDailySite::find();
		$query->where([ '>=','date',$date_from ]);
		$query->andWhere([ '<=','date',$date_to ]);
		$list = $query->orderBy([ 'id' => SORT_ASC ])->all( );
		$data = [
			'categories' => [],
			'series' => [
				[
					'name' => '日分享',
					'data' => []
				]
			]
		];
		if( $list ){
			foreach(  $list as $_item ){
				$data['categories'][] = $_item['date'];
				$data['series'][0]['data'][] = $_item['total_shared_count'];
			}
		}
		return $this->renderJSON( $data );
	}

}
