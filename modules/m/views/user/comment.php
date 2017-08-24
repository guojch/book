<?php
use \app\common\services\UtilService;
use \app\common\services\StaticService;
StaticService::includeAppJsStatic( "/plugins/raty/jquery.raty.min.js",\app\assets\MAsset::className() );
StaticService::includeAppJsStatic( "/js/m/user/comment.js",\app\assets\MAsset::className() );
?>
<div class="page_title clearfix">
    <span>我的评论</span>
</div>
<?php if( $list ):?>
    <ul class="address_list">
		<?php foreach( $list as $_item ):?>
            <li>
                <p>评分：<span class="star" style="width: 200px;" data-score="<?=$_item['score'];?>"></span></p>
                <p>评价内容：<?=UtilService::encode( $_item['content'] );?></p>
            </li>
		<?php endforeach;?>
    </ul>
<?php endif;?>