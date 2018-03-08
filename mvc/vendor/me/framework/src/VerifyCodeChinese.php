<?php
namespace vendor\me\framework;
use vendor\me\framework\VerifyCodeNum;
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
			imagettftext($this->image,14,0,$x,$y,$this->randColor(0,60),'/public/font/FZLTCXHJW.TTF',$str);
		}
	}
}
