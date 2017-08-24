<?php

namespace app\modules\web\controllers;

use app\common\services\ConstantMapService;
use app\common\services\DataHelper;
use app\common\services\PayOrderService;
use app\common\services\QueueListService;
use app\common\services\UrlService;
use app\common\services\UtilService;
use app\models\book\Book;
use app\models\book\BookCat;
use app\models\City;
use app\models\Images;
use app\models\member\Member;
use app\models\member\MemberAddress;
use app\models\pay\PayOrder;
use app\models\pay\PayOrderItem;
use app\models\QueueList;
use app\modules\web\controllers\common\BaseController;

class FinanceController extends BaseController{

    public function actionIndex(){

		$status = intval( $this->get("status",ConstantMapService::$status_default ) );
		$p = intval( $this->get("p",1) );
		$p = ( $p > 0 )?$p:1;

		$pay_status_mapping = ConstantMapService::$pay_status_mapping;

		$query = PayOrder::find();

		if( $status > ConstantMapService::$status_default ){
			$query->andWhere([ 'status' => $status ]);
		}

		//分页功能,需要两个参数，1：符合条件的总记录数量  2：每页展示的数量
		//60,60 ~ 11,10 - 1
		$total_res_count = $query->count();
		$total_page = ceil( $total_res_count / $this->page_size );


		$list = $query->orderBy([ 'id' => SORT_DESC ])
			->offset(  ( $p - 1 ) * $this->page_size )
			->limit($this->page_size)
			->asArray()
			->all( );

		$data = [];

		if( $list ){
			$order_item_list = PayOrderItem::find()->where([ 'pay_order_id' =>  array_column( $list,"id" ) ])->asArray()->all();
			$book_mapping = Book::find()->select([ "id",'name' ])->where([ 'id' => array_column( $order_item_list,"target_id" ) ])->indexBy("id")->all();
			$pay_order_mapping = [];
			foreach( $order_item_list as $_order_item_info ){
				$tmp_book_info = $book_mapping[ $_order_item_info['target_id'] ];
				if( !isset( $pay_order_mapping[ $_order_item_info['pay_order_id'] ] ) ){
					$pay_order_mapping[ $_order_item_info['pay_order_id'] ] = [];
				}

				$pay_order_mapping[ $_order_item_info['pay_order_id'] ][] = [
					'name' => $tmp_book_info['name'],
					'quantity' => $_order_item_info['quantity']
				];
			}

			foreach( $list as $_item ){
				$data[] = [
					'id' => $_item['id'],
					'sn' => date("Ymd",strtotime( $_item['created_time'] ) ).$_item['id'],
					'pay_price' => $_item['pay_price'],
					'status_desc' => $pay_status_mapping[ $_item['status'] ],
					'status' => $_item['status'],
					'pay_time' => date("Y-m-d H:i",strtotime( $_item['pay_time'] ) ),
					'created_time' => date("Y-m-d H:i",strtotime( $_item['created_time'] ) ),
					'items' => isset( $pay_order_mapping[ $_item['id'] ] )?$pay_order_mapping[ $_item['id'] ]:[]
				];
			}
		}

        return $this->render('index',[
			'list' => $data,
			'search_conditions' => [
				'p' => $p,
				'status' => $status
			],
			'status_mapping' => $pay_status_mapping,
			'pages' => [
				'total_count' => $total_res_count,
				'page_size' => $this->page_size,
				'total_page' => $total_page,
				'p' => $p
			]
		]);
    }

	public function actionAccount(){

		$p = intval( $this->get("p",1) );
		$p = ( $p > 0 )?$p:1;

		$query = PayOrder::find()->where([ 'status' => 1 ]);

		//分页功能,需要两个参数，1：符合条件的总记录数量  2：每页展示的数量
		//60,60 ~ 11,10 - 1
		$total_res_count = $query->count();
		$total_page = ceil( $total_res_count / $this->page_size );

		$total_pay_money = $query->sum( "pay_price" );

		$list = $query->orderBy([ 'pay_time' => SORT_DESC ])
			->offset(  ( $p - 1 ) * $this->page_size  )
			->limit($this->page_size)
			->asArray()
			->all( );

		$data = [];

		if( $list ){

			foreach( $list as $_item ){
				$data[] = [
					'id' => $_item['id'],
					'sn' => date("Ymd",strtotime( $_item['created_time'] ) ).$_item['id'],
					'pay_price' => $_item['pay_price'],
					'pay_time' => date("Y-m-d H:i",strtotime( $_item['pay_time'] ) )
				];
			}
		}

		$total_pay_money = $total_pay_money?$total_pay_money:0;

		return $this->render('account',[
			'list' => $data,
			'search_conditions' => [
				'p' => $p,
			],
			'total_pay_money' => sprintf("%.2f",$total_pay_money),
			'pages' => [
				'total_count' => $total_res_count,
				'page_size' => $this->page_size,
				'total_page' => $total_page,
				'p' => $p
			]
		]);
	}

	public function actionPay_info(){
		$id = intval( $this->get("id",0) );
		$reback_url = UrlService::buildWebUrl("/finance/index");
		if( !$id ){
			return $this->redirect( $reback_url );
		}

		$pay_order_info = PayOrder::find()->where([ 'id' => $id ])->one();
		if( !$pay_order_info ){
			return $this->redirect( $reback_url );
		}

		$order_item_list = PayOrderItem::find()->where([ 'pay_order_id' =>  $id ])->asArray()->all();
		$book_mapping = Book::find()->select([ "id",'name' ])
			->where([ 'id' => array_column( $order_item_list,"target_id" ) ])
			->indexBy("id")->all();

		$pay_order_items = [];
		foreach( $order_item_list as $_order_item_info ){
			$tmp_book_info = $book_mapping[ $_order_item_info['target_id'] ];
			$pay_order_items[] = [
				'name' => $tmp_book_info['name'],
				'quantity' => $_order_item_info['quantity'],
				'price' => $_order_item_info['price'],
			];
		}

		$data_pay_order_info = [
			'id' => $pay_order_info['id'],
			'sn' => date("Ymd",strtotime( $pay_order_info['created_time'] ) ).$pay_order_info['id'],
			'pay_price' => $pay_order_info['pay_price'],
			'status_desc' => ConstantMapService::$pay_status_mapping[ $pay_order_info['status'] ],
			'status' => $pay_order_info['status'],
			'express_status_desc' => ConstantMapService::$express_status_mapping[ $pay_order_info['express_status'] ],
			'express_status' => $pay_order_info['express_status'],
			'pay_time' => date("Y-m-d H:i",strtotime( $pay_order_info['pay_time'] ) ),
			'created_time' => date("Y-m-d H:i",strtotime( $pay_order_info['created_time'] ) ),
		];


		$member_info = Member::findOne([ 'id' => $pay_order_info['member_id'] ]);
		$data_member_info = [
			'nickname' => $member_info['nickname'],
			'mobile' => $member_info['mobile'],
		];

		$address_info = MemberAddress::findOne([ 'id' => $pay_order_info['express_address_id'] ]);
		$area_info = City::findOne([ 'id' => $address_info['area_id']  ]);
		$area = $area_info['province'].$area_info['city'];
		if( $address_info['province_id'] != $address_info['city_id'] ){
			$area .= $area_info['area_id'];
		}

		$data_address_info = [
			'nickname' => $address_info['nickname'],
			'mobile' => $address_info['mobile'],
			'address' => $area.$address_info['address']
		];


		return $this->render("pay_info",[
			'pay_order_info' => $data_pay_order_info,
			'pay_order_items' => $pay_order_items,
			'member_info' => $data_member_info,
			'address_info' => $data_address_info
		]);
	}

	public function actionExpress(){
		$id = intval( $this->post("id",0) );
		$express_info = trim( $this->post("express_info",0 ) );
		if( !$id ){
			return $this->renderJSON([],ConstantMapService::$default_syserror,-1);
		}

		if( mb_strlen( $express_info,"utf-8" ) < 3 ){
			return $this->renderJSON([],'请输入符合要求的快递信息~~',-1);
		}

		$pay_order_info = PayOrder::find()->where([ 'id' => $id ])->one();
		if( !$pay_order_info ){
			return $this->renderJSON([],ConstantMapService::$default_syserror,-1);
		}

		$pay_order_info->express_info = $express_info;
		$pay_order_info->express_status = -6;
		$pay_order_info->updated_time = date("Y-m-d H:i:s");
		if( $pay_order_info->update( 0 ) ){
			//发货之后要发通知
			QueueListService::addQueue( "express",[
				'member_id' => $pay_order_info['member_id'],
				'pay_order_id' => $id
			] );
		}
		return $this->renderJSON([],"操作成功~~");
	}

}
