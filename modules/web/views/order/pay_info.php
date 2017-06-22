<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>管理后台</title>
	<link href="/css/web/bootstrap.min.css" rel="stylesheet">
<link href="/font-awesome/css/font-awesome.css" rel="stylesheet">
<link href="/css/web/style.css?ver=20170401" rel="stylesheet"></head>

<body>
<div id="wrapper">
	<nav class="navbar-default navbar-static-side" role="navigation">
		<div class="sidebar-collapse">
			<ul class="nav metismenu" id="side-menu">
				<li class="nav-header">
					<div class="profile-element text-center">
                        <img alt="image" class="img-circle" src="/images/web/logo.png" />
                        <p class="text-muted">编程浪子</p>
					</div>
					<div class="logo-element">
                        <img alt="image" class="img-circle" src="/images/web/logo.png" />
					</div>
				</li>
				<li class="dashboard">
					<a href="/web/dashboard/index"><i class="fa fa-dashboard fa-lg"></i>
                        <span class="nav-label">仪表盘</span></a>
				</li>
				<li class="account">
					<a href="/web/account/index"><i class="fa fa-user fa-lg"></i> <span class="nav-label">账号管理</span></a>
				</li>
                <li class="brand">
                    <a href="/web/brand/info"><i class="fa fa-cog fa-lg"></i> <span class="nav-label">品牌设置</span></a>
                </li>
                <li class="book">
                    <a href="/web/book/index"><i class="fa fa-book fa-lg"></i> <span class="nav-label">图书管理</span></a>
                </li>
                <li class="member">
                    <a href="/web/member/index"><i class="fa fa-group fa-lg"></i> <span class="nav-label">会员列表</span></a>
                </li>
                <li class="finance">
                    <a href="/web/finance/index"><i class="fa fa-rmb fa-lg"></i> <span class="nav-label">财务管理</span></a>
                </li>
                <li class="market">
                    <a href="/web/qrcode/index"><i class="fa fa-share-alt fa-lg"></i> <span class="nav-label">营销渠道</span></a>
                </li>
                <li class="stat">
                    <a href="/web/stat/index"><i class="fa fa-bar-chart fa-lg"></i> <span class="nav-label">统计管理</span></a>
                </li>
			</ul>

		</div>
	</nav>

	<div id="page-wrapper" class="gray-bg" style="background-color: #ffffff;">
		<div class="row border-bottom">
			<nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
				<div class="navbar-header">
					<a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="javascript:void(0);"><i class="fa fa-bars"></i> </a>

				</div>
				<ul class="nav navbar-top-links navbar-right">
					<li>
						<span class="m-r-sm text-muted welcome-message">
                            欢迎使用编程浪子图书商城管理后台
                        </span>
					</li>
					<li class="hidden">
						<a class="count-info" href="javascript:void(0);">
							<i class="fa fa-bell"></i>
                            <span class="label label-primary">8</span>
						</a>
					</li>


					<li class="dropdown user_info">
						<a  class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);">
                            <img alt="image" class="img-circle" src="/images/web/avatar.png" />
						</a>
                        <ul class="dropdown-menu dropdown-messages">
                            <li>
                                <div class="dropdown-messages-box">
                                   姓名：编程浪子郭大爷                                    <a href="/web/user/edit" class="pull-right">编辑</a>
                                </div>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <div class="dropdown-messages-box">
                                   手机号码：11012345679                                </div>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <div class="link-block text-center">
                                    <a class="pull-left" href="/web/user/reset-pwd">
                                        <i class="fa fa-lock"></i> 修改密码
                                    </a>
                                    <a class="pull-right" href="/web/user/logout">
                                        <i class="fa fa-sign-out"></i> 退出
                                    </a>
                                </div>
                            </li>
                        </ul>
					</li>

				</ul>

			</nav>
		</div>
		<div class="row  border-bottom">
	<div class="col-lg-12">
		<div class="tab_title">
			<ul class="nav nav-pills">
								<li  class="current"  >
					<a href="/web/finance/index">订单列表</a>
				</li>
								<li  >
					<a href="/web/finance/account">财务流水</a>
				</li>
							</ul>
		</div>
	</div>
</div><div class="row m-t wrap_info">
	<div class="col-lg-12">
		<div class="row">
			<div class="col-lg-12">
								<div class="m-b-md">
					<h2>订单信息</h2>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<p class="m-t">订单编号：2017031732</p>
				<p>会员姓名：郭威</p>
				<p>会员手机：1231231312</p>
				<p>订单总价：179.30</p>
				<p>订单状态：已关闭</p>
								<p>创建时间：2017-03-17 14:57</p>
                <p>收货地址：浙江省宁波市330203太阳出来了爬山平（郭威）13774355081</p>
			</div>
		</div>
		<div class="row m-t">
			<div class="col-lg-12">
				<div class="panel blank-panel">
					<div class="panel-heading">
						<div class="panel-options">
							<ul class="nav nav-tabs">
								<li class="active">
									<a href="#tab-1" data-toggle="tab" aria-expanded="false">订单商品</a>
								</li>
							</ul>
						</div>
					</div>

					<div class="panel-body">
						<div class="tab-content">
							<div class="tab-pane active" id="tab-1">
								<table class="table table-striped">
									<thead>
									<tr>
										<th>商品</th>
										<th>数量</th>
										<th>金额</th>
									</tr>
									</thead>
									<tbody>
																			<tr>
											<td>Hadoop权威指南(第3版)</td>
											<td>1</td>
											<td>78.20</td>
										</tr>
																			<tr>
											<td>高性能MySQL（第3版）</td>
											<td>1</td>
											<td>101.10</td>
										</tr>
																		</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="express_wrap" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">确认发货</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-horizontal m-t m-b">
                            <div class="form-group">
                                <label class="col-lg-2 control-label">发货信息:</label>
                                <div class="col-lg-10">
                                    <label class="control-label">浙江省宁波市330203太阳出来了爬山平（郭威）13774355081</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">快递信息:</label>
                                <div class="col-lg-10">
                                    <input type="text" name="express_info" class="form-control" placeholder="请输入快递信息，例如圆通快递 VIP123123~~" value="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <input type="hidden" name="pay_order_id" value="32">
                <button type="button" class="btn btn-primary save">保存</button>
            </div>
        </div>
    </div>
</div>
	</div>
</div>
</body>
</html>
