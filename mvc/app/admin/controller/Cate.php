<?php
namespace admin\controller;
use admin\controller\BaseController;
use admin\model\Category;

class Cate extends BaseController{
	protected $category;

	public function sonInit() {
		$this->category = new Category();
	}

	public function showCate() {
		$data = $this->category->getAllCategory();
		$this->assign('data',$data);
		$this->display();
	}

	public function cateedit() {
		$cid = $_GET['cid'];
		$data = $this->category->getCategory($cid);
		$this->assign('data',$data);
		$this->display();
	} 

	public function doEdit() {
		$cid = $_POST['cid'];
		$name = $_POST['name'];
		$orderby = $_POST['orderby'];

		if (empty(trim($name))) {
			$this->notice(0,'板块名不能为空，请重新输入！','/index.php?m=admin&c=cate&a=cateedit&cid=$cid');
			exit;
		}

		$data = ['name'=>$name,'orderby'=>$orderby];
		$this->category->editCategory($data,$cid);

		$this->notice(1,'修改成功','/index.php?m=admin&c=cate&a=showCate');
		exit;

	}

	public function doAdd () {
		$name = $_POST['name'];
		$orderby = $_POST['orderby'];

		if (empty(trim($name))) {
			$this->notice(0,'板块名不能为空，请重新输入！','/index.php?m=admin&c=cate&a=showCate');
			exit;
		}

		$data = ['name'=>$name,'orderby'=>$orderby];
		$this->category->addCate($data);

		$this->notice(1,'添加成功','/index.php?m=admin&c=cate&a=showCate');
		exit;
	}

	public function del () {
		$cid = $_GET['cid'];
		$this->category->where("cid=$cid")
					   ->deleteSome();
		$this->notice(1,'删除成功','/index.php?m=admin&c=cate&a=showCate');
		exit;
	}
	
}