<?php 
 namespace index\controller;
 use index\controller\BaseController;
 use index\model\Details;
 use vendor\me\framework\Page;
 use index\model\Category;

 class Index extends BaseController {
 	protected $details;
 	protected $category;

 	public function sonInit() {
 		$this->details = new Details();
 		$this->category = new Category();
 	}

 	public function index () {
 		
 		//获取需要展示板块cid
 		$cid = $this->getCid();
 		$_SESSION['cid'] = $cid;
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

 	public function search() {
 		$keywords = $_REQUEST['keywords'];
 		if (empty(trim($keywords))) {
 			$this->notice(0,"关键字不能为空哦！！",'/index.php');
 			exit;
 		}

 		$keywords = trim($keywords);
 		$data = $this->details->getSearchId($keywords);

 		if (empty($data)) {
 			$this->assign('data',null);
 			$this->display();
 			exit;
 		}

 		//获取搜索到记录的总条数
 		$total = count($data);

 		//获取展示搜索结果的条件
 		$where = $this->getWhere($data);

 		//分页--
 		$page = new Page($total,4);
 		$limit = $page->limit();
 		$allPages = $page->allPage();

 		//获取所需展示的内容
 		$info = $this->details->getSearchInfo($limit,$where);

 		//分配变量
 		$this->assign('allPages',$allPages);
 		$this->assign('data',$info);
 		$this->assign('keywords',$keywords);
 		$this->assign('total',$total);
 		$this->display();
 	}

 	public function getWhere($data) {
 		//拼接查询条件
		$where = ' id in (';
		foreach ($data as $value) {
			$where .= $value['id'] . ',';
		}
		return rtrim($where,',') . ')' . ' ';
 	}
 }