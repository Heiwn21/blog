<?php
namespace index\controller;
use index\controller\BaseController;
use index\model\Details as DetailsModel;
use vendor\me\framework\Page;
use index\model\Reply;
use index\model\Category;

class Details extends BaseController {
	public $id;
	public $details;
	public $totalCounts;
	public $reply;
	public $category;

	public function sonInit() {
		$this->id = $_REQUEST['id'];
		$this->details = new DetailsModel();
		$this->reply = new Reply();
		$this->category = new Category();
		
		//获取总的回复数
 		$this->totalCounts = $this->reply->getCount($this->id);
	}

	public function detailsInfo () {
		if (!empty($_GET['hit'])) {
			$this->details->updateHits($this->id);
		}

 		//分页
 		$page = new Page($this->totalCounts,4);
 		$limit = $page->limit();
 		$allPages = $page->allPage();

 		//所有板块
 		$allCategory = $this->category->getAllCategory();

 		//文章的内容
		$wenZhang = $this->details->allInfo($this->id);

		//回复的内容
		$reply = $this->reply->replyInfo($this->id,$limit);

		//所属于的板块
		$cid = $wenZhang['cid'];
		$category = $this->category->getCategory($cid);

		//分配变量
		$this->assign('wenZhang',$wenZhang);
		$this->assign('reply',$reply);
		$this->assign('allPages',$allPages);
		$this->assign('category',$category);
		$this->assign('allCategory',$allCategory);

		$this->display();
	}

	//发表评论
	public function doReply() {
		$reply = $_POST['replyContents'];

		//判断内容是否为空字符串
		if (empty(trim($reply))) {
			$this->notice(0,"评论内容不能为空哦！！",$_SERVER['HTTP_REFERER']);
			exit;
		}

		//写入数据库
		$re = $this->reply->insertReply($reply,$this->id);
		if ($re) {
			//更新details表中的回复数
			$this->details->updateReplyCounts($this->totalCounts+1,$this->id);

			$this->notice(1,"评论发表成功！！","index.php?m=index&c=details&a=detailsInfo&id=$this->id");
			exit;
		} else {
			$this->notice(0,"评论失败！！！","index.php?m=index&c=details&a=detailsInfo&id=$this->id");
			exit;
		}
	}

	//上一篇
	public function preDetails() {
		$arr = $this->getArray();
		$key = array_search($this->id, $arr);
		$key = ($key-1)>=0?($key-1):0;
		$preId =$arr[$key]; 
		echo "<meta http-equiv='refresh' content='0;url=/index.php?m=index&c=details&a=detailsInfo&id={$preId}&hit=1'>";
		exit;
	}

	//下一篇
	public function nextDetails() {
		$arr = $this->getArray();
		$key = array_search($this->id, $arr);
		$key = ($key+1)<=count($arr)-1?($key+1):count($arr)-1;
		$nextId =$arr[$key]; 
		echo "<meta http-equiv='refresh' content='0;url=/index.php?m=index&c=details&a=detailsInfo&id={$nextId}&hit=1'>";
		exit;
	}

	public function getArray() {
		$result = $this->details->getDetailsInfo(null,$_SESSION['cid']);
		$arr = [];
		foreach ($result as $key => $value) {
			$arr[$key] = $value['id'];
		}
		return $arr; 
	}
}