<?php

include "boot/Psr4Autoloader.php";

class Router
{
	public static $autoload;

	//全局性的初始化
	public static function init() {
		$config = include 'config/namespace.php';

		//实例化自动加载
		self::$autoload = new Psr4Autoloader($config);

		session_start();
		error_reporting(0);
	}

	//路由
	public static function run () {
		//路由规则
		$m = empty($_GET['m'])?'index':strtolower($_GET['m']);
		$a = empty($_GET['a'])?'index':$_GET['a'];
		$c = empty($_GET['c'])?'Index':ucfirst($_GET['c']);

		$c= $m . '\\controller\\' . $c;

		call_user_func([new $c,$a]);
	}
}

//进行全局的初始化
Router::init();
