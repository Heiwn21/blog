<?php
namespace admin\controller;
use admin\controller\BaseController;
use admin\model\Details;
use vendor\me\framework\Page;
use vendor\me\framework\Upload;

class Caogao extends BaseController{
	protected $details;
	protected $page;
	protected $up;
	protected $rootPath;

	public function sonInit () {
		$this->details = new Details();
		
		$this->rootPath = include 'config/rootpath.php';
		$path = $this->rootPath['WEB_SITE'] . 'public/upload/images/wenZhangPicture';
		$this->up = new Upload(['uploadDir'=>$path]);
	}

	public function detailsList() {

		//获取草稿的总的文章数
 		$totalCounts = $this->details->getTmpCount();

 		//分页
 		$page = new Page($totalCounts,4);
 		$limit = $page->limit();
 		$allPages = $page->allPage();

 		//所展示的文章
 		$data = $this->details->getTmpDetailsInfo($limit);

 		//分配变量
 		$this->assign('data',$data);
 		$this->assign('allPages',$allPages);
 		$this->assign('totalCounts',$totalCounts);
 		
 		//如果填写模板文件名，请带上目录
 		$this->display();
	}

 	public function del () {
 		if (empty($_POST['id'])) {
 			$this->notice(0,'请选择需要删除的文章','/index.php?m=admin&c=caogao&a=detailsList');
			exit;
 		}
 		$id = $_POST['id'];
 		foreach ($id as $value) {
 			$this->details->where("id=$value")
 						  ->deleteSome();
 		}
 		$this->notice(1,'删除成功','/index.php?m=admin&c=caogao&a=detailsList');
		exit;
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

		//判断是否选择了图片
		if (empty($headerPath)) {
			$data = ['title'=>$title,'contents'=>$contents,'cid'=>$cid,'publishtime'=>time(),'istmp'=>1];
		} else {
			$data = ['title'=>$title,'contents'=>$contents,'picture'=>$path,'cid'=>$cid,'publishtime'=>time(),'istmp'=>1];
		}
	
		$this->details->insertDetails($data);

		$this->notice(1,'已存入草稿箱',"/index.php?m=admin&c=caogao&a=detailsList");
		exit;	
 	}
	
}