
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>注册</title>
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
	<script src="/public/css/index/user/jquery.min.js"></script>
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
					<form action="/index.php?m=index&c=user&a=doRegister" class="fh5co-form animate-box" data-animate-effect="fadeInLeft" method="post">
						<h2>注 册</h2>
						<div class="form-group">
							<label for="name" class="sr-only">Name</label>
							<input type="text" name="username" class="form-control" id="name" placeholder="用户名" autocomplete="off" required="true">
						</div>
						<div class="form-group">
							<label for="email" class="sr-only">Email</label>
							<input type="email" name="email" class="form-control" id="email" placeholder="邮箱" autocomplete="off" required="true">
						</div>
						<div class="form-group">
							<label for="password" class="sr-only">Password</label>
							<input type="password" name="password" class="form-control" id="password" placeholder="密码" autocomplete="off" required="true">
						</div>
						<div class="form-group">
							<label for="re-password" class="sr-only">Re-type Password</label>
							<input type="password" name="rePassword" class="form-control" id="re-password" placeholder="确认密码" autocomplete="off" required="true">
						</div>

						<!-- 手机验证码 -->
						<div class="form-group">
							<input type="text" name='phone' id='phone' placeholder="手机号">
							<input type="button" value='获取验证码' id='yzm'>
						</div>
						<div class="form-group">
							<label for="verifycode" class="sr-only">VerifyCode</label>
							<input type="tetx" name="verifyCode" class="form-control" id="verifycode" placeholder="验证码" autocomplete="off" required="true">
						</div>
							
						<!--图片验证码-->
						<!-- <div class="form-group">
							<img src='/index.php?m=index&c=user&a=yzm' onclick='show(this)'>
						</div> -->

						<div class="form-group">
							<p>已经注册过了? <a href="/index.php?m=index&c=user&a=login">登 录</a></p>
						</div>
						<div class="form-group">
							<input type="submit" name="submit" value="注 册" class="btn btn-primary">
						</div>
					</form>
					<!-- END Sign In Form -->
					
					<!--图片验证码-->
					<!-- <script>
						function show(obj) {
							obj.src='/index.php?m=index&c=user&a=yzm&'+Math.random();
						}
					</script> -->

					<!-- 手机验证码 -->
					<script>
						 $('#yzm').click(function(){
						 	
						 	var phone = $('#phone').val();
						 	console.log(phone);
						 	$.post('index.php?m=index&c=user&a=phoneSend',{phone:phone},function(data){
						 	    console.log(data);
						 	});
						 });
					</script>
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

