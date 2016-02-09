<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title>photo</title>
	<link rel="stylesheet" type="text/css" href="__PUBLIC__/CSS/default.css">
	<link rel="shortcut icon" href="__PUBLIC__/img/favicon.ico" type="image/x-icon">
    <link rel="icon" href="__PUBLIC__/img/favicon.ico" type="image/x-icon">
	<style type="text/css">
	/*.header {
		height: 60px; 
		margin-bottom: 20px; 
		margin-left: -15px;
		margin-right: -15px;
		border-bottom: 1px solid #1c5380;
		border-bottom-color: rgba(4, 40, 71, .8);
		background-color: #517fa4;
		box-shadow: 0 1px 0 rgba(111,151,182,.5)inset,0 -1px 0 rgba(111,151,182,.2)inset,0 1px 1px rgba(0,0,0,.2);
		background-image: url("//instagramstatic-a.akamaihd.net/bluebar/f688a03/images/shared/noise-1.png"),-webkit-linear-gradient(top,#517fa4,#306088);
		z-index: 100;
	}*/
	.top-bar-wrapper {
		position: relative;
		max-width: 1024px;
		margin: 0 auto;
	}
	.top-bar {
		position: fixed;
		width: 100%;
		height: 43px;
		border-bottom: 1px solid #1c5380;
		border-bottom-color: rgba(4, 40, 71, .8);
		box-shadow: 0 1px 0 rgba(111,151,182,.5)inset,0 -1px 0 rgba(111,151,182,.2)inset,0 1px 1px rgba(0,0,0,.2);
		background-color: #517fa4;
		background-image: url("http://nicksxs01.qiniudn.com/memory_noise-1.png"),-webkit-linear-gradient(top,#517fa4,#306088);
		background-position: 50% 50%;
		z-index: 100;
	}
	.top-bar-new .top-bar-left {
		left: -1px;
		position: absolute;
		top: 0;
	}
	.top-bar-left .top-bar-actions {
		float: left;
		display: inline;
	}
	.top-bar-actions {
		margin: 0;
		padding: 0;
		border-right: 1px solid #5786aa;
		border-right-color: rgba(255, 255, 255, .1);
		border-left: 1px solid #06365f;
		border-left-color: rgba(0, 0, 0, .1);
	}
	ul {
		list-style-type: square;
	}
	ol, ul {
		list-style-position: outside;
	}
	.top-bar-actions>li {
		position: relative;
		float: left;
		display: inline;
		margin: 0;
	}
	.top-bar-actions>li>a{
		position: relative;
		display: block;     // !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
	}
	.top-bar-actions>li>a:active, .top-bar-actions>li>a.link-active, .top-bar-actions>li>a.pressed {
		border-left: none;
		background-color: rgba(6, 54, 95, .35);
		box-shadow: -1px 0 0 rgba(255,255,255,.15),inset 0 0 1px rgba(6,54,95,.4),inset 1px 0 1px rgba(6,54,95,.4);
	}
	.top-bar-home i {
		position: absolute;
		left: 0;
		top: 0;
		margin: 0!important;
		background: url("http://nicksxs01.qiniudn.com/memory_shared-assets.png") no-repeat 6px -194px;
	}
	.top-bar-home, .top-bar-home i {
		height: 44px!important;
		width: 44px!important;
	}
	a {
		color: rgb(51, 122, 183);
		text-decoration: none;
		background-color: transparent;
	}
	</style>
</head>
<body style="background: #78C5F9;">
	
		<!-- <strong>Hello World</strong>
		<a href="__URL__/origin">origin</a> -->
		<!-- <div class="row" style="margin-top: 0px"> -->
		<!-- <div class="header"> -->
		<header class="top-bar top-bar-new">
			<div class="top-bar-wrapper">
				<div class="logo">
					<a href="__APP__">Amber</a>
				</div>
				<div class="top-bar-left">
					<ul class="top-bar-actions">
						<li>
							<a class="link-active top-bar-home" title="首页" href="__APP__"><i></i></a>
						</li>
					</ul>
				</div>
			</div>
			<!--<p class="text-center" style="font-size: 36px">Show your photo and feelings</p>-->
		</header>
	<div class="container-fluid">		
		<!-- </div> -->
		<!-- </div> -->
		<div class="login">
		<?php if($signup == 0): ?><!-- <div class="row">
			<div class="col-md-4"></div>
			<div class="col-md-4 login-man" style="margin-top: 20px; border: 1px solid #042845; padding-top: 20px">
				<form class="form-horizontal" action="__URL__/index" method="post">
					<div class="form-group">
						<label for="inputUsername" class="col-sm-3 control-label">用户名</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="username" id="inputUsername" placeholder="Username" value="<?php echo ($try_login_name); ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="inputPassword" class="col-sm-3 control-label">密　码</label>
						<div class="col-sm-9">
							<input type="password" class="form-control" name="password" id="inputPassword" placeholder="Password">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-1 col-sm-8">
							<a href="">忘记密码</a>
						</div>
						<div class="col-sm-3">
							<button type="submit" class="btn btn-default">Sign in</button>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-1 col-sm-4">
							<a href="__URL__/signup">新用户注册</a>
						</div>
						<div class="col-sm-7"></div>
					</div>
				</form>
				<div class="err_msg">
						<p class="text-center"><?php echo ($error_message); ?></p>
				</div>
			</div>
			<div class="col-md-4"></div> -->
			<form class="account" id="formSignin" action="__URL__/index" method="post">
    			<div class="form-group">
    			  <input type="text" class="form-control input-lg" name="username" placeholder="用户名" value="<?php echo ($try_login_name); ?>">
    			</div>
    			<div class="form-group">
    			  <input type="password" class="form-control input-lg" name="password" placeholder="密码">
    			</div>
    			<button class="btn btn-lg" type="submit" data-loading-text="数据提交中...">登录</button>
    			<p class="account-footer">
    			  没有账号？<a href="__URL__/signup">创建一个账号</a>
    			</p>
    			<p class="text-center"><?php echo ($error_message); ?></p>
			</form>
		<?php else: ?>
			<form class="account" id="formSignup" action="__URL__/signup" method="post">
    			<div class="form-group">
      				<input type="text" class="form-control input-lg" name="username" placeholder="用户名" value="<?php echo ($try_login_name); ?>">
    			</div>
    			<div class="form-group">
      				<input type="text" class="form-control input-lg" name="email" placeholder="电子邮件地址">
    			</div>
    			<div class="form-group">
      				<input type="password" class="form-control input-lg" name="password" placeholder="密码">
    			</div>
    			<button class="btn btn-lg" type="submit" data-loading-text="数据提交中...">注册</button>
    			<p class="account-footer">
      				已有账号？<a href="__URL__/index">立即登录</a>
    			</p>
    			<p class="text-center"><?php echo ($error_message); ?></p>
  			</form><?php endif; ?>
		</div>
	</div>
	</div>
	
    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">
    <script src="//cdn.bootcss.com/bootstrap/3.3.2/css/bootstrap.min.css"></script>
    <script src="//cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script> 
</body>
</html>