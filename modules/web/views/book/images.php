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
								<li  >
					<a href="/web/book/index">图书列表</a>
				</li>
								<li  >
					<a href="/web/book/cat">分类列表</a>
				</li>
								<li  class="current"  >
					<a href="/web/book/images">图片资源</a>
				</li>
							</ul>
		</div>
	</div>
</div><div class="row">
	<div class="col-lg-12">
		<table class="table table-bordered m-t">
			<thead>
			<tr>
				<th>图片</th>
				<th>图片地址</th>
			</tr>
			</thead>
			<tbody>
												<tr>
						<td>
							<img src="/uploads/book/20170316/7ea0e8a34deb666126567740be220c9e.jpg" style="width: 100px;height: 100px;"/>
						</td>
						<td>
							<a href="/uploads/book/20170316/7ea0e8a34deb666126567740be220c9e.jpg" target="_blank">查看大图</a>
						</td>
					</tr>
									<tr>
						<td>
							<img src="/uploads/book/20170316/d7330817f6279b882d57157ebeec7816.jpg" style="width: 100px;height: 100px;"/>
						</td>
						<td>
							<a href="/uploads/book/20170316/d7330817f6279b882d57157ebeec7816.jpg" target="_blank">查看大图</a>
						</td>
					</tr>
									<tr>
						<td>
							<img src="/uploads/book/20170316/8de1c9f5fccb1321e5d1bcc1f4689674.jpg" style="width: 100px;height: 100px;"/>
						</td>
						<td>
							<a href="/uploads/book/20170316/8de1c9f5fccb1321e5d1bcc1f4689674.jpg" target="_blank">查看大图</a>
						</td>
					</tr>
									<tr>
						<td>
							<img src="/uploads/book/20170316/577fcac5eb54a401e3dfa659b6e5fe5f.jpg" style="width: 100px;height: 100px;"/>
						</td>
						<td>
							<a href="/uploads/book/20170316/577fcac5eb54a401e3dfa659b6e5fe5f.jpg" target="_blank">查看大图</a>
						</td>
					</tr>
									<tr>
						<td>
							<img src="/uploads/book/20170303/fe3545ecaef7e24a302231f5635713af.jpg" style="width: 100px;height: 100px;"/>
						</td>
						<td>
							<a href="/uploads/book/20170303/fe3545ecaef7e24a302231f5635713af.jpg" target="_blank">查看大图</a>
						</td>
					</tr>
									<tr>
						<td>
							<img src="/uploads/book/20170303/a8887738ab1bfd71765dd063fee4ddaa.jpg" style="width: 100px;height: 100px;"/>
						</td>
						<td>
							<a href="/uploads/book/20170303/a8887738ab1bfd71765dd063fee4ddaa.jpg" target="_blank">查看大图</a>
						</td>
					</tr>
									<tr>
						<td>
							<img src="/uploads/book/20170301/7a976289c2c1f551a4f21232575ba255.jpg" style="width: 100px;height: 100px;"/>
						</td>
						<td>
							<a href="/uploads/book/20170301/7a976289c2c1f551a4f21232575ba255.jpg" target="_blank">查看大图</a>
						</td>
					</tr>
									<tr>
						<td>
							<img src="/uploads/book/20170301/dd8688e4135c756ff6da6a5edfcb74ec.jpg" style="width: 100px;height: 100px;"/>
						</td>
						<td>
							<a href="/uploads/book/20170301/dd8688e4135c756ff6da6a5edfcb74ec.jpg" target="_blank">查看大图</a>
						</td>
					</tr>
									<tr>
						<td>
							<img src="/uploads/book/20170301/fe3545ecaef7e24a302231f5635713af.jpg" style="width: 100px;height: 100px;"/>
						</td>
						<td>
							<a href="/uploads/book/20170301/fe3545ecaef7e24a302231f5635713af.jpg" target="_blank">查看大图</a>
						</td>
					</tr>
									<tr>
						<td>
							<img src="/uploads/book/20170301/fe3545ecaef7e24a302231f5635713af.jpg" style="width: 100px;height: 100px;"/>
						</td>
						<td>
							<a href="/uploads/book/20170301/fe3545ecaef7e24a302231f5635713af.jpg" target="_blank">查看大图</a>
						</td>
					</tr>
									<tr>
						<td>
							<img src="/uploads/book/20170301/fe3545ecaef7e24a302231f5635713af.jpg" style="width: 100px;height: 100px;"/>
						</td>
						<td>
							<a href="/uploads/book/20170301/fe3545ecaef7e24a302231f5635713af.jpg" target="_blank">查看大图</a>
						</td>
					</tr>
									<tr>
						<td>
							<img src="/uploads/book/20170301/1451ab22b16175889efffa21ec41b824.jpg" style="width: 100px;height: 100px;"/>
						</td>
						<td>
							<a href="/uploads/book/20170301/1451ab22b16175889efffa21ec41b824.jpg" target="_blank">查看大图</a>
						</td>
					</tr>
									<tr>
						<td>
							<img src="/uploads/book/20170301/1451ab22b16175889efffa21ec41b824.jpg" style="width: 100px;height: 100px;"/>
						</td>
						<td>
							<a href="/uploads/book/20170301/1451ab22b16175889efffa21ec41b824.jpg" target="_blank">查看大图</a>
						</td>
					</tr>
									<tr>
						<td>
							<img src="/uploads/book/20170301/fe3545ecaef7e24a302231f5635713af.jpg" style="width: 100px;height: 100px;"/>
						</td>
						<td>
							<a href="/uploads/book/20170301/fe3545ecaef7e24a302231f5635713af.jpg" target="_blank">查看大图</a>
						</td>
					</tr>
									<tr>
						<td>
							<img src="/uploads/book/20170301/fe3545ecaef7e24a302231f5635713af.jpg" style="width: 100px;height: 100px;"/>
						</td>
						<td>
							<a href="/uploads/book/20170301/fe3545ecaef7e24a302231f5635713af.jpg" target="_blank">查看大图</a>
						</td>
					</tr>
									<tr>
						<td>
							<img src="/uploads/book/20170301/e9a3909b1c2db975d1b3c21c249c684e.jpg" style="width: 100px;height: 100px;"/>
						</td>
						<td>
							<a href="/uploads/book/20170301/e9a3909b1c2db975d1b3c21c249c684e.jpg" target="_blank">查看大图</a>
						</td>
					</tr>
									<tr>
						<td>
							<img src="/uploads/book/20170301/9ff354fe52dc26f672d7f94a58f6a2f4.jpg" style="width: 100px;height: 100px;"/>
						</td>
						<td>
							<a href="/uploads/book/20170301/9ff354fe52dc26f672d7f94a58f6a2f4.jpg" target="_blank">查看大图</a>
						</td>
					</tr>
										</tbody>
		</table>
		<div class="row">
	<div class="col-lg-12">
		<span class="pagination_count" style="line-height: 40px;">共17条记录 | 每页50条</span>
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
