<?php
namespace index\controller;
use index\controller\BaseController;
use index\model\User as UserModel;
use index\verify\CheckCode;
use index\verify\CheckRegInfo;
use Aliyun\SmsDemo;
use vendor\phpemail\PHPMailer;

class User extends BaseController {
	protected $user;
	protected $checkReg;

	public function sonInit() {
		$this->user = new UserModel;
		$this->checkReg = new CheckRegInfo;
	}

	public function login() {
		$this->display();
	}

	//登录检测
	public function doLogin () {
		$name = $_POST['username'];
		$password = md5($_POST['password']);
		$res = $this->user->checkUser($name,$password);
		if ($res) {
			$_SESSION['username'] = $name;
			$_SESSION['uid'] = $res[0]['uid'];
			$_SESSION['flage'] = $res[0]['flage'];
			$_SESSION['header'] = $res[0]['picture'];
			$this->notice(1,"欢迎 {$name} 登录",'/index.php');
		} else {
			$this->notice(0,"账号或密码错误，请重新输入！",'/index.php?m=index&c=User&a=login');
		}
	}

	public function register() {
		$this->display();
	}

	//图片验证码
	// public function yzm () {
	// 	$tmp = new CheckCode();
	// 	$_SESSION['yzm'] = $tmp->outVerifyCode();

	// }

	public function phoneSend() {
		if (!empty($_POST['phone'])) {
			header('Content-Type: text/plain; charset=utf-8');
			$code = mt_rand(100000,999999);
			$phone = $_POST['phone'];

			$_SESSION['yzm'] = $code;

			$demo = new SmsDemo(
				"122334",//appid
				"111111"//token
				);

			$response = $demo->sendSms(
							"1234567", // 短信签名
							"12345667", // 短信模板编号
							"$phone", // 短信接收者
							Array(  // 短信模板中字段的值
								"code"=>"$code",
								"product"=>"dsd"
								),
							"123"
							);
		}
	}

	public function emailSend() {
		if (!empty($_POST['email'])) {

			$mail = new PHPMailer(true); //建立邮件发送类
			
			$mail->CharSet = "UTF-8";//设置信息的编码类型
			$address = $_POST['email'];//收件人地址

			$code = mt_rand(100000,999999);
			$_SESSION['emailCode'] = $code;

			$mail->IsSMTP(); // 使用SMTP方式发送
			
			$mail->Host = "smtp.163.com"; //使用163邮箱服务器
			$mail->SMTPAuth = true; // 启用SMTP验证功能
			$mail->Username = "1@qq.com "; //你的163服务器邮箱账号
			$mail->Password = "********"; // 163邮箱密码
			$mail->SMTPSecure = 'ssl';//设置使用ssl加密方式登录鉴权
			$mail->Port = 465;//邮箱服务器端口号
			$mail->From = "1@qq.com"; //邮件发送者email地址
			$mail->FromName = "12345";//发件人名称
			$mail->AddAddress("$address", "尊敬的用户"); //收件人地址，可以替换成任何想要接收邮件的email信箱,格式是AddAddress("收件人email","收件人姓名")
			  // $mail->AddAttachment(""); // 添加附件(注意：路径不能有中文)
			$mail->IsHTML(false);//是否使用HTML格式
			$mail->Subject = "找回密码"; //邮件标题
			$mail->Body = "您正在进行找回密码操作，验证码为：{$code}。
			请勿泄露给其他人。若非本人操作，您的博客账户可能已经泄露，建议马上更改密码！验证码有效时间为5分钟！"; //邮件内容，上面设置HTML，则可以是HTML

			
			if (!$mail->Send()) {
				echo "邮件发送失败. <p>";
				echo "错误原因: " . $mail->ErrorInfo;
				exit;
			}
		}
		
	}

	//注册信息检验
	public function doRegister() {
		$name = $_POST['username'];
		$password = $_POST['password'];
		$email = $_POST['email'];
		$rePassword = $_POST['rePassword'];
		$verifyCode = $_POST['verifyCode'];
		$phone = $_POST['phone'];
		//验证用户名是否符合格式
		if (!$this->checkReg->username_check($name)) {
			$this->notice(0,'用户名应由6-12个字符组成','/index.php?m=index&c=User&a=register');
			exit;
		}
		//验证用户名是否存在
		if ($this->user->checkRepeat('username',$name)) {
			$this->notice(0,'用户名已存在，请重新输入','/index.php?m=index&c=User&a=register');
			exit;
		}
		//验证密码是否符合格式
		if (!$this->checkReg->password_check($password)) {
			$this->notice(0,'密码不能为纯数字，应由6-12个字符组成','/index.php?m=index&c=User&a=register');
			exit;
		}

		//验证两次密码输入是否一致
		if ($password !== $rePassword) {
			$this->notice(0,'两次密码不一致，请重新输入','/index.php?m=index&c=User&a=register');
			exit;
		}
		//验证邮箱是否符合格式
		if (!$this->checkReg->email_check($email)) {
			$this->notice(0,'请输入正确的邮箱格式','/index.php?m=index&c=User&a=register');
			exit;
		}
		//验证邮箱是否被注册
		if ($this->user->checkRepeat('email',$email)) {
			$this->notice(0,'该邮箱已注册，请前去登录或更换邮箱注册','/index.php?m=index&c=User&a=register');
			exit;
		}

		//验证码
		if ($verifyCode != $_SESSION['yzm']) {
			$this->notice(0,'验证码不正确，请重新输入','/index.php?m=index&c=User&a=register');
			exit;
		}

		//将信息写入数据库
		$data = ['username'=>$name,'password'=>md5($password),'email'=>$email,'regtime'=>time(),'phone'=>$phone];
		$result = $this->user->insert($data);
		if ($result) {
			$_SESSION['username'] = $name;
			$_SESSION['uid'] = $result;
			$_SESSION['flage'] = 0;
			$_SESSION['header'] = '/public/upload/images/headPicture/avatar_blank.gif';
			$this->notice(1,'注册成功','/index.php');
			exit;
		} else {
			$this->notice(0,'注册失败','/index.php?m=index&c=User&a=register');
			exit;
		}
	}

	public function forgot () {
		$this->display();
	}

	//忘记密码信息验证
	public function doForgot () {
		$email = $_POST['email'];
		$username = $_POST['username'];
		$code = $_POST['emailCode'];

		if ($code == $_SESSION['emailCode']) {
			$res = $this->user->find($email,$username);
			if ($res) {
				$uid = $res[0]['uid'];
				$this->notice(1,"即将跳至修改密码的页面","/index.php?m=index&c=user&a=editpass&uid=$uid");
				exit;
			} else {
				$this->notice(0,"基本信息填写有误，请重新填写","/index.php?m=index&c=user&a=forgot");
				exit;
			}
			
		} else {
			$this->notice(0,"验证码错误，请重新获取",'/index.php?m=index&c=user&a=forgot');
			exit;
		}
	}

	//修改密码
	public function editpass () {

		if (empty($_GET['uid'])) {
			$this->notice(0,'非法操作！！！','/index.php');
			exit;
		}

		$_SESSION['passid'] = $_GET['uid'];
		$userInfo = $this->user->getbyuid($_GET['uid']);
		$this->assign('userInfo',$userInfo[0]);
		$this->display();
	}

	public function doEditPass() {
		$newPass = $_POST['newpass'];
		$uid = $_SESSION['passid'];


		//验证密码是否符合格式
		if (!$this->checkReg->password_check($newPass)) {
			$this->notice(0,'密码不能为纯数字，应由6-12个字符组成',"/index.php?m=index&c=User&a=editpass&uid=$uid");
			exit;
		}
		$data = ['password'=>md5($newPass)];
		$this->user->editPassword($data,$uid);
		$this->notice(1,"修改成功，请重新登录！！",'/index.php?m=index&c=User&a=login');
	}

	public function goOut() {
		$_SESSION['username'] = '';
		$_SESSION['flage'] = '';
		session_destroy();
		$this->notice(1,"退出成功，将返回首页",'/index.php');
	}
}