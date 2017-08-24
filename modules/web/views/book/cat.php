<?php
use \app\common\services\ConstantMapService;
use \app\common\services\UrlService;
use \app\common\services\StaticService;
StaticService::includeAppJsStatic( "/js/web/book/cat.js",\app\assets\WebAsset::className() );
?>

<?php echo \Yii::$app->view->renderFile("@app/modules/web/views/common/tab_book.php", ['current' => 'cat']); ?>

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
			</div>
			<hr/>
			<div class="row">
				<div class="col-lg-12">
					<a class="btn btn-w-m btn-outline btn-primary pull-right" href="<?=UrlService::buildWebUrl("/book/cat_set");?>">
						<i class="fa fa-plus"></i>分类
					</a>
				</div>
			</div>

		</form>
		<table class="table table-bordered m-t">
			<thead>
			<tr>
				<th>序号</th>
				<th>分类名称</th>
				<th>状态</th>
				<th>权重</th>
				<th>操作</th>
			</tr>
			</thead>
			<tbody>
            <?php if( $list ):?>
                <?php foreach( $list as $_item ):?>
                <tr>
                    <td><?=$_item['id'];?></td>
                    <td><?=$_item['name'];?></td>
                    <td><?=$status_mapping[ $_item['status'] ];?></td>
                    <td><?=$_item['weight'];?></td>
                    <td>
                        <?php if( $_item['status'] ):?>
                            <a class="m-l" href="<?=UrlService::buildWebUrl("/book/cat_set",[ 'id' => $_item['id'] ]);?>">
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
                <tr><td colspan="5">暂无数据</td></tr>
            <?php endif;?>
			</tbody>
		</table>
	</div>
</div>
