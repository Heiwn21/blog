<?php
namespace admin\controller;
use admin\controller\BaseController;
use admin\model\User;
use admin\verify\CheckInfo;
use vendor\me\framework\Upload;

class Pass extends BaseController{
	protected $user;
	protected $check;
	protected $up;
	protected $rootPath;

	public function sonInit() {
		$this->user = new User();
		$this->check = new CheckInfo();
		$this->rootPath = include 'config/rootpath.php';
		$path = $this->rootPath['WEB_SITE'] . 'public/upload/images/headPicture';
		$this->up = new Upload(['uploadDir'=>$path]);
	}
	
	public function password() {
		$this->display();
	}

	public function doEdit () {
		$oldPassword = $_POST['mpass'];
		$newPassword = $_POST['newpass'];
		$name = $_SESSION['username'];

		//判断原密码是否正确
		$result = $this->user->checkPassword($name,$oldPassword);
		if (!$result) {
			$this->notice(0,'原始密码错误，请重新输入','/index.php?m=admin&c=pass&a=password');
			exit;
		}

		//获得头像上传后的地址
		$headerPath = $this->up->upload('header');
		$path = '/' . ltrim($headerPath,$this->rootPath['WEB_SITE']);

		//判断是否修改了密码
		if ($oldPassword !== $newPassword) {
			
			//验证新密码是否符合格式
			if (!$this->check->password_check($newPassword)) {
				$this->notice(0,'密码应由5-12个字符组成，不能为纯数字','/index.php?m=admin&c=pass&a=password');
				exit;
			}

			//更新用户信息
			$_SESSION['header'] = $path;
			$this->user->updateInfo(['password'=>md5($newPassword),'picture'=>$path]);
			$this->notice(1,'信息修改成功','/index.php?m=admin&c=pass&a=password');
			exit;
		} else {
			$_SESSION['header'] = $path;
			$this->user->updateInfo(['picture'=>$path]);
			$this->notice(1,'头像修改成功','/index.php?m=admin&c=pass&a=password');
			exit;
		}	
	}
}