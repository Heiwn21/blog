<?php
namespace admin\controller;
use admin\controller\BaseController;
use admin\model\Details;
use admin\model\Category;
use vendor\me\framework\Upload;

class Add extends BaseController{
	protected $details;
	protected $up;
	protected $category;
	protected $rootPath;

	public function sonInit() {
		$this->details = new Details();
		$this->category = new Category();

		$this->rootPath = include 'config/rootpath.php';
		$path = $this->rootPath['WEB_SITE'] . 'public/upload/images/wenZhangPicture';
		$this->up = new Upload(['uploadDir'=>$path]);
	}

	public function add() {
		//所有板块
 		$allCategory = $this->category->getAllCategory();
 		$this->assign('allCategory',$allCategory);

		$this->display();
	}

	public function doAdd() {
 		$title = $_POST['title'];
 		$cid = $_POST['cid'];
 		$contents = $_POST['contents'];

 		//判断标题与内容是否为空
 		if (empty(trim($title)) || empty(trim($contents)) || empty($cid)) {
 			$this->notice(0,'标题或内容或板块不能为空！请重新输入',"/index.php?m=admin&c=add&a=add");
			exit;
 		}

 		//获得头像上传后的地址
		$headerPath = $this->up->upload('header');
		$path = '/' . ltrim($headerPath,$this->rootPath['WEB_SITE']);

		if (empty($headerPath)) {
			$data = ['title'=>$title,'contents'=>$contents,'cid'=>$cid,'publishtime'=>time()];
		} else {
			$data = ['title'=>$title,'contents'=>$contents,'picture'=>$path,'cid'=>$cid,'publishtime'=>time()];
		}

		$this->details->insertDetails($data);

		$this->notice(1,'发表成功',"/index.php?m=admin&c=lists&a=detailsList");
		exit;	
 	}
	
}