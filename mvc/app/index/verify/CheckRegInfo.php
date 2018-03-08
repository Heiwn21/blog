<?php

namespace index\verify;

class CheckRegInfo {
	//注册邮箱验证
	//正确格式：123@qq.com或者123@qq.com.cn
	public function email_check($email) {
		$pattern = '/^\w+@(\w+\.)+\w+$/';
		if (!preg_match($pattern,$email,$match)) {
			return false;
		} else {
			return true;
		}
	}


	//注册用户名验证
	//中文，字母，数字，_   组成：6-12位
	public function username_check($username) {
		$pattern = '/^([\x{4e00}-\x{9fa5}]|\w){6,12}$/u';
		if (!preg_match($pattern,$username,$match)) {
			return false;
		} else{
			return true;
		}
	}

	//注册密码验证
	//不能为纯数字
	//位数为3-12位
	public function password_check($password) {
		$pattern = '/^\d{3,12}$/';
		if (preg_match($pattern,$password,$match)) {
			return false;
		}
		$pattern = '/^\w{3,12}$/';
		if (!preg_match($pattern,$password,$match)) {
			return false;
		} else{
			return true;
		}
	}


	/*
	功能：检验URL是否合格
	参数：$url   需要检验的url
	返回值： 符合 true  不符合  false
	*/
	public function url_check($url) {
		$pattern = '/^(http|https):\/\/(\w+\.?)+(\/?.\??(\w+=.*)*)+(\.?\w)*/';
		if (preg_match($pattern,$url,$match)) {
			return true;
		} else {
			return false;
		}
	}

}