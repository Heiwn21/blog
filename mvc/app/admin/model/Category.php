<?php
namespace admin\model;
use admin\model\BaseModel;

class Category extends BaseModel {

	public function getCategory($cid) {
		$data = $this->getbycid($cid);
		return $data[0];
	}

	public function getAllCategory() {
		$data = $this->field('name,cid,orderby')
					 ->orderby('orderby')
					 ->select();
		return $data;
	}

	//添加新版块
	//$data 必须为关联数组   ['dd'=>99,'uu'=>00]
	public function addCate(array $data) {
		$this->insert($data);
	}

	//修改版块
	//$data 必须为关联数组   ['dd'=>99,'uu'=>00]
	public function editCategory(array $data,$cid) {
		$this->where("cid=$cid")
			 ->update($data);
	}
}