<?php
namespace app\common\services;

use app\models\QueueList;

class QueueListService extends BaseService{

	public static function addQueue( $queue_name,$data = []){
		$model = new QueueList();
		$model->queue_name = $queue_name;
		$model->data = json_encode( $data );
		$model->status = -1;
		$model->created_time = $model->updated_time = date("Y-m-d H:i:s");
		return $model->save( 0 );
	}

}