<?php
namespace vendor\me\framework;
class Image {
	protected $imageDir = './images';
	protected $imageType = 'png';
	protected $isRandFile = true;
	public function __construct($imageDir,$imageType='png',bool $isRandFile =true) {
		$this->isRandFile = $isRandFile;
		$this->imageType =$this->getImageType($imageType);
		$imageDir = $this->replaceDir($imageDir);
		
		if (!$this->checkDir($imageDir)) {
			exit('目录不存在或不可读写');
		} else {
			$this->imageDir = $imageDir;
		}
	}

	public function zoom($imageName,$width,$height) {
		//路径检查
		if (!file_exists($imageName)) {
			exit('目标文件不存在');
		}
		//计算缩放尺寸
		list($oldWidth,$oldHeight)  = getimagesize($imageName);
		$wScale = $width/$oldWidth;
		$hScale = $height/$oldHeight;
		$scale = min($wScale,$hScale);
		$newWidth = $oldWidth*$scale;
		$newHeight = $oldHeight*$scale;

		//计算图片位置
		if ($scale==$wScale) {
			$x = 0;
			$y = abs($height-$newHeight)/2;
		} else {
			$x = abs($width-$newWidth)/2;
			$y = 0;
		}

		//合并图片
		$srcImage = $this->openImage($imageName);
		$destImage = imagecreatetruecolor($width, $height);
		$white = imagecolorallocate($destImage, 255, 255, 255);
		imagefill($destImage,0, 0,$white);
		//拷贝合并图像并调整大小
		imagecopyresampled($destImage, $srcImage, $x, $y, 0, 0, $newWidth, $newHeight, $oldWidth, $oldHeight);

		//保存图片
		$path =  $this->saveImage($imageName,$destImage);
		//释放资源 
	 	imagedestroy($srcImage);
		imagedestroy($destImage);
		return $path;
	}

	public function waterImage(string $destFile,string $srcFile,$pos = 5,$alpha=50) {
		//1）路径检查
		if (!file_exists($destFile) || !file_exists($srcFile)) {
			exit('目标文件或者水印文件不存在');
		}
		//2）计算图片的大小
		list($destWidth,$destHeight) = getimagesize($destFile);
		list($srcWidth,$srcHeight) = getimagesize($srcFile);

		if ($destWidth<$srcWidth || $destHeight<$srcHeight) {
			exit ('水印图片比目标图片大');
		}

		//3）计算水印的坐标
		$position = $this->getPosition($destWidth,$destHeight,$srcWidth,$srcHeight,$pos);

		//4)合并图片
		$destImage = $this->openImage($destFile);
		$srcImage = $this->openImage($srcFile);
		imagecopymerge($destImage, $srcImage, $position['x'], $position['y'], 0, 0, $srcWidth, $srcHeight, $alpha);

		//5）保存图片
		$path = $this->saveImage($destFile,$destImage);

		//6）释放资源
		imagedestroy($destImage);
		imagedestroy($srcImage);

		//返回图片路径
		return $path;
	} 

	protected function replaceDir($imageDir) {
		return rtrim(str_replace('\\','/', $imageDir),'/') . '/';
	}

	protected function checkDir($imageDir) {
		if (!is_dir($imageDir)) {
			return mkdir($imageDir,0777);
		} elseif (!is_writable($imageDir) || !is_readable($imageDir)) {
			return chmod($imageDir,0777);
		} else {
			return true;
		}
	}

	protected function getImageType($imageType) {
		$arr = ['jpg','pjpeg','bmp'] ;
		if (in_array($imageType, $arr)) {
			if ($imageType=='bmp') {
				return 'wbmp';
			} else {
				return 'jpeg';
			}
		} else {
			return $imageType;
		}
	}

	protected function getPosition($destWidth,$destHeight,$srcWidth,$srcHeight,$pos) {
		//九宫格位置
		if ($pos>=1 && $pos<=9) {
			$x = ($pos-1)%3*($destWidth-$srcWidth)/2;
			$y = floor(($pos-1)/3)*($destHeight-$srcHeight)/2;
		} else {
			$x = mt_rand(0,$destWidth-$srcWidth);
			$y = mt_rand(0,$destHeight-$srcHeight);
		}
		return ['x'=>$x,'y'=>$y];
	}

	protected function openImage($fileName) {
		$info = getimagesize($fileName);
		if (empty($info)) {
			exit('该文件不是图片类型');
		}
		$type = ltrim(strstr($info['mime'],'/'),'/');
		$function = 'imagecreatefrom' . $type;
		if (!function_exists($function)) {
			exit('不支持该类型的图片');
		}
		return $function($fileName);
	}

	protected function saveImage($destFile,$destImage) {
		if ($this->isRandFile) {
			$fileName = uniqid() . "." . $this->imageType;  
		} else {
			$fileName = pathinfo($destFile)['filename'] . "." . $this->imageType;
		}
		$path = $this->imageDir . $fileName;
		$func = 'image' . $this->imageType;
		if (function_exists($func)) {
			$func($destImage,$path);
			return $path;
		} else {
			exit('不支持该类型的图片');
		}
	}
}