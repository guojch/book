<?php
namespace app\common\services\book;


use app\common\services\BaseService;
use app\models\book\Book;
use app\models\book\BookSaleChangeLog;
use app\models\book\BookStockChangeLog;
use app\models\pay\PayOrder;
use app\models\pay\PayOrderItem;

class BookService extends BaseService {

	public static function setStockChangeLog( $book_id = 0,$unit = 0,$note = '' ){

		if( !$book_id || !$unit ){
			return false;
		}

		$info = Book::find()->where([ 'id' => $book_id ])->one();
		if( !$info ){
			return false;
		}

		$model_stock = new BookStockChangeLog();
		$model_stock->book_id = $book_id;
		$model_stock->unit = $unit;
		$model_stock->total_stock = $info['stock'];
		$model_stock->note = $note;
		$model_stock->created_time = date("Y-m-d H:i;s");
		return $model_stock->save( 0 );
	}

	public static function confirmOrderItem( $order_item_id ){
		$order_item_info = PayOrderItem::findOne(['id' => $order_item_id,'status' => 1]);
		if( !$order_item_info  ){
			return false;
		}

		$order_info  = PayOrder::findOne(['id' => $order_item_info["pay_order_id"] ]);
		if( !$order_info ){
			return false;
		}

		$model_book_sale_change_log = new BookSaleChangeLog();
		$model_book_sale_change_log->book_id = $order_item_info['target_id'];
		$model_book_sale_change_log->quantity = $order_item_info['quantity'];
		$model_book_sale_change_log->price = $order_item_info['price'];
		$model_book_sale_change_log->member_id = $order_item_info['member_id'];
		$model_book_sale_change_log->created_time = date("Y-m-d H:i:s");
		return $model_book_sale_change_log->save( 0 );
	}
}