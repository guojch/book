<?php

namespace app\common\services;


use app\common\services\BaseService;
use app\common\services\book\BookService;
use app\common\services\ConstantMapService;
use app\models\book\Book;
use app\models\pay\PayOrder;
use app\models\pay\PayOrderCallbackData;
use app\models\pay\PayOrderItem;
use \Exception;

class PayOrderService extends  BaseService {

	public static function createPayOrder( $member_id,$items = [],$params = []){
		$total_price = 0;
		$continue_cnt = 0;
		foreach( $items as $_item ){
			if( $_item['price'] < 0 ){
				$continue_cnt += 1;
				continue;
			}
			$total_price += $_item['price'];
		}

		if( $continue_cnt >= count($items) ){
			return self::_err( "商品items为空~~" );
		}

		$discount = isset( $params['discount'] )?$params['discount']:0;
		$total_price = sprintf("%.2f",$total_price);
		$discount = sprintf("%.2f",$discount);
		$pay_price = $total_price - $discount;
		$pay_price = sprintf("%.2f",$pay_price);

		$date_now = date("Y-m-d H:i:s");
		$connection =  PayOrder::getDb();
		$transaction = $connection->beginTransaction();
		try{
			//为了防止并发 库存出问题了，select for update
			$tmp_book_table_name = Book::tableName();
			$tmp_book_ids = array_column( $items,'target_id' );
			$tmp_sql = "SELECT id,stock FROM {$tmp_book_table_name} WHERE id in (".implode(",",$tmp_book_ids).") FOR UPDATE";
			$tmp_book_list = $connection->createCommand($tmp_sql)->queryAll();
			$tmp_book_unit_mapping = [];
			foreach( $tmp_book_list as $_book_info ){
				$tmp_book_unit_mapping[ $_book_info['id'] ] = $_book_info['stock'];
			}

			$model_pay_order = new PayOrder();
			$model_pay_order->order_sn = self::generate_order_sn();
			$model_pay_order->member_id = $member_id;
			$model_pay_order->pay_type = isset($params['pay_type'])?$params['pay_type']:0;
			$model_pay_order->pay_source = isset($params['pay_source'])?$params['pay_source']:0;
			$model_pay_order->target_type = isset($params['target_type'])?$params['target_type']:0;
			$model_pay_order->total_price = $total_price;
			$model_pay_order->discount = $discount;
			$model_pay_order->pay_price = $pay_price;
			$model_pay_order->note = isset($params['note'])?$params['note']:'';
			$model_pay_order->status = isset($params['status'])?$params['status']:-8;
			$model_pay_order->express_status = isset($params['express_status'])?$params['express_status']:-8;
			$model_pay_order->express_address_id = isset($params['express_address_id'])?$params['express_address_id']:0;
			$model_pay_order->pay_time = ConstantMapService::$default_time_stamps;
			$model_pay_order->updated_time = $date_now;
			$model_pay_order->created_time = $date_now;
			if( !$model_pay_order->save(0) ){
				throw new Exception("创建订单失败~~");
			}

			foreach($items as $_item){

				$tmp_left_stock = $tmp_book_unit_mapping[ $_item['target_id'] ];
				if( $tmp_left_stock < $_item['quantity'] ){
					throw new Exception("购买书籍库存不够,目前剩余库存：{$tmp_left_stock},你购买:{$_item['quantity']}~~");
				}

				if( !Book::updateAll( [ 'stock' => $tmp_left_stock - $_item['quantity'] ],[ 'id' => $_item['target_id'] ] ) ){
					throw new Exception("下单失败请重新下单~~");
				}

				$new_item = new PayOrderItem();
				$new_item->pay_order_id = $model_pay_order->id;
				$new_item->member_id = $member_id;
				$new_item->quantity  = $_item['quantity'];
				$new_item->price  = $_item['price'];
				$new_item->target_type  = $_item['target_type'];
				$new_item->target_id  = $_item['target_id'];
				$new_item->status = isset($_item['status'])?$_item['status']:1;

				if( isset( $_item['extra_data'] ) ){
					$new_item->extra_data = json_encode( $_item['extra_data'] );
				}

				$new_item->note = isset( $_item['note'] )?$_item['note']:"";
				$new_item->updated_time = $date_now;
				$new_item->created_time  = $date_now;
				if( !$new_item->save(0) ){
					throw new Exception("创建订单失败~~");
				}

				BookService::setStockChangeLog( $_item['target_id'],-$_item['quantity'],"在线购买" );

			}

			$transaction->commit();

			return [
				'id' => $model_pay_order->id,
				'order_sn' => $model_pay_order->order_sn,
				'pay_money' => $model_pay_order->pay_price,
			];

		}catch (Exception $e) {
			$transaction->rollBack();
			return self::_err( $e->getMessage() );
		}
	}

	public static function orderSuccess($pay_order_id,$params = []){

		$date_now = date("Y-m-d H:i:s");
		$connection = PayOrder::getDb();
		$transaction = $connection->beginTransaction();
		try {
			$pay_order_info = PayOrder::findOne( $pay_order_id );
			if( !$pay_order_info || !in_array( $pay_order_info['status'],[-8,-7] ) ){//只有-8，-7状态才可以操作
				return true;
			}

			$pay_order_info->pay_sn = isset($params['pay_sn'])?$params['pay_sn']:"";
			$pay_order_info->status = 1;
			$pay_order_info->express_status = -7;
			$pay_order_info->pay_time = $date_now;
			$pay_order_info->updated_time = $date_now;
			$pay_order_info->update(0);
			$items = PayOrderItem::findAll( [ 'pay_order_id' => $pay_order_id ] );

			foreach($items as $_item){
				switch( $_item->target_type ){
					case 1://书籍购买
						BookService::confirmOrderItem( $_item['id'] );
						break;
					case 2:
						break;
				}
			}

			$transaction->commit();

		} catch (Exception $e) {
			$transaction->rollBack();
			return self::_err( $e->getMessage() );
		}

		//需要做一个队列数据库了,用队里处理销售月统计
		QueueListService::addQueue( "pay",[
			'member_id' => $pay_order_info['member_id'],
			'pay_order_id' => $pay_order_info['id'],
		] );

		return true;

	}

	public static function closeOrder( $pay_order_id = 0 ){
		$date_now = date("Y-m-d H:i:s");
		$pay_order_info = PayOrder::find()->where([ 'id' => $pay_order_id,'status' => -8 ])->one();
		if( !$pay_order_info ){
			return self::_err("指定订单不存在");
		}

		$pay_order_items = PayOrderItem::findAll( [ 'pay_order_id' => $pay_order_id ] );

		if( $pay_order_items ){
			foreach( $pay_order_items as $_order_item_info ){

				switch ( $_order_item_info['target_type'] ){
					case 1:
						$tmp_book_info = Book::find()->where([ 'id' => $_order_item_info['target_id'] ])->one();
						if( $tmp_book_info ){
							$tmp_book_info->stock += $_order_item_info['quantity'];
							$tmp_book_info->updated_time = $date_now;
							$tmp_book_info->update( 0 );
							BookService::setStockChangeLog( $_order_item_info['target_id'],$_order_item_info['quantity'],"订单过期释放库存" );
						}
						break;
				}


			}
		}

		$pay_order_info->status = 0;
		$pay_order_info->updated_time = $date_now;
		return $pay_order_info->update(0);
	}

	public static function generate_order_sn(){
		do{
			$sn = md5(microtime(1).rand(0,9999999).'!@%egg#$');

		}while( PayOrder::findOne( [ 'order_sn' => $sn ] ) );

		return $sn;
	}

	public static function setPayOrderCallbackData($pay_order_id,$type,$callback = ''){
		if(!$pay_order_id){
			return self::_err("pay_order_id不能为空！");
		}
		if(!in_array($type,['pay','refund'])){
			return self::_err("类型参数错误！");
		}
		$pay_order = PayOrder::findOne(['id' => $pay_order_id]);
		if(!$pay_order){
			return self::_err("找不到订单号为".$pay_order_id."的订单！");
		}


		$callback_data = PayOrderCallbackData::findOne(['pay_order_id' => $pay_order_id]);
		if(!$callback_data){
			$callback_data = new PayOrderCallbackData();
			$callback_data->pay_order_id = $pay_order_id;
			$callback_data->created_time = date("Y-m-d H:i:s");
		}
		if( $type == "refund" ){
			$callback_data->refund_data = $callback;
			$callback_data->pay_data = '';
		}else{
			$callback_data->pay_data = $callback;
			$callback_data->refund_data = '';
		}
		$callback_data->updated_time = date("Y-m-d H:i:s");
		$callback_data->save(0);
		return true;
	}
}