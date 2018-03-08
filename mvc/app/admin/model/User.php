<?php
namespace admin\model;
use admin\model\BaseModel;

class User extends BaseModel {

	public function checkPassword ($username,$password) {
		$password = md5($password);
		$result = $this->where("username='$username' and password='$password'")
					   ->field('uid')
					   ->select();
		return empty($result) ? false : $result;
	}
	//$data 必须为关联数组  ['dd'=>22,'rrr'=>77]
	public function updateInfo(array $data) {
		$name = $_SESSION['username'];
		$this->where("username='$name'")
			 ->update($data);
	}
}