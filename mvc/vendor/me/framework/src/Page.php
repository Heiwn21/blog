<?php
namespace vendor\me\framework;
 class Page {
 	protected $totalInfos = 1;
 	protected $numOfPage = 1;
 	protected $totalPages;
 	protected $page;
 	protected $url;

 	public function __construct($totalInfos=1,$numOfPage=1) {
 		$this->totalInfos = ($totalInfos>=1)?$totalInfos:$this->totalInfos;
 		$this->numOfPage = ($numOfPage>=1)?$numOfPage:$this->numOfPage;
 		$this->totalPages = ceil($this->totalInfos/$this->numOfPage);
 		$this->getPage();
 		$this->getUrl();
 	}

 	public function firstPage() {
 		return $this->setUrl(1);
 	}

 	public function pre() {
 		if ($this->page==1) {
 			return $this->setUrl(1);
 		}
 		return $this->setUrl($this->page-1);
 	}

 	public function next() {
 		if ($this->page==$this->totalPages) {
 			return $this->setUrl($this->totalPages);
 		}
 		return $this->setUrl($this->page+1);
 	}

 	public function finalyPage () {
 		return $this->setUrl($this->totalPages);
 	}

 	public function jumpPage($jpPage) {
 		return $this->setUrl($jpPage);
 	}

 	public function limit() {
 		return ' ' . ($this->page-1)*$this->numOfPage . ',' . $this->numOfPage;
 	}

 	public function allPage()
	{
		return [
			'first' => $this->firstPage(),
			'pre' => $this->pre(),
			'next' => $this->next(),
			'last' => $this->finalyPage(),
		];
	}


 	protected function getPage() {
 		if (empty($_GET['page']) || $_GET['page']<=1) {
 			$this->page = 1;
 		} else {
 			if($_GET['page']>=$this->totalPages) {
 				$this->page = $this->totalPages;
 			} else {
 				$this->page = $_GET['page'];
 			}
 		}
 	}

 	protected function getUrl() {
 		$url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . ':' . $_SERVER['SERVER_PORT'] . $_SERVER['SCRIPT_NAME'];
 		parse_str($_SERVER['QUERY_STRING'],$data);
 		if (!empty($data)) {
 			unset($data['page']);
 			unset($data['hit']);
 			$query = http_build_query($data);
 			$url .='?' . $query; 
 		}
 		$this->url= rtrim($url,'?');
 	}

 	protected function setUrl($num) {
 		if (stripos($this->url,'?') !== false) {
 			return $this->url . "&page=$num";
 		}
 		return $this->url . "?page=$num";
 	}
 }