<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<!-- Set render engine for 360 browser -->
	<meta name="renderer" content="webkit">
	<title>编程浪子微信图书商城</title>
	<link href="/font-awesome/css/font-awesome.css" rel="stylesheet">
<link href="/css/m/css_style.css" rel="stylesheet">
<link href="/css/m/app.css?ver=20170401" rel="stylesheet"></head>
<body>
<div style="min-height: 500px;">
	<div class="page_title clearfix">
	<span>账号绑定</span>
</div>
<div class="login_form_wrap">
    <div class="form_box">
        <div class="form_input_box">
            <span class="fa fa-mobile fa-2x"></span>
            <input name="mobile" type="text" placeholder="请输入手机号码" class="form_input" value="" />
        </div>
        <div class="form_input_box captcha_code">
            <input name="img_captcha" type="text" placeholder="请输入图形验证码" value="" class="form_input" />
            <img src="/default/img_captcha" onclick="this.src='/default/img_captcha?'+Math.random();"/>
        </div>
        <div class="form_input_box phone_code">
            <span class="fa fa-lock fa-2x"></span>
            <input name="captcha_code" type="text" placeholder="请输入手机验证码" class="form_input" />
            <button type="button" class="get_captcha">获取验证码</button>
        </div>
    </div>
    <div class="op_box">
        <input style="width: 100%;" type="button" value="绑定" class="red_btn dologin"  />
    </div>
</div>
</div>
<div class="copyright clearfix">
	        <p class="name">欢迎您，郭威</p>
	    <p class="copyright">由<a href="/" target="_blank">编程浪子</a>提供技术支持</p>
</div>
<div class="footer_fixed clearfix">
	<span><a href="/m/" class="default"><i class="home_icon"></i><b>首页</b></a></span>
	<span><a href="/m/product/index" class="product"><i class="store_icon"></i><b>图书</b></a></span>
	<span><a href="/m/user/index" class="user"><i class="member_icon"></i><b>我的</b></a></span>
</div>

</body>
</html>
