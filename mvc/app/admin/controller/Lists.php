<?php
namespace admin\controller;
use admin\controller\BaseController;
use admin\model\Details;
use admin\model\Reply;
use vendor\me\framework\Page;
use admin\model\Category;
use vendor\me\framework\Upload;

class Lists extends BaseController{
	protected $details;
	protected $page;
	protected $category;
	protected $up;
	protected $rootPath;
	protected $reply;

	public function sonInit () {
		$this->details = new Details();
		$this->category = new Category();
		$this->reply = new Reply();
		
		$this->rootPath = include 'config/rootpath.php';
		$path = $this->rootPath['WEB_SITE'] . 'public/upload/images/wenZhangPicture';
		$this->up = new Upload(['uploadDir'=>$path]);
	}

	public function detailsList() {

		//获取需要展示板块cid
 		$cid = $this->getCid();
 		$_SESSION['adminCid'] = $cid;
		//获取需要展示的总的文章数
 		$totalCounts = $this->details->getCount($cid);

 		//分页
 		$page = new Page($totalCounts,4);
 		$limit = $page->limit();
 		$allPages = $page->allPage();

 		//所展示的文章
 		$data = $this->details->getDetailsInfo($limit,$cid);

 		//所有板块
 		$allCategory = $this->category->getAllCategory();

 		//分配变量
 		$this->assign('data',$data);
 		$this->assign('allPages',$allPages);
 		$this->assign('allCategory',$allCategory);
 		$this->assign('totalCounts',$totalCounts);
 		
 		//如果填写模板文件名，请带上目录
 		$this->display();
	}

	public function getCid() {
 		if (empty($_GET['cid'])) {
 			return null;
 		} else {
 			return $_GET['cid'];
 		}
 	}

 	public function isTop () {
 		$id = $_REQUEST['id'];
 		$this->details->notTop();
 		$this->details->Top($id);
 		$this->notice(1,'置顶成功','/index.php?m=admin&c=lists&a=detailsList');
		exit;	
 	}

 	public function del () {
 		if (empty($_POST['id'])) {
 			$this->notice(0,'请选择需要删除的文章','/index.php?m=admin&c=lists&a=detailsList');
			exit;
 		}
 		$id = $_POST['id'];
 		foreach ($id as $value) {
 			$this->details->where("id=$value")
 						  ->deleteSome();
 			$this->reply->where("tid=$value")
 						->deleteSome();
 		}
 		$this->notice(1,'删除成功','/index.php?m=admin&c=lists&a=detailsList');
		exit;
 	}

 	public function isDisplay() {
 		$id = $_REQUEST['id'];
 		$dis = $_REQUEST['dis'];
 		$this->details->Dis($id,$dis);
 		$this->notice(1,'修改成功','/index.php?m=admin&c=lists&a=detailsList');
		exit;
 	}

 	public function edit () {
 		$id = $_REQUEST['id'];
 		$data = $this->details->allInfo($id);
 		$allCategory = $this->category->getAllCategory();
 		$this->assign('data',$data);
 		$this->assign('allCategory',$allCategory);
 		$this->display();
 	}

 	public function doEdit() {
 		$id = $_REQUEST['id'];
 		$title = $_POST['title'];
 		$cid = $_REQUEST['cid'];
 		$contents = $_POST['contents'];

 		//判断标题与内容是否为空
 		if (empty(trim($title)) || empty(trim($contents))) {
 			$this->notice(0,'标题或内容不能为空！请重新输入',"/index.php?m=admin&c=lists&a=edit&id=$id");
			exit;
 		}

 		//获得头像上传后的地址
		$headerPath = $this->up->upload('header');
		$path = '/' . ltrim($headerPath,$this->rootPath['WEB_SITE']);

		//更新文章
		if (empty($cid) && empty($headerPath)) {
			$data = ['title'=>$title,'contents'=>$contents,'istmp'=>0,'publishtime'=>time()];
			$this->details->updateWenZhang($data,$id);
		} else if (empty($cid)) {
			$data = ['title'=>$title,'contents'=>$contents,'istmp'=>0,'publishtime'=>time(),'picture'=>$path];
			$this->details->updateWenZhang($data,$id);
		} else if (empty($headerPath)) {
			$data = ['title'=>$title,'contents'=>$contents,'istmp'=>0,'publishtime'=>time(),'cid'=>$cid];
			$this->details->updateWenZhang($data,$id);
		} else {
			$data = ['title'=>$title,'contents'=>$contents,'istmp'=>0,'publishtime'=>time(),'picture'=>$path,'cid'=>$cid];
			$this->details->updateWenZhang($data,$id);
		}

		$this->notice(1,'修改成功',"/index.php?m=admin&c=lists&a=edit&id=$id");
		exit;	
 	}
	
}