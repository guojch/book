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
</div>
<div class="row">
	<div class="col-lg-12">
		<form class="form-inline wrap_search">
			<div class="row  m-t p-w-m">
				<div class="form-group">
					<select name="status" class="form-control inline">
						<option value="-1">请选择状态</option>
													<option value="1"  >已支付</option>
													<option value="-8"  >待支付</option>
													<option value="0"  >已关闭</option>
											</select>
				</div>
			</div>
		</form>
		<hr/>
		<table class="table table-bordered m-t">
			<thead>
			<tr>
				<th>订单编号</th>
				<th>名称</th>
				<th>价格</th>
				<th>支付时间</th>
				<th>状态</th>
				<th>创建时间</th>
				<th>操作</th>
			</tr>
			</thead>
			<tbody>
												<tr>
						<td>2017031732</td>
						<td>
															Hadoop权威指南(第3版) × 1<br/>
															高性能MySQL（第3版） × 1<br/>
													</td>
						<td>179.30</td>
						<td>
													</td>
						<td>已关闭</td>
						<td>2017-03-17 14:57</td>
						<td>
                            <a  href="/web/finance/pay_info?id=32">
                                <i class="fa fa-eye fa-lg"></i>
                            </a>
                        </td>
					</tr>
									<tr>
						<td>2017031231</td>
						<td>
															php开发教程 × 3<br/>
													</td>
						<td>135.00</td>
						<td>
														2017-03-12 22:28													</td>
						<td>已支付</td>
						<td>2017-03-12 19:45</td>
						<td>
                            <a  href="/web/finance/pay_info?id=31">
                                <i class="fa fa-eye fa-lg"></i>
                            </a>
                        </td>
					</tr>
									<tr>
						<td>2017031230</td>
						<td>
															php开发教程 × 3<br/>
													</td>
						<td>135.00</td>
						<td>
														2017-03-12 22:28													</td>
						<td>已支付</td>
						<td>2017-03-12 19:45</td>
						<td>
                            <a  href="/web/finance/pay_info?id=30">
                                <i class="fa fa-eye fa-lg"></i>
                            </a>
                        </td>
					</tr>
									<tr>
						<td>2017031229</td>
						<td>
															php开发教程 × 2<br/>
													</td>
						<td>90.00</td>
						<td>
													</td>
						<td>待支付</td>
						<td>2017-03-12 19:44</td>
						<td>
                            <a  href="/web/finance/pay_info?id=29">
                                <i class="fa fa-eye fa-lg"></i>
                            </a>
                        </td>
					</tr>
									<tr>
						<td>2017031228</td>
						<td>
															浪潮之巅 × 1<br/>
													</td>
						<td>88.88</td>
						<td>
														2017-03-12 15:51													</td>
						<td>已支付</td>
						<td>2017-03-12 15:24</td>
						<td>
                            <a  href="/web/finance/pay_info?id=28">
                                <i class="fa fa-eye fa-lg"></i>
                            </a>
                        </td>
					</tr>
									<tr>
						<td>2017031227</td>
						<td>
															浪潮之巅 × 1<br/>
													</td>
						<td>88.88</td>
						<td>
													</td>
						<td>已关闭</td>
						<td>2017-03-12 15:17</td>
						<td>
                            <a  href="/web/finance/pay_info?id=27">
                                <i class="fa fa-eye fa-lg"></i>
                            </a>
                        </td>
					</tr>
									<tr>
						<td>2017030726</td>
						<td>
															php开发教程 × 1<br/>
													</td>
						<td>45.00</td>
						<td>
													</td>
						<td>已关闭</td>
						<td>2017-03-07 18:16</td>
						<td>
                            <a  href="/web/finance/pay_info?id=26">
                                <i class="fa fa-eye fa-lg"></i>
                            </a>
                        </td>
					</tr>
									<tr>
						<td>2017030725</td>
						<td>
															php开发教程 × 1<br/>
													</td>
						<td>45.00</td>
						<td>
													</td>
						<td>已关闭</td>
						<td>2017-03-07 17:41</td>
						<td>
                            <a  href="/web/finance/pay_info?id=25">
                                <i class="fa fa-eye fa-lg"></i>
                            </a>
                        </td>
					</tr>
									<tr>
						<td>2017030724</td>
						<td>
															php开发教程 × 1<br/>
													</td>
						<td>45.00</td>
						<td>
													</td>
						<td>已关闭</td>
						<td>2017-03-07 17:41</td>
						<td>
                            <a  href="/web/finance/pay_info?id=24">
                                <i class="fa fa-eye fa-lg"></i>
                            </a>
                        </td>
					</tr>
									<tr>
						<td>2017030717</td>
						<td>
															php开发教程 × 1<br/>
													</td>
						<td>45.00</td>
						<td>
													</td>
						<td>已关闭</td>
						<td>2017-03-07 17:35</td>
						<td>
                            <a  href="/web/finance/pay_info?id=17">
                                <i class="fa fa-eye fa-lg"></i>
                            </a>
                        </td>
					</tr>
									<tr>
						<td>2017030716</td>
						<td>
															浪潮之巅 × 1<br/>
													</td>
						<td>88.88</td>
						<td>
													</td>
						<td>已关闭</td>
						<td>2017-03-07 17:34</td>
						<td>
                            <a  href="/web/finance/pay_info?id=16">
                                <i class="fa fa-eye fa-lg"></i>
                            </a>
                        </td>
					</tr>
									<tr>
						<td>2017030715</td>
						<td>
															浪潮之巅 × 1<br/>
													</td>
						<td>88.88</td>
						<td>
													</td>
						<td>已关闭</td>
						<td>2017-03-07 17:26</td>
						<td>
                            <a  href="/web/finance/pay_info?id=15">
                                <i class="fa fa-eye fa-lg"></i>
                            </a>
                        </td>
					</tr>
									<tr>
						<td>2017030614</td>
						<td>
															php开发教程 × 1<br/>
													</td>
						<td>45.00</td>
						<td>
													</td>
						<td>已关闭</td>
						<td>2017-03-06 08:39</td>
						<td>
                            <a  href="/web/finance/pay_info?id=14">
                                <i class="fa fa-eye fa-lg"></i>
                            </a>
                        </td>
					</tr>
									<tr>
						<td>2017030513</td>
						<td>
															浪潮之巅 × 1<br/>
													</td>
						<td>88.88</td>
						<td>
													</td>
						<td>已关闭</td>
						<td>2017-03-05 20:47</td>
						<td>
                            <a  href="/web/finance/pay_info?id=13">
                                <i class="fa fa-eye fa-lg"></i>
                            </a>
                        </td>
					</tr>
										</tbody>
		</table>
		<div class="row">
	<div class="col-lg-12">
		<span class="pagination_count" style="line-height: 40px;">共14条记录 | 每页50条</span>
		<ul class="pagination pagination-lg pull-right" style="margin: 0 0 ;">
										                    <li class="active"><a href="javascript:void(0);">1</a></li>
                            					</ul>
	</div>
</div>
	</div>
</div>

	</div>
</div>
</body>
</html>
