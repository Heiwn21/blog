<?php
namespace admin\controller;
use admin\controller\BaseController;
use admin\verify\CheckInfo;

class Index extends BaseController {
	protected $check;

	public function sonInit () {
		$this->check = new CheckInfo();
	}

	public function index () {

		$this->display();
	}

	public function info() {

		$config = include 'config/blogInfo.php';
		$this->assign('config',$config);
		$this->display();
	}

	public function doInfo() {
		$name = $_POST['blogName'];
		$web = $_POST['blogWeb'];
		$signature = $_POST['blogSignature'];
		$qq = $_POST['qq'];
		$email = $_POST['email'];

		//验证邮箱是否符合格式
		if (!$this->check->email_check($email)) {
			$this->notice(0,'请输入正确的邮箱格式','/index.php?m=admin&c=index&a=info');
			exit;
		}

		//验证url是否符合格式
		if (!$this->check->url_check($web)) {
			$this->notice(0,'请输入正确的URL','/index.php?m=admin&c=index&a=info');
			exit;
		}

		//验证邮箱是否符合格式
		if (!$this->check->qq_check($qq)) {
			$this->notice(0,'请输入正确的QQ','/index.php?m=admin&c=index&a=info');
			exit;
		}

		//将修改后的信息重新写入文件
		$data = ['blogName'=>$name,'blogWeb'=>$web,'blogSignature'=>$signature,'qq'=>$qq,'email'=>$email];
		$content = "<?php \n return " . var_export($data,true) . ';';
		file_put_contents('config/blogInfo.php', $content);
		$this->notice(1,'修改成功！！','/index.php?m=admin&c=index&a=info');
	}

}