<?php
class VerifyCodeNum {
	protected $width=100;
	protected $height = 30;
	protected $len = 4;//字符串长度
	protected $code;//验证码字符串
	protected $image;//画布
	public function __construct($width=100,$height=30,$len=4) {
		$this->width = ($width>0)? $width : $this->width;
		$this->height =($height>0)? $height : $this->height;
		$this->len = ($len>6 || $len<4)?$this->len : $len;
	}

	public function __get($name) {
		if ($name == 'code') {
			return $this->code;
		}
	}

	public static function checkNumber() {
		$vc = new static();
		return $vc->outputImage();
	}

	//生成验证码图片
	public function outputImage() {
	//六脉神剑
		//1)创建画布
		$this->createImage();
		//2）生成验证码字符串
		$this->generateCode();
		//3）将验证码字符串画到画布上
		$this->drawCode();
		//4）画干扰元素
		$this->drawDisturbPoint();
		$this->drawDisturblen();
		//5）发送验证码
		$this->showCode();
		//6）释放资源
		$this->free();

		return $this->code;
	}

	
	protected function createImage() {
		$this->image = imagecreatetruecolor($this->width, $this->height);
		$color = $this->randColor(200,254);
		imagefill($this->image, 0, 0, $color);
	}

	protected function generateCode() {
		$str = '';
		for ($i = 0;$i<$this->len;$i++) {
			$str .=mt_rand(0,9); 
		}
		$this->code = $str;
	}

	protected function drawCode() {
		for ($i = 0;$i<$this->len;$i++) {
			$x = ($this->width-10)/$this->len*$i + 10;
			$y = mt_rand(1,$this->height - 15);
			imagechar($this->image,5, $x, $y,$this->code[$i], $this->randColor(0,80));
		} 
	}

	protected function drawDisturbPoint() {
		for ($i=0; $i <100 ; $i++) { 
			$x = mt_rand(0,$this->width);
			$y = mt_rand(0,$this->height);
			imagesetpixel($this->image, $x, $y, $this->randColor(160,200));
		}
	}

	protected function drawDisturblen () {
		for ($i=1;$i<$this->len;$i++) {
			$x1 = rand(1,$this->width-1);
			$y1 = rand(1,$this->height-1);
			$x2 = rand(1,$this->width-1);
			$y2 = rand(1,$this->height-1);
			imageline($this->image,$x1,$y1,$x2,$y2,$this->randColor(120,200));
		}
	}

	protected function showCode() {
		header('content-type:image/png');
		imagepng($this->image);
	}

	//销毁验证码画布
	protected function free() {
		imagedestroy($this->image);
	}

	final protected function randColor($low,$hight) {
		return imagecolorallocate($this->image, mt_rand($low,$hight), mt_rand($low,$hight),mt_rand($low,$hight));
	}
}


class VerifyCodeChinese extends VerifyCodeNum
{
	
	protected function generateCode()
	{
		$gbk='';
		for($i=0;$i<$this->len;$i++) {
			$c1 = mt_rand(176,214);
			$c2 = mt_rand(161,254);
			$gbk .=chr($c1).chr($c2);
		}
		$this->code = iconv('gbk','utf-8',$gbk);
	}

	protected function drawCode() {
		for ($i=0;$i<$this->len;$i++) {
			$x = ($this->width-10)/$this->len*$i+5;
			$y = mt_rand(15,$this->height-5);
			$str = mb_substr($this->code,$i,1);
			imagettftext($this->image,14,0,$x,$y,$this->randColor(0,60),'FZLTCXHJW.TTF',$str);
		}
	}
}



$tt = new VerifyCodeChinese();
$tt->outputImage();