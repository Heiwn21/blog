<?php

namespace index\verify;
use vendor\me\framework\VerifyCodeNum;
use vendor\me\framework\VerifyCodeChinese;
use vendor\me\framework\VerifyCodeMix;
use vendor\me\framework\VerifyCodeLeter;
class CheckCode {
	protected $verify;

	public function __construct($style='num',$width=100,$height=30,$len=4) {
		if ('num'==$style) {
			$this->verify = new VerifyCodeNum($width,$height,$len);
		} else if('leter'==$style) {
			$this->verify = new VerifyCodeLeter($width,$height,$len);
		} else if('mix'==$style) {
			$this->verify = new VerifyCodeMix($width,$height,$len);
		} else {
			$this->verify = new VerifyCodeChinese($width,$height,$len);
		}
	}

	public function outVerifyCode () {
		return $this->verify->outputImage();
	}
}
