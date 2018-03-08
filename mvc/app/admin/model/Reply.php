<?php
namespace admin\model;
use admin\model\BaseModel;

class Reply extends BaseModel {

	public function getCount()  {
		return $this->count();
	}

	public function replyInfo($limit) {

		$reply = $this->table('reply r,user u,details d')
					  ->field('username,replytime,r.contents,r.istop,r.isdisplay,title,rid')
					  ->where('uid=replyauthorid')
					  ->where('tid=id')
					  ->orderby("replytime desc")
					  ->limit($limit)
					  ->select();
		return $reply;
	}

	//是否展示
	public function Dis ($rid,$dis) {
		if ($dis==1) {
			$this->where("rid=$rid")
			 	 ->update(['isdisplay'=>1]);
		} else {
			$this->where("rid=$rid")
			 	 ->update(['isdisplay'=>0]);
		}
	}
}
