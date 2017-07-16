<?php
use app\common\services\UrlService;
use \app\common\services\ConstantMapService;
use app\common\services\StaticService;
StaticService::includeAppJsStatic('/js/web/account/list.js',app\assets\WebAsset::className());
?>
<div class="row">
    <div class="col-lg-12">
        <form class="form-inline wrap_search">
            <div class="row m-t p-w-m">
                <div class="form-group">
                    <select name="status" class="form-control inline">
                        <option value="<?= ConstantMapService::$status_default; ?>">请选择状态</option>
                        <?php foreach($status_mapping as $_status => $_title): ?>
                        <option value="<?= $_status; ?>" <?= $_status == $search_conditions['status']?'selected':''; ?>>
                            <?= $_title; ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <input type="text" name="mix_kw" placeholder="请输入姓名或者手机号码" class="form-control" value="<?= $search_conditions['mix_kw']; ?>">
                        <input type="hidden" name="page_cur" value="">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-primary search">
                                <i class="fa fa-search"></i>搜索
                            </button>
                        </span>
                    </div>
                </div>
            </div>
            <hr/>
            <div class="row">
                <div class="col-lg-12">
                    <a class="btn btn-w-m btn-outline btn-primary pull-right" href="/web/account/edit">
                        <i class="fa fa-plus"></i>账号
                    </a>
                </div>
            </div>
        </form>
        <table class="table table-bordered m-t">
            <thead>
                <tr>
                    <th>序号</th>
                    <th>姓名</th>
                    <th>手机</th>
                    <th>邮箱</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($list as $_item): ?>
                <tr>
                    <td><?= $_item['id']; ?></td>
                    <td><?= $_item['username']; ?></td>
                    <td><?= $_item['phone']; ?></td>
                    <td><?= $_item['email']; ?></td>
                    <td>
                        <a href="<?= UrlService::buildWebUrl('/account/info',['id' => $_item['id']]); ?>" title="帐号信息">
                            <i class="fa fa-eye fa-lg"></i>
                        </a>
                        <a class="m-l" href="<?= UrlService::buildWebUrl('/account/edit',['id' => $_item['id']]); ?>" title="编辑帐号">
                            <i class="fa fa-edit fa-lg"></i>
                        </a>
                        <?php if($_item['status']): ?>
                            <a class="m-l remove" href="javascript:void(0);" data="<?= $_item['id']; ?>" title="删除帐号">
                                <i class="fa fa-trash fa-lg"></i>
                            </a>
                        <?php else: ?>
                            <a class="m-l recover" href="javascript:void(0);" data="<?= $_item['id']; ?>" title="删除帐号">
                                <i class="fa fa-rotate-left fa-lg"></i>
                            </a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="row">
            <div class="col-lg-12">
                <span class="pagination_count" style="line-height: 40px;">共<?= $pages['total_count']; ?>条记录 | 每页<?= $pages['page_size']; ?>条</span>
                <ul class="pagination pagination-lg pull-right" style="margin: 0 0 ;">
                    <?php for($_page = 1;$_page <= $pages['total_page'];$_page++): ?>
                        <?php if($_page == $pages['page_cur']): ?>
                            <li class="active"><a href="<?= UrlService::buildNullUrl(); ?>"><?= $pages['page_cur']; ?></a></li>
                        <?php else: ?>
                            <li><a href="<?= UrlService::buildWebUrl('/account/list',['page_cur'=>$_page]) ?>"><?= $_page; ?></a></li>
                        <?php endif; ?>
                    <?php endfor; ?>
                </ul>
            </div>
        </div>
    </div>
</div>