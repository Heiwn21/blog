<?php
namespace admin\model;
use admin\model\BaseModel;

class Details extends BaseModel {

	//获取需要展示的文章的个数
	public function getCount($cid=null) {
		if (empty($cid)) {
			return $this->where('istmp=0')
						->count();
		} else {
			return $this->where("cid=$cid")
						->where('istmp=0')
						->count();
		}
		
	}

	//获取草稿文章的个数
	public function getTmpCount () {
		return $this->where('istmp=1')
					->count();
	}

	//获取草稿文章的信息
	public function getTmpDetailsInfo($limit = null) {

		$result = $this->table('category c,details d')
					   ->field('name,title,publishtime,contents,id,hits,d.cid,replycounts,picture,d.istop,d.isdisplay')
					   ->limit($limit)
					   ->where('c.cid=d.cid')
					   ->where('istmp=1')
					   ->orderby('publishtime desc')
					   ->select();
		return $result; 
	}

	//获取所展示文章的信息
	public function getDetailsInfo($limit = null,$cid = null) {

		$where = $this->checkCid($cid);
		$result = $this->table('category c,details d')
					   ->field('name,title,publishtime,contents,id,hits,d.cid,replycounts,picture,d.istop,d.isdisplay')
					   ->limit($limit)
					   ->where($where)
					   ->where('istmp=0')
					   ->orderby('istop desc,publishtime desc')
					   ->select();
		return $result; 
	}

	//获取正在修改的文章所有的信息
	public function allInfo ($id) {
		$result = $this->field('title,contents,id,picture,name')
					   ->table('category c,details d')
					   ->where("id=$id")
					   ->where('c.cid=d.cid')
					   ->select();
		return $result[0];
	}

	//判断展示哪个板块的文章
	public function checkCid($cid) {
		if (empty($cid)) {
			return 'c.cid=d.cid';
		} else {
			return "c.cid=d.cid and d.cid=$cid";
		}
	}

	//更新回复数
	public function updateReplyCounts($counts,$id) {
		$this->where("id=$id")
			 ->update(['replycounts'=>$counts]);
	}

	//取消置顶
	public function notTop () {
		$this->where('1')
			 ->update(['istop'=>0]);
	}

	//置顶
	public function Top ($id) {
		$this->where("id=$id")
			 ->update(['istop'=>1]);
	}

	//是否展示
	public function Dis ($id,$dis) {
		if ($dis==1) {
			$this->where("id=$id")
			 	 ->update(['isdisplay'=>1]);
		} else {
			$this->where("id=$id")
			 	 ->update(['isdisplay'=>0]);
		}
	}

	//更新修改文章内容内容
	public function updateWenZhang($data,$id) {
		$this->where("id=$id")
			 ->update($data);
	}

	//添加新文章
	//$data 必须为关联数组   ['dd'=>99,'uu'=>00]
	public function insertDetails(array $data) {
		$this->insert($data);
	}

}