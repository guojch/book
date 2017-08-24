<?php
use \app\common\services\UrlService;
use \app\common\services\StaticService;
StaticService::includeAppJsStatic( "/js/m/product/index.js",\app\assets\MAsset::className() );
?>
<div class="search_header">
    <a href="<?=UrlService::buildNullUrl();?>" class="category_icon"></a>
    <input name="kw" type="text" class="search_input" placeholder="请输入您搜索的关键词" value="<?=$search_conditions['kw'];?>" />
    <i class="search_icon"></i>
</div>
<div class="sort_box">
    <ul class="sort_list clearfix">
        <li>
            <a href="<?=UrlService::buildNullUrl();?>" <?php if(  $search_conditions['sort_field'] == "default" ) :?> class="aon" <?php endif;?> data="default">
                <span>默认</span>
            </a>
        </li>
        <li>
            <a href="<?=UrlService::buildNullUrl();?>" <?php if(  $search_conditions['sort_field'] == "month_count" ) :?> class="aon" <?php endif;?> data="month_count">
                <span>月销量
					<?php if(  $search_conditions['sort_field'] == "month_count" ) :?>
                        <?php if( $search_conditions['sort'] == "asc" ):?>
                            <i class="lowly_icon"></i>
                        <?php else:?>
                            <i class="high_icon"></i>
                        <?php endif;?>
                    <?php else:?>
                        <i></i>
                    <?php endif;?>
                </span>
            </a>
        </li>
        <li>
            <a href="<?=UrlService::buildNullUrl();?>" <?php if(  $search_conditions['sort_field'] == "view_count" ) :?> class="aon" <?php endif;?> data="view_count">
                <span>人气
					<?php if(  $search_conditions['sort_field'] == "view_count" ) :?>
						<?php if( $search_conditions['sort'] == "asc" ):?>
                            <i class="lowly_icon"></i>
						<?php else:?>
                            <i class="high_icon"></i>
						<?php endif;?>
					<?php else:?>
                        <i></i>
					<?php endif;?>
                </span>
            </a>
        </li>
        <li>
            <a href="<?=UrlService::buildNullUrl();?>" <?php if(  $search_conditions['sort_field'] == "price" ) :?> class="aon" <?php endif;?> data="price">
                <span>价格
					<?php if(  $search_conditions['sort_field'] == "price" ) :?>
						<?php if( $search_conditions['sort'] == "asc" ):?>
                            <i class="lowly_icon"></i>
						<?php else:?>
                            <i class="high_icon"></i>
						<?php endif;?>
					<?php else:?>
                        <i></i>
					<?php endif;?>
                </span>
            </a>
        </li>
    </ul>
</div>
<div class="probox">
    <?php if( $list ):?>
        <ul class="prolist">
            <?php foreach( $list as $_item ):?>
            <li>
                <a href="<?=UrlService::buildMUrl("/product/info",[ 'id' => $_item['id'] ]);?>">
                    <i><img src="<?=$_item['main_image_url'];?>"  style="width: 100%;height: 200px;"/></i>
                    <span><?=$_item['name'];?></span>
                    <b><label>月销量<?=$_item['month_count'];?></label>¥<?=$_item['price'];?></b>
                </a>
            </li>
            <?php endforeach;?>
    </ul>
    <?php else:?>
        <div class="no-data">
            暂无图书
        </div>
    <?php endif;?>
</div>