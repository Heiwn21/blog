<?php
namespace vendor\me\framework;
use vendor\me\framework\VerifyCodeNum;
class VerifyCodeLeter extends VerifyCodeNum
{
	
	protected function generateCode()
	{
		$str = 'qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM';
		$str = str_shuffle($str);
		$str = substr($str,0,$this->len);
		$this->code = $str;
	}
}

