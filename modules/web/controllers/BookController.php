<?php

namespace app\modules\web\controllers;

use app\common\services\book\BookService;
use app\common\services\ConstantMapService;
use app\common\services\DataHelper;
use app\common\services\UrlService;
use app\common\services\UtilService;
use app\models\book\Book;
use app\models\book\BookCat;
use app\models\book\BookSaleChangeLog;
use app\models\book\BookStockChangeLog;
use app\models\Images;
use app\models\member\Member;
use app\modules\web\controllers\common\BaseController;

class BookController extends BaseController{

    public function actionIndex(){
		$mix_kw = trim( $this->get("mix_kw","" ) );
		$status = intval( $this->get("status",ConstantMapService::$status_default ) );
		$cat_id = intval( $this->get("cat_id",0 ) );
		$p = intval( $this->get("p",1) );
		$p = ( $p > 0 )?$p:1;

		$query = Book::find();

		if( $mix_kw ){
			$where_name = [ 'LIKE','name','%-'.strtr($mix_kw,['%'=>'\%', '_'=>'\_', '\\'=>'\\\\']).'-%', false ];
			$where_tags = [ 'LIKE','tags','%'.strtr($mix_kw,['%'=>'\%', '_'=>'\_', '\\'=>'\\\\']).'%', false ];
			$query->andWhere([ 'OR',$where_name,$where_tags ]);
		}

		if( $status > ConstantMapService::$status_default ){
			$query->andWhere([ 'status' => $status ]);
		}

		if( $cat_id ){
			$query->andWhere([ 'cat_id' => $cat_id ]);
		}

		//分页功能,需要两个参数，1：符合条件的总记录数量  2：每页展示的数量
		//60,60 ~ 11,10 - 1
		$total_res_count = $query->count();
		$total_page = ceil( $total_res_count / $this->page_size );


		$list = $query->orderBy([ 'id' => SORT_DESC ])
			->offset( ( $p - 1 ) * $this->page_size )
			->limit($this->page_size)
			->all( );
		$cat_mapping = BookCat::find()->orderBy([ 'id' => SORT_DESC ])->indexBy("id")->all();

		$data = [];

		if( $list ){
			foreach( $list as $_item ){
				$tmp_cat_info = isset( $cat_mapping[ $_item['cat_id'] ] )?$cat_mapping[ $_item['cat_id'] ]:[];
				$data[] = [
					'id' => $_item['id'],
					'name' => UtilService::encode( $_item['name'] ),
					'price' => UtilService::encode( $_item['price'] ),
					'stock' => UtilService::encode( $_item['stock'] ),
					'tags' => UtilService::encode( $_item['tags'] ),
					'status' => UtilService::encode( $_item['status'] ),
					'cat_name' => $tmp_cat_info?UtilService::encode( $tmp_cat_info['name'] ):''
				];
			}
		}

        return $this->render('index',[
			'list' => $data,
			'search_conditions' => [
				'mix_kw' => $mix_kw,
				'p' => $p,
				'status' => $status,
				'cat_id' => $cat_id
			],
			'status_mapping' => ConstantMapService::$status_mapping,
			'cat_mapping' => $cat_mapping,
			'pages' => [
				'total_count' => $total_res_count,
				'page_size' => $this->page_size,
				'total_page' => $total_page,
				'p' => $p
			]
		]);
    }

    public function actionInfo(){
		$id = intval( $this->get("id", 0) );
		$reback_url = UrlService::buildWebUrl("/book/index");
		if( !$id ){
			return $this->redirect( $reback_url );
		}

		$info = Book::find()->where([ 'id' => $id ])->one();
		if( !$info ){
			return $this->redirect( $reback_url );
		}

		//销售历史
		$sale_change_log_list = BookSaleChangeLog::find()->where([ 'book_id' => $id ])->orderBy([ 'id' => SORT_DESC ])
			->asArray()->all();
		$data_sale_change_log = [];
		if( $sale_change_log_list ){
			$member_mapping = DataHelper::getDicByRelateID( $sale_change_log_list,Member::className(),"member_id","id",[ "nickname" ] );
			foreach( $sale_change_log_list as $_sale_item ){
				$tmp_member_info = isset( $member_mapping[ $_sale_item['member_id'] ] )?$member_mapping[ $_sale_item['member_id'] ]:[];
				$data_sale_change_log[] = [
					'quantity' => $_sale_item['quantity'],
					'price' => $_sale_item['price'],
					'member_info' => $tmp_member_info,
					'created_time' => $_sale_item['created_time']
				];
			}
		}

		//库存变更历史
		$stock_change_list = BookStockChangeLog::find()->where([ 'book_id' => $id ])
			->orderBy([ 'id' => SORT_DESC ])->asArray()->all();

		return $this->render("info",[
			"info" => $info,
			'stock_change_list' => $stock_change_list,
			'sale_change_log_list' => $data_sale_change_log
		]);
	}

	public function actionSet(){
		if( \Yii::$app->request->isGet ) {
			$id = intval( $this->get("id", 0) );
			$info = [];
			if( $id ){
				$info = Book::find()->where([ 'id' => $id ])->one();
			}

			$cat_list = BookCat::find()->orderBy([ 'id' => SORT_DESC ])->all();
			return $this->render('set',[
				'cat_list' => $cat_list,
				'info' => $info
			]);
		}

		$id = intval( $this->post("id",0) );
		$cat_id = intval( $this->post("cat_id",0) );
		$name = trim( $this->post("name","") );
		$price = floatval( $this->post("price",0) );
		$main_image = trim( $this->post("main_image","") );
		$summary = trim( $this->post("summary","") );
		$stock = intval( $this->post("stock",0) );
		$tags = trim( $this->post("tags","") );
		$date_now = date("Y-m-d H:i:s");

		if( !$cat_id ){
			return $this->renderJSON([],"请输入图书分类~~",-1);
		}

		if( mb_strlen( $name,"utf-8" ) < 1 ){
			return $this->renderJSON([],"请输入符合规范的图书名称~~",-1);
		}

		if( $price <= 0  ){
			return $this->renderJSON([],"请输入符合规范的图书售卖价格~~",-1);
		}

		if( mb_strlen( $main_image ,"utf-8") < 3 ){
			return $this->renderJSON([],"请上传封面图~~",-1);
		}

		if( mb_strlen( $summary,"utf-8" ) < 10 ){
			return $this->renderJSON([],"请输入图书描述，并不能少于10个字符~~",-1);
		}

		if( $stock < 1 ){
			return $this->renderJSON([],"请输入符合规范的库存量~~",-1);
		}

		if( mb_strlen( $tags,"utf-8" ) < 1 ){
			return $this->renderJSON([],"请输入图书标签，便于搜索~~",-1);
		}


		$info = [];
		if( $id ){
			$info = Book::findOne(['id' => $id]);
		}
		if( $info ){
			$model_book = $info;
		}else{
			$model_book = new Book();
			$model_book->status = 1;
			$model_book->created_time = $date_now;
		}

		$before_stock = $model_book->stock;

		$model_book->cat_id = $cat_id;
		$model_book->name = $name;
		$model_book->price = $price;
		$model_book->main_image = $main_image;
		$model_book->summary = $summary;
		$model_book->stock = $stock;
		$model_book->tags = $tags;
		$model_book->updated_time = $date_now;
		if( $model_book->save( 0 ) ){
			BookService::setStockChangeLog( $model_book->id,( $model_book->stock - $before_stock ) );
		}
		return $this->renderJSON([],"操作成功~~");
	}

	public function actionOps(){
		if( !\Yii::$app->request->isPost ){
			return $this->renderJSON( [],ConstantMapService::$default_syserror,-1 );
		}

		$id = $this->post('id',[]);
		$act = trim($this->post('act',''));
		if( !$id ){
			return $this->renderJSON([],"请选择要操作的账号~~",-1);
		}

		if( !in_array( $act,['remove','recover' ])){
			return $this->renderJSON([],"操作有误，请重试~~",-1);
		}

		$info = Book::find()->where([ 'id' => $id ])->one();
		if( !$info ){
			return $this->renderJSON([],"指定书籍不存在~~",-1);
		}

		switch ( $act ){
			case "remove":
				$info->status = 0;
				break;
			case "recover":
				$info->status = 1;
				break;
		}
		$info->updated_time = date("Y-m-d H:i:s");
		$info->update( 0 );
		return $this->renderJSON( [],"操作成功~~" );
	}

	public function actionCat(){
		$status = intval( $this->get("status",ConstantMapService::$status_default ) );
		$query = BookCat::find();

		if( $status > ConstantMapService::$status_default ){
			$query->where([ 'status' => $status ]);
		}

		$list = $query->orderBy([ 'weight' => SORT_DESC ,'id' => SORT_DESC ])->all( );

		return $this->render('cat',[
			'list' => $list,
			'status_mapping' => ConstantMapService::$status_mapping,
			'search_conditions' => [
				'status' => $status
			]
		]);
	}

	public function actionCat_set(){
		if( \Yii::$app->request->isGet ){
			$id = intval( $this->get("id",0) );
			$info = [];
			if( $id ){
				$info = BookCat::find()->where([ 'id' => $id ])->one();
			}

			return $this->render("cat_set",[
				'info' => $info
			]);
		}

		$id = intval( $this->post("id",0) );
		$weight = intval( $this->post("weight",1) );
		$name = trim( $this->post("name","") );
		$date_now = date("Y-m-d H:i:s");

		if( mb_strlen( $name,"utf-8" ) < 1 ){
			return $this->renderJSON( [] , "请输入符合规范的分类名称~~" ,-1);
		}

		$has_in = BookCat::find()->where([ 'name' => $name ])->andWhere([ '!=','id',$id ])->count();
		if( $has_in ){
			return $this->renderJSON( [] , "该分类名称已存在，请换一个试试~~" ,-1);
		}

		$cat_info = BookCat::find()->where([ 'id' => $id ])->one();
		if( $cat_info ){
			$model_book_cat = $cat_info;
		}else{
			$model_book_cat = new BookCat();
			$model_book_cat->created_time = $date_now;
		}

		$model_book_cat->name = $name;
		$model_book_cat->weight = $weight;
		$model_book_cat->updated_time = $date_now;
		$model_book_cat->save( 0 );

		return $this->renderJSON( [],"操作成功~~" );
	}

	public function actionCat_ops(){
		if( !\Yii::$app->request->isPost ){
			return $this->renderJSON( [],ConstantMapService::$default_syserror,-1 );
		}

		$id = $this->post('id',[]);
		$act = trim($this->post('act',''));
		if( !$id ){
			return $this->renderJSON([],"请选择要操作的账号~~",-1);
		}

		if( !in_array( $act,['remove','recover' ])){
			return $this->renderJSON([],"操作有误，请重试~~",-1);
		}

		$info = BookCat::find()->where([ 'id' => $id ])->one();
		if( !$info ){
			return $this->renderJSON([],"指定分类不存在~~",-1);
		}

		switch ( $act ){
			case "remove":
				$info->status = 0;
				break;
			case "recover":
				$info->status = 1;
				break;
		}
		$info->updated_time = date("Y-m-d H:i:s");
		$info->update( 0 );
		return $this->renderJSON( [],"操作成功~~" );
	}

	public function actionImages(){
		$p = intval( $this->get("p",1) );
		$p = ( $p > 0 )?$p:1;

		$bucket = "book";
		$query = Images::find()->where([ 'bucket' => $bucket ]);

		//分页功能,需要两个参数，1：符合条件的总记录数量  2：每页展示的数量
		//60,60 ~ 11,10 - 1
		$total_res_count = $query->count();
		$total_page = ceil( $total_res_count / $this->page_size );


		$list = $query->orderBy([ 'id' => SORT_DESC ])
			->offset( ( $p - 1 ) * $this->page_size )
			->limit($this->page_size)
			->all( );

		$data = [];
		if( $list ){
			foreach ( $list as $_item ){
				$data[] = [
					'url' => UrlService::buildPicUrl( $bucket,$_item['file_key'] )
				];
			}
		}
		return $this->render("images",[
			'list' => $data,
			'pages' => [
				'total_count' => $total_res_count,
				'page_size' => $this->page_size,
				'total_page' => $total_page,
				'p' => $p
			]
		]);
	}

}
