<?php

namespace app\modules\web\controllers;

use app\models\stat\StatDailySite;
use app\modules\web\controllers\common\BaseController;

class DashboardController extends BaseController{

    public function actionIndex(){
		$data = [
			'finance' => [
				'today' => 0,
				'month' => 0
			],
			'member' => [
				'today_new' => 0,
				'month_new' => 0,
				'total' => 0
			],
			'order' => [
				'today' => 0,
				'month' => 0
			],
			'shared' => [
				'today' => 0,
				'month' => 0
			]
		];

		$date_from = date("Y-m-d",strtotime("-30 days" ) );
		$date_to = date("Y-m-d" );

		$query = StatDailySite::find();
		$query->where([ '>=','date',$date_from ]);
		$query->andWhere([ '<=','date',$date_to ]);
		$list = $query->orderBy([ 'id' => SORT_ASC ])->all( );
		if( $list ){
			foreach( $list  as $_item ){
				$data['finance']['month'] += $_item['total_pay_money'];
				$data['member']['month_new'] += $_item['total_new_member_count'];
				$data['member']['total'] = $_item['total_member_count'];
				$data['order']['month'] += $_item['total_order_count'];
				$data['shared']['month'] += $_item['total_shared_count'];

				if( $_item['date'] == $date_to ){
					$data['finance']['today'] = $_item['total_pay_money'];
					$data['member']['today_new'] = $_item['total_new_member_count'];
					$data['order']['today'] = $_item['total_order_count'];
					$data['shared']['today'] = $_item['total_shared_count'];
				}
			}
		}

        return $this->render('index',[
        	'data' => $data
		]);
    }
}
