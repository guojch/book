<?php
use \app\common\services\UrlService;
use \app\common\services\UtilService;
use \app\common\services\StaticService;
use \app\common\services\ConstantMapService;
StaticService::includeAppJsStatic( "/js/web/book/index.js",\app\assets\WebAsset::className() );
?>

<?php echo \Yii::$app->view->renderFile("@app/modules/web/views/common/tab_book.php", ['current' => 'book']); ?>

<div class="row">
    <div class="col-lg-12">
        <form class="form-inline wrap_search">
            <div class="row  m-t p-w-m">
                <div class="form-group">
                    <select name="status" class="form-control inline">
                        <option value="<?=ConstantMapService::$status_default;?>">请选择状态</option>
						<?php foreach( $status_mapping as $_status => $_title ):?>
                            <option value="<?=$_status;?>" <?php if( $search_conditions['status']  == $_status):?> selected <?php endif;?> ><?=$_title;?></option>
						<?php endforeach;?>
                    </select>
                </div>
                <div class="form-group">
                    <select name="cat_id" class="form-control inline">
                        <option value="0">请选择分类</option>
						<?php foreach( $cat_mapping as $_cat_info ):?>
                            <option value="<?=$_cat_info['id'];?>" <?php if( $search_conditions['cat_id']  == $_cat_info['id']):?> selected <?php endif;?> ><?=UtilService::encode( $_cat_info['name'] );?></option>
						<?php endforeach;?>
                    </select>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <input type="text" name="mix_kw" placeholder="请输入关键字" class="form-control" value="<?=$search_conditions['mix_kw'];?>">
                        <span class="input-group-btn">
                            <button type="button" class="btn  btn-primary search">
                                <i class="fa fa-search"></i>搜索
                            </button>
                        </span>
                    </div>
                </div>
            </div>
            <hr/>
            <div class="row">
                <div class="col-lg-12">
                    <a class="btn btn-w-m btn-outline btn-primary pull-right" href="<?=UrlService::buildWebUrl("/book/set");?>">
                        <i class="fa fa-plus"></i>图书
                    </a>
                </div>
            </div>

        </form>
        <table class="table table-bordered m-t">
            <thead>
            <tr>
                <th>图书名</th>
                <th>分类</th>
                <th>价格</th>
                <th>库存</th>
                <th>标签</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
			<?php if( $list ):?>
				<?php foreach( $list as $_item ):?>
                    <tr>
                        <td><?= $_item['name'];?></td>
                        <td><?= $_item['cat_name'] ;?></td>
                        <td><?= $_item['price'] ;?></td>
                        <td><?= $_item['stock'] ;?></td>
                        <td><?= $_item['tags'];?></td>
                        <td>
                            <a  href="<?=UrlService::buildWebUrl("/book/info",[ 'id' => $_item['id'] ] );?>">
                                <i class="fa fa-eye fa-lg"></i>
                            </a>
							<?php if( $_item['status'] ):?>
                                <a class="m-l" href="<?=UrlService::buildWebUrl("/book/set",[ 'id' => $_item['id'] ]);?>">
                                    <i class="fa fa-edit fa-lg"></i>
                                </a>

                                <a class="m-l remove" href="<?=UrlService::buildNullUrl();?>" data="<?=$_item['id'];?>">
                                    <i class="fa fa-trash fa-lg"></i>
                                </a>
							<?php else:?>
                                <a class="m-l recover" href="<?=UrlService::buildNullUrl();?>" data="<?=$_item['id'];?>">
                                    <i class="fa fa-rotate-left fa-lg"></i>
                                </a>
							<?php endif;?>
                        </td>
                    </tr>
				<?php endforeach;?>
			<?php else:?>
                <tr><td colspan="6">暂无数据</td></tr>
			<?php endif;?>
            </tbody>
        </table>
		<?php echo \Yii::$app->view->renderFile("@app/modules/web/views/common/pagination.php", [
			'pages' => $pages,
			'url' => '/book/index'
		]); ?>

    </div>
</div>
