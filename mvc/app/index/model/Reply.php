<?php
namespace index\model;
use index\model\BaseModel;

class Reply extends BaseModel {

	public function getCount($id)  {
		return $this->where("tid=$id")
			 ->count();
	}

	public function replyInfo($id,$limit) {

		$reply = $this->table('reply,user')
					  ->field('username,replytime,contents,picture,isdisplay')
					  ->where('uid=replyauthorid')
					  ->where("tid=$id")
					  ->orderby("replytime desc")
					  ->limit($limit)
					  ->select();
		return $reply;
	}

	//写入新的评论
	public function insertReply($contents,$id) {
		return $this->insert(['replyauthorid'=>$_SESSION['uid'],'contents'=>$contents,'replytime'=>time(),'tid'=>$id]);
	}
}