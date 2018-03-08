<?php

namespace vendor\me\framework;
class Template {
	protected $tplDir = './view';//模板文件目录
	protected $cacheDir = './cache';//缓存文件目录
	protected $vars = [];    //需要保存的变量
	protected $timerInterval = 3600;//时间间隔，以秒为单位

	public function __construct($tplDir='./view',$cacheDir='./cache',$interval = 3600) {

		//目录中的反斜线替换为正斜线
		$tplDir = $this->replaceSeperator($tplDir);
		$cacheDir = $this->replaceSeperator($cacheDir);
		if (!$this->checkDir($tplDir)) {
			exit('模板目录不存在');
		}
		$this->tplDir = $tplDir;
		if (!$this->checkDir($cacheDir)) {
			exit('缓存目录不存在');
		}
		$this->cacheDir = $cacheDir;

		$this->timerInterval = ($interval>0)?$interval:$this->timerInterval;
	}

	/**
	 * [display 生成缓存文件并包含]
	 * @param  [type]  $tplFile   [模板文件]
	 * @param  boolean $isExtract [是否分配变量]
	 * @return [type]             [生成的缓存文件]
	 */
	public function display($tplFile,$isExtracted = true) {

		//检测模板文件是否存在
		$tplPath = $this->tplDir . $tplFile;
		if (!file_exists($tplPath)) {

			exit('模板文件不存在');
		}
		//缓存文件路径
		$cachePath = $this->cacheDir . str_replace('.', '_', $tplFile) . '.php';
		$dir = dirname($cachePath);
		if (!$this->checkDir($dir)) {
			exit('缓存目录不存在');
		}

		//编译模板文件
		if (!file_exists($cachePath) || filemtime($tplPath) > filemtime($cachePath) || filemtime($cachePath)+$this->timerInterval<time()) {
			$content = $this->compile($tplPath);
			file_put_contents($cachePath, $content);
		} else {
			$this->updateIncludeFiles($tplPath);
		}

		//分配变量
		if($isExtracted) {
			extract($this->vars);
			include $cachePath;
		}
	}

	//分配变量
	/**
	 * [assign description]
	 * @param  [type] $name  [变量名]
	 * @param  [type] $value [变量的值]
	 * @return [type]        [无]
	 */
	public function assign($name,$value = null) {
		//判断是否为一个关联数组
		if(is_array($name)) {
			$this->vars = array_merge($this->vars,$name);
		} else {
			$this->vars[$name] = $value ;
		}
	}

	protected function updateIncludeFiles($tplPath) {
		$pattern = '/\{include (.+)\}/U';
		$content = file_get_contents($tplPath);
		preg_match_all($pattern, $content, $matches);
		if ($matches) {
			foreach ($matches[1] as $value) {
				$fileName = trim($value,'"\'');
				$this->display($fileName,false);
			}
		}
	}

	protected function compile($fileName) {
		//读取文件
		$content = file_get_contents($fileName);
		$patterns = [
			'{$%%}' 			=> '<?=$\1;?>',
			'{if %%}' 			=> '<?php if(\1):?>',
			'{/if}'				=> '<?php endif;?>',
			'{else}'			=> '<?php else: ?>',
			'{elseif %%}'   	=> '<?php elseif(\1):?>',
			'{else if %%}'  	=> '<?php elseif(\1):?>',
			'{foreach %%}'		=> '<?php foreach(\1):?>',
			'{/foreach}'		=> '<?php endforeach;?>',
			'{while %%}'		=> '<?php while(\1):?>',
			'{/while}'			=> '<?php endwhile;?>',
			'{for %%}'			=> '<?php for(\1):?>',
			'{/for}'			=> '<?php endfor;?>',
			'{continue}'		=> '<?php continue;?>',
			'{break}'			=> '<?php break;?>',
			'{$%%++}'			=> '<?php $\1++;?>',
			'{$%%--}'			=> '<?php $\1--;?>',
			'{/*}'				=> '<?php /*',
			'{*/}'				=> '*/?>',
			'{section}'			=> '<?php ',
			'{/section}'		=> '?>',
			'{$%% = $%%}'		=> '<?php $\1 = $\2;?>',
			'{default}'			=> '<?php default:?>',
			'{include %%}'		=> '然并卵',
		];

		foreach ($patterns as $pattern => $value) {
			$pattern = preg_quote($pattern,'/');
			$pattern = '/' . str_replace('%%', '(.+)', $pattern).'/U';
			if (!stripos($pattern, 'include')) {
				$content = preg_replace($pattern, $value, $content);
			} else {
				$content = preg_replace_callback($pattern, [$this,'parseInclude'], $content);
			}
		}

		return $content;
	}

	protected function parseInclude($data) {
		//获取include的文件名
		$fileName = trim($data[1],'"\'');

		//编译所包含的模板文件，不分配变量
		$this->display($fileName,false);

		//include文件的缓存文件路径
		$cachePath = $this->cacheDir . str_replace('.','_',$fileName) .'.php'; 

		return "<?php include '$cachePath';?>";
	}

	protected function replaceSeperator($dir)
	{
		return rtrim(str_replace('\\','/',$dir),'/').'/';
	}

	protected function checkDir($dir)
	{
		if (!is_dir($dir)) {
			//递归创建目录
			return mkdir($dir,0777,true);
		} elseif(!is_writable($dir) || !is_readable($dir)) {
			 return chmod($dir,0777);
		}
		return true;
	}
}

