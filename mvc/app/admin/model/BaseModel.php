<?php
namespace admin\model;
use vendor\me\framework\Model;

class BaseModel extends Model {
	public function __construct() {

		//读取数据库配置文件
		$config = include 'config/database.php';
		parent::__construct($config);
	}
}