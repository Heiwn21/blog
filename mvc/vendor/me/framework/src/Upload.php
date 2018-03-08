<?php
namespace vendor\me\framework;
class Upload {
	protected $uploadDir = './images';
	protected $isRandName = true ;
	protected $isDateDir = false;
	protected $maxSize = 1024*500;//上传文件大小限制
	protected $upFileInfos;  //上传文件的信息
	protected $path;   //上传文件的地址
	protected $allowSubfix = ['jpeg','jpg','pjpeg','bmp','png','gif'];//允许的文件后缀
	protected $allowMime = ['image/png','image/jpeg','image/wbmp','image/gif'];//允许的文件mime类型
	protected $errNo ;//自定义错误号
	protected $errors = [           
					-1 => '没有上传信息',
					-2 => '上传目录不存在',
					-3 => '上传目录不具备读写权限',
					-4 => '上传超过规定大小',
					-5 => '文件后缀不符合要求',
					-6 => '文件MIME类型不符合规定',
					-7 => '不是上传文件',
					-8 => '创建日期目录失败',
				     	0 => '上传成功',
					 1 => '上传的文件超过了 php.ini 中 upload_max_filesize 选项限制的值',
					 2 => '上传文件的大小超过了 HTML 表单中 MAX_FILE_SIZE 选项指定的值',
					 3 => '文件只有部分被上传。',
					 4 => '没有文件被上传。',
					 6 => '找不到临时文件夹。PHP 4.3.10 和 PHP 5.0.3 引进',
					 7 => '文件写入失败'
			];//自定义错误信息
/**
 * [__construct description]
 * @param array $data [参数数组] ：['uploadDir'=>'./uploads','isDateDir'=>true]
 */
	public function __construct(array $data = null) {
		if ($data) {
			foreach ($data as $key => $value) {
				if (property_exists(__CLASS__,$key)) {
					$this->$key = $value;
				}
			}
		}
		$this->errNo = 0;
	}

	public function showError() {
		return $this->errors[$this->errNo];
	}

	public function upload($key) {
		//文件信息检测
		if (!$this->checkUpFileInfo($key)) {
			return false ;
		}

		//上传路径检测
		if(!$this->checkUpDir()) {
			return false;
		}

		//系统错误检测
		if(!$this->checkSystemError()) {
			return false;
		}

		//检测自定义错误
		if (!$this->checkCustomError()) {
			return false ;
		}

		//检测是不是上传文件
		if (!$this->checkUpFile()) {
			return false ;
		}

		//移动文件至指定目录
		if (!$this->moveFile()) {
			return false ;
		}

		//返回文件路径
		return $this->path;
	}

	protected function checkUpFileInfo($key) {
		if (empty($_FILES[$key])) {
			$this->errNo = -1;
			return false;
		}
		$this->upFileInfos = $_FILES[$key];
		return true;
	}

	protected function checkUpDir() {
		$dir = $this->uploadDir;
		$dir = rtrim(str_replace('\\', '/', $dir),'/') . '/';
		if (!is_dir($dir)) {
			if (!mkdir($dir,0777,true)) {
				$this->errNo = -2;
				return false;
			}
		} else if (!is_writable($dir) || !is_readable($dir)) {
			if (!chmod($dir, 0777)) {
				$this->errNo = -3;
				return false ;
			}
		}
		$this->uploadDir = $dir;
		return true;
	}

	protected function checkSystemError() {
		$num = $this->upFileInfos['error'];
		if ($num) {
			$this->errNo = $num;
			return false;
		}
		return true;
	}

	protected function checkCustomError() {
		//检查文件大小
		$size = $this->upFileInfos['size'];
		if ($size > $this->maxSize) {
			$this->errNo  = -4;
			return false ;
		}

		//检查文件后缀
			//判断文件是否含有后缀
		if (empty(pathinfo($this->upFileInfos['name'])['extension'])) {
			$this->errNo = -5;
			return false ;
		}
		$ext = pathinfo($this->upFileInfos['name'])['extension'];
		if (!in_array($ext,$this->allowSubfix)) {
			$this->errNo = -5;
			return false ;
		}

		//判断文件的mime类型
		$mime = $this->upFileInfos['type'];
		if (!in_array($mime,$this->allowMime)) {
			$this->errNo = -6;
			return false;
		}

		return true;
	}

	protected function checkUpFile() {
		$file = $this->upFileInfos['tmp_name'];
		if(!is_uploaded_file($file)) {
			$this->errNo = -7;
			return false;
		}
		return true;
	}

	protected function moveFile() {
		//判断是否为日期目录
		if ($this->isDateDir) {
			$date = date('Y/m/d');
			$path = $this->uploadDir . $date . '/';
			if (!is_dir($path)) {
				if (!mkdir($path,0777,true)) {
					$this->errNo = -8;
					return false ;
				}
			}
		} else {
			$path = $this->uploadDir;
		}

		//判断是否为随机文件名
		$ext = pathinfo($this->upFileInfos['name'])['extension'];
		if ($this->isRandName) {
			$path .= uniqid() . '.' . $ext;
		} else {
			$path .= $this->upFileInfos['name']; 
		}

		if (!move_uploaded_file($this->upFileInfos['tmp_name'], $path)) {
			$this->errNo = 7;
			return false;
		}
		$this->path = $path;
		return true;
	}

}