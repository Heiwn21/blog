<?php
class Psr4Autoloader {
	public $namespaces = [];      //命名空间与文件夹对照表

	public function __construct(array $config = null) {
		if (empty($config)) {
			$this->namespaces = include 'config/namespace.php';
		} else {
			$this->namespaces = $config;
		}

		//注册自己的自动加载方法
		spl_autoload_register([$this,'loadClass']);
	}

	public function loadClass ($calssName) {
		$arr = explode('\\',$calssName);

		//获取类名
		$realClass = array_pop($arr);

		//获取命名空间
		$nSpace = implode('\\',$arr);

		//加载相应的类文件
		$this->loadMap($nSpace,$realClass);
	}

	protected function loadMap($nSpace,$realClass) {
		if (array_key_exists($nSpace, $this->namespaces)) {
			$path = $this->namespaces[$nSpace];
		} else {
			$path = str_replace('\\', '/', $nSpace);
		}

		//拼接文件路径
		$path = rtrim($path,'/') . '/' . $realClass . '.php';

		if (file_exists($path)) {
			include $path;
		} else {
			exit("{$path}无法找到");
		}
	}

	public function addNameSpace($nameSpace,$realDir) {

		//去掉命名空间两边的反斜线
		$namespace = trim($namespace,'\\');

		//去掉目录的两边的正斜线
		$realDir = trim($realDir,'/');

		$this->namespaces[$namespace] = $realDir;
	}
}
