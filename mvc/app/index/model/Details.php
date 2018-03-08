<?php
namespace index\model;
use index\model\BaseModel;

class Details extends BaseModel {

	//获取需要展示的文章的个数
	public function getCount($cid=null) {
		if (empty($cid)) {
			return $this->where('istmp=0 and isdisplay=1')
						->count();
		} else {
			return $this->where("cid=$cid")
						->where('istmp=0 and isdisplay=1')
						->count();
		}
		
	}

	//获取所展示文章的信息
	public function getDetailsInfo($limit = null,$cid = null) {

		$where = $this->checkCid($cid);
		$result = $this->table('category c,details d')
					   ->field('name,title,publishtime,contents,id,hits,d.cid,replycounts,picture')
					   ->limit($limit)
					   ->where($where)
					   ->where('isdisplay=1 and istmp=0')
					   ->orderby('istop desc,publishtime desc')
					   ->select();
		return $result; 
	}

	//判断展示哪个板块的文章
	public function checkCid($cid) {
		if (empty($cid)) {
			return 'c.cid=d.cid';
		} else {
			return "c.cid=d.cid and d.cid=$cid";
		}
	}

	//更新浏览量
	public function updateHits($id) {
		$res = $this->getbyid($id);
		$hits = $res[0]['hits'] + 1;
		$this->where("id=$id")
			 ->update(['hits'=>$hits]);
	}

	//更新回复数
	public function updateReplyCounts($counts,$id) {
		$this->where("id=$id")
			 ->update(['replycounts'=>$counts]);
	}

	//获取正在阅读的文章所有的信息
	public function allInfo ($id) {
		$result = $this->field('title,publishtime,contents,id,cid,hits,replycounts,picture')
					   ->where("id=$id")
					   ->select();
		return $result[0];
	}

	//获取与关键字匹配的文章内容
	public function getSearchId($keywords) {
		$result = $this->where('istmp=0 and isdisplay=1')
					   ->where("title like '%$keywords%'")
					   ->whereor("istmp=0 and isdisplay=1 and contents like '%$keywords%'")
					   ->field('id')
					   ->select();
		return empty($result) ? false: $result;
	}

	//获取搜索展示内容
	public function getSearchInfo($limit,$where) {
		return $this->where($where)
					->where('istmp=0 and isdisplay=1')
					->field('title,publishtime,contents,id,cid,hits,replycounts,picture')
					->limit($limit)
					->orderby('publishtime')
					->select();
	}
}