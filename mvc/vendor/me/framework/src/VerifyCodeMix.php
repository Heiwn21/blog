<?php
namespace vendor\me\framework;
use vendor\me\framework\VerifyCodeNum;
class VerifyCodeMix extends VerifyCodeNum
{
	
	protected function generateCode()
	{
		$str = '1234567890qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM';
		$str = str_shuffle($str);
		$str = substr($str,0,$this->len);
		$this->code = $str;
	}
}
