<?php
namespace index\model;
use index\model\BaseModel;

class Category extends BaseModel {

	public function getCategory($cid) {
		$data = $this->getbycid($cid);
		return $data[0]['name'];
	}

	public function getAllCategory() {
		$data = $this->field('name,cid')
					 ->orderby('orderby')
					 ->select();
		return $data;
	}
}