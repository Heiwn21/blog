<?php
namespace index\model;
use index\model\BaseModel;
 class User extends BaseModel {

 	public function getUserInfo () {
 		return $this->field('name')
 					->select();
 	}

 	public function checkUser ($name,$password) {
 		$res = $this->where ("username='$name'")
 					->where ("password = '$password'")
 					->field('flage,uid,picture')
 					->select();
 		return empty($res)?false :$res;
 	}

 	public function find($email,$username) {
 		$res = $this->where("email='$email' and username='$username'")
 					->field('uid,email,username')
 					->select();
 		return empty($res)?false :$res;
 	}

 	public function checkRepeat($key,$value) {
 		$res = $this->where ("$key='$value'")
 					->field('uid')
 					->select();
 		return empty($res)?false : true;
 	}

 	public function editPassword($password,$uid) {
 		$this->where("uid=$uid")
 			 ->update($password);
 	}


 }