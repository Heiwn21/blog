<?php
namespace admin\controller;
use vendor\me\framework\Template;

class BaseController extends Template {

	public function __construct() {
		parent::__construct('app/admin/view','cache/admin');

		//子类初始化
		$this->sonInit();

		//防跳墙检测
		if (empty($_SESSION['flage']) || $_SESSION['flage']==0) {
			$this->notice(0,'你不是博主，无权进入后台','/index.php');
			exit;
		}
	}

	public function sonInit() {

	}

	public function display ($tplFile = null,$isExtracted = true) {

		//标准--一个方法对应一个页面
		if (empty($tplFile)) {
			//获取方法名
			$a = empty($_GET['a'])?'admin':$_GET['a'];

			//获取控制器名
			$c = empty($_GET['c'])?'admin':strtolower($_GET['c']);

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