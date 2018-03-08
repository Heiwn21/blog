
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>登录</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Free HTML5 Template by FreeHTML5.co" />
	<meta name="keywords" content="free html5, free template, free bootstrap, html5, css3, mobile first, responsive" />
	

  

  	<!-- Facebook and Twitter integration -->
	<meta property="og:title" content=""/>
	<meta property="og:image" content=""/>
	<meta property="og:url" content=""/>
	<meta property="og:site_name" content=""/>
	<meta property="og:description" content=""/>
	<meta name="twitter:title" content="" />
	<meta name="twitter:image" content="" />
	<meta name="twitter:url" content="" />
	<meta name="twitter:card" content="" />

	<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
	<link rel="shortcut icon" href="favicon.ico">

	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700,300' rel='stylesheet' type='text/css'>
	
	<link rel="stylesheet" href="/public/css/index/user/css/bootstrap.min.css">
	<link rel="stylesheet" href="/public/css/index/user/css/animate.css">
	<link rel="stylesheet" href="/public/css/index/user/css/style.css">


	<!-- Modernizr JS -->
	<script src="js/modernizr-2.6.2.min.js"></script>
	<!-- FOR IE9 below -->
	<!--[if lt IE 9]>
	<script src="js/respond.min.js"></script>
	<![endif]-->

	</head>
	<body class="style-2">

		<div class="container">
			<div class="row">
				<div class="col-md-4">
					

					<!-- Start Sign In Form -->
					<form action="index.php?m=index&c=user&a=doLogin" class="fh5co-form animate-box" data-animate-effect="fadeInLeft" method="post">
						<h2>登 录</h2>
						<div class="form-group">
							<label for="username" class="sr-only">用户名</label>
							<input type="text" name="username" class="form-control" id="username" placeholder="用户名" autocomplete="off" required="true">
						</div>
						<div class="form-group">
							<label for="password" class="sr-only">密 码</label>
							<input type="password" name="password" class="form-control" id="password" placeholder="密码" autocomplete="off" required="true">
						</div>
						<div class="form-group">
							<label for="remember">
							<input type="checkbox" id="remember"> 记住用户名</label>
						</div>
						<div class="form-group">
							<p>还没有注册吗? <a href="/index.php?m=index&c=user&a=register">注册</a> | <a href="index.php?m=index&c=user&a=forgot">忘记密码?</a></p>
						</div>
						<div class="form-group">
							<input type="submit" name='submit' value="登 录" class="btn btn-primary">
						</div>
					</form>
					<!-- END Sign In Form -->

				</div>
			</div>
			<div class="row" style="padding-top: 60px; clear: both;">
				<div class="col-md-12 text-center"><p><small> Copyright ©  &nbsp;&nbsp;&nbsp;<?php echo date('Y');?>&nbsp;&nbsp;&nbsp; 网站：<a href="<?=$config['blogWeb'];?>" title="网页模板" target="_blank"><?=$config['blogName'];?></a>| QQ : <?=$config['qq'];?> | Email : <?=$config['email'];?></small></p></div>
			</div>
		</div>
	
	<!-- jQuery -->
	<script src="js/jquery.min.js"></script>
	<!-- Bootstrap -->
	<script src="js/bootstrap.min.js"></script>
	<!-- Placeholder -->
	<script src="js/jquery.placeholder.min.js"></script>
	<!-- Waypoints -->
	<script src="js/jquery.waypoints.min.js"></script>
	<!-- Main JS -->
	<script src="js/main.js"></script>

	</body>
</html>

