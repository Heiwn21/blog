<?php
namespace admin\controller;
use admin\controller\BaseController;
use admin\model\Reply;
use vendor\me\framework\Page;

class Book extends BaseController{
	protected $page;
	protected $totalCounts;
	protected $reply;

	public function sonInit() {
		$this->reply = new Reply();
	}

	public function showReply() {
		//获取总的回复数
 		$this->totalCounts = $this->reply->getCount();

 		//分页
 		$page = new Page($this->totalCounts,8);
 		$limit = $page->limit();
 		$allPages = $page->allPage();

 		//所有的评论
		$reply = $this->reply->replyInfo($limit);

		//分配变量
		$this->assign('data',$reply);
		$this->assign('allPages',$allPages);
		$this->assign('totalCounts',$this->totalCounts);

		$this->display();
	}

 	public function del () {
 		if (empty($_POST['rid'])) {
 			$this->notice(0,'请选择需要删除的评论','/index.php?m=admin&c=book&a=showReply');
			exit;
 		}
 		$rid = $_POST['rid'];
 		foreach ($rid as $value) {
 			$this->reply->where("rid=$value")
 						->deleteSome();
 		}
 		$this->notice(1,'删除成功','/index.php?m=admin&c=book&a=showReply');
		exit;
 	}

 	public function isDisplay() {
 		$rid = $_REQUEST['rid'];
 		$dis = $_REQUEST['dis'];
 		$this->reply->Dis($rid,$dis);
 		$this->notice(1,'修改成功','/index.php?m=admin&c=book&a=showReply');
		exit;
 	}
	
}