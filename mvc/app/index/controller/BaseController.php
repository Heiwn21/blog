<?php
namespace index\controller;
use vendor\me\framework\Template;

class BaseController extends Template {

	public function __construct() {
		parent::__construct('app/index/view','cache/index');

		//子类初始化
		$this->sonInit();

		//博客的基本信息
		$config = include 'config/blogInfo.php';
		$this->assign('config',$config);
	}

	public function sonInit() {

	}

	public function display ($tplFile = null,$isExtracted = true) {

		//标准--一个方法对应一个页面
		if (empty($tplFile)) {
			//获取方法名
			$a = empty($_GET['a'])?'index':$_GET['a'];

			//获取控制器名
			$c = empty($_GET['c'])?'index':strtolower($_GET['c']);

			//一个控制器的对应view中的一个文件夹
			$tplFile = $c . '/' . $a . '.html';
		}

		parent::display($tplFile,$isExtracted);
	}

	public function notice($code,$msg,$url,$wait=3) {
		$this->assign(['code'=>$code,'msg'=>$msg,'url'=>$url,'wait'=>$wait]);
		$this->display('notice.html');
	}
}