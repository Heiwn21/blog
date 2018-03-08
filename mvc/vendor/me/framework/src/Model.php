<?php
namespace vendor\me\framework;
class Model {
	protected $host;
	protected $user;
	protected $password;
	protected $dbname;
	protected $charset;
	protected $prefix;
	protected $link;
	protected $table;
	public 	  $sql;
	protected $cache = './cache/tableWord';
	protected $cacheFields;
	protected $options = [
		'field' 	=>'*',
		'table'     =>'',
		'where' 	=>'',
		'groupby' 	=>'',
		'having' 	=>'',
		'orderby' 	=>'',
		'limit' 	=>'',
	];

	public function __construct(array $config) {
		foreach ($config as $key => $value) {
			$var = ltrim(strstr(strtolower($key),'_'),'_');
			$this->$var = $value;
		}
		$this->cache = rtrim(str_replace('\\', '/', $this->cache),'/') . '/';
		$this->link = $this->connect();//数据库链接
		$this->table = $this->getTable();//获取表名

		//检测缓存目录是否存在
		if (!$this->checkDir($this->cache)) {
			exit('缓存目录不存在');
		}

		//初始化缓存字段
		$this->cacheFields = $this->initCache();

		//初始化查询数组
		$this->options = $this->initOptions();
	}

	public function __call($name,$value) {

		//获取name的前五个字符
		$tmp = substr(strtolower($name),0,5);
		$fieldName = substr(strtolower($name),5); 
		if ($tmp=='getby') {
			if (count($value)>0) {
				return $this->getBy($fieldName,$value[0]);
			}
		}
	}

	//每次只能查询一条数据
	protected function getBy($fieldName,$value) { 
		if (is_string($value)) {
			$this->options['where'] = " where $fieldName = '$value'"; 
		} else {
			$this->options['where'] = " where $fieldName = $value"; 
		}
		return $this->select();	
	}

	public function sql() {
		return $this->sql;
	}

	//统计函数
	public function count($field = '*')
	{	
		$this->options['field'] = " count($field) ";
		$data = $this->select(MYSQLI_NUM);
		if (!empty($data)) {
			return $data[0][0];
		}
		return false ;
	}

	public function max($field)
	{
		$this->options['field'] = " max($field) ";
		$data = $this->select(MYSQLI_NUM);
		if (!empty($data)) {
			return $data[0][0];
		}
		return false ;
	}

	public function min($field)
	{
		$this->options['field'] = " min($field) ";
		$data = $this->select(MYSQLI_NUM);
		if (!empty($data)) {
			return $data[0][0];
		}
		return false ;
	}

	public function sum($field)
	{
		$this->options['field'] = " sum($field) ";
		$data = $this->select(MYSQLI_NUM);
		if (!empty($data)) {
			return $data[0][0];
		}
		return false;
	}

	//-----------------------------------------------------------------------------------------
	//增删改查
	
	/**
	 * [select 查询]
	 * @param  [type] $resultType [返回查询的数据数组的形：关联，索引，混合]
	 * @return [type]             [返回查询的结果]
	 */
	public function select($resultType = MYSQLI_ASSOC) {
		$sql = "select %field% from %table% %where% %groupby% %having% %orderby% %limit%";
		$sql = str_replace([
							'%field%',
							'%table%',
							'%where%',
							'%groupby%',
							'%having%',
							'%orderby%',
							'%limit%'
						],
					[
						$this->options['field'],
			            $this->options['table'],
			            $this->options['where'],
			            $this->options['groupby'],
			            $this->options['having'],
			            $this->options['orderby'],
			            $this->options['limit']
					],$sql);
		return $this->query($sql,$resultType);
	}

	/**
	 * [insert 插入数据]
	 * @param  array  $data [关联数组，键就是表的字段] ['name'=>'琨','password'=>md5('11')]
	 * @return [type]       [成功插入返回true，否则返回false]
	 */

	public function insert (array $data,$insertId = true) {
		$sql = "insert into %table%(%field%) value(%value%)";

		//1给关联数组中值是字符串的字段添加单引号
		$data = $this->addQuote($data);

		//2过滤无效字段
		$data = $this->validField($data);

		//替换sql中的关键字
		$sql = str_replace(['%table%',
							'%field%',
							'%value%'
							],
							[
							$this->table,
							join(',',array_keys($data)),
							join(',',array_values($data))
							],$sql);
		return $this->exec($sql,$insertId);
	}

	/**
	 * [delete 删除]
	 * @return [布尔值] [删除成功返回true，失败返回false]
	 */
	public function deleteSome () {
		if (!$this->options['where']) {
			return '删除时必须添加条件';
		}
		$sql = 'delete from %table% %where%';
		$sql = str_replace([
							'%table%',
							'%where%'
							]
							,
							[
							$this->options['table'],
							$this->options['where']
							],$sql);
		return $this->exec($sql,false);
	}

	/**
	 * [update 更新数据]
	 * @param  array  $data [需要更新的数据]
	 * @return [type]       [更新成功返回true，失败返回false]
	 */
	public function update (array $data) {
		if (!$this->options['where']) {
			return '更新数据必须有条件';
		}

		$sql = 'update %table% set %data% %where% ;';

		//给数组中的值为字符串的加引号
		$data = $this->addQuote($data);

		//过滤无效字符段
		$data = $this->validField($data);

		//转换更新条件为字符串
		$str = '';
		foreach ($data as $key => $value) {
			$str .=$key . '=' . $value . ',';
		}
		$str = rtrim($str,',');

		//替换sql中的关键字
		$sql = str_replace([
							'%table%',
							'%data%',
							'%where%'
							],
							[
							$this->options['table'],
							$str,
							$this->options['where']
							],$sql);

		return $this->exec($sql,false);
	}

	/**
	 * [exec 无数据返回---执行sql语句]
	 * @param  [type]  $sql      [SQL语句]
	 * @param  boolean $insertId [是否需要返回主键]
	 * @return [type]            [成功返回true，失败返回false]
	 */
	public function exec($sql,$insertId=true) {
		$this->sql = $sql;
		$result = mysqli_query($this->link,$sql);

		//初始化查询条件
		$this->options = $this->initOptions();
		
		if ($result && $insertId) {
			return mysqli_insert_id($this->link);
		}
		return $result;
	}

	/**
	 * [query 有数据返回---执行sql语句]
	 * @param  [type] $sql        [需要执行的语句]
	 * @param  [type] $resultType [需要返回数据的类型]
	 * @return [array]             [查询得到的数据]
	 */
	public function query($sql,$resultType=MYSQLI_ASSOC) {
		//保存sql语句
		$this->sql = $sql;
		//重新初始化查询数组
		$this->options = $this->initOptions();

		//查询
		$result = mysqli_query($this->link,$sql);
		if ($result && mysqli_affected_rows($this->link)>0) {
			return mysqli_fetch_all($result,$resultType);
		}
		return false;
	}

	public function field ($field) {
		if(is_string($field)) {
			$this->options['field'] = $field;
		}else if (is_array($field)) {
			$this->options['field'] = join(',',$field);
		}
		return $this;
	}

	public function table ($table) {
		if (is_string($table)) {
			$table = explode(',',$table);
		}
		$tmp = [];
		foreach ($table as $value) {
				$tmp[] = $this->prefix . ltrim($value,$this->prefix); 
			}
			$this->options['table'] = join(',',$tmp);
			$this->table = $this->options['table'];
		return $this;
	}

	public function where ($where) {
		if ($this->options['where']) {
			if (is_string($where)) {
			$this->options['where'] .= ' and ' . $where;
			} else if(is_array($where)) {
				$this->options['where'] .=' and ' . join(' and ',$where);
			}
		} else {
			if (is_string($where)) {
			$this->options['where'] = ' where ' . $where;
			} else if(is_array($where)) {
				$this->options['where'] = ' where ' . join(' and ',$where);
			}
		}
		return $this;
	}

	public function whereor ($whereor) {
		if ($this->options['where']) {
			if (is_string($whereor)) {
			$this->options['where'] .= ' or ' . $whereor;
			} else if(is_array($whereor)) {
				$this->options['where'] .=' or ' . join(' or ',$whereor);
			}
		} else {
			if (is_string($whereor)) {
			$this->options['where'] = ' where ' . $whereor;
			} else if(is_array($whereor)) {
				$this->options['where'] = ' where ' . join(' or ',$whereor);
			}
		}
		return $this;
	}

	public function groupby ($groupby) {
		if (is_string($groupby)) {
			$this->options['groupby'] = ' group by ' . $groupby;
		}else if (is_array($groupby)) {
			$this->options['groupby'] = ' group by ' . join(',',$groupby);
		}
		return $this;
	}

	public function having ($having) {
		if (is_string($having)) {
			$this->options['having'] = ' having ' . $having;
		}else if (is_array($having)) {
			$this->options['having'] = ' having ' . join(' and ',$having);
		}
		return $this;
	}

	public function orderby($orderby) {
		if (is_string($orderby)) {
			$this->options['orderby'] = ' order by ' . $orderby;
		}else if (is_array($orderby)) {
			$this->options['orderby'] = ' order by ' . join(',',$orderby);
		}
		return $this;
	}

	public function limit($limit) {
		if (is_string($limit)) {
			$this->options['limit'] = ' limit ' . $limit;
		}else if (is_array($limit)) {
			$this->options['limit'] = ' limit ' . join(',',$limit);
		}
		return $this;
	}

	protected function connect() {
		$link = mysqli_connect($this->host,$this->user,$this->password,$this->dbname);
		if (!$link) {
			exit('数据库链接失败');
		}

		if (!mysqli_set_charset($link,$this->charset)) {
			exit('字符集设置失败');
		}
		return $link;
	}

	protected function getTable() {
		//如果属性table有默认值，直接返回
		if ($this->table) {
			return $this->prefix . ltrim($this->table,$this->prefix);
		}

		//如果没有默认值
		$calssName = explode('\\',get_class($this));
		$className = strtolower(array_pop($calssName));
		$calssName = rtrim($className,'model');//兼容之前没有命名空间的model类
		return $this->prefix . $className;
	}

	protected function checkDir($dir) {
		if (!is_dir($dir)) {
			return mkdir($dir,0777,true);
		} else if (!is_writable($dir) || !is_readable($dir)) {
			 return chmod($dir,0777);
		}
		return true;
	}

	protected function initCache() {
		$path = rtrim($this->cache,'/') . '/' . $this->table . '.php';
		if (file_exists($path)) {
			return include $path;
		}

		//查询表结构
		$sql = ' desc ' . $this->table;
		$result = mysqli_query($this->link,$sql);
		if ($result && mysqli_affected_rows($this->link)>0) {
			while ($data = mysqli_fetch_assoc($result)) {
				$field[] = $data['Field'];
				if ($data['Key'] == 'PRI') {
					$field['key'] = $data['Field'];
				}
			}
		}
		$content = "<?php \n return " . var_export($field,true) . ';';
		file_put_contents($path, $content);
		return $field;
	}

    /**
     * @return array
     */
    protected function initOptions() {
		if ($this->cacheFields) {
			$data = $this->cacheFields;
			unset($data['key']);
			$fields = join(',',$data);
			return [
					'field' 	=>$fields,
					'table'     => $this->table,
					'where' 	=>'',
					'groupby' 	=>'',
					'having' 	=>'',
					'orderby' 	=>'',
					'limit' 	=>'',
					];
		}
		return [
				'field' 	=>'*',
				'table'     => $this->table,
				'where' 	=>'',
				'groupby' 	=>'',
				'having' 	=>'',
				'orderby' 	=>'',
				'limit' 	=>'',
				];
	}

	protected function addQuote($data) {
		foreach ($data as $key => $value) {
			if (is_string($value)) {
				$data[$key] = "'$value'";
			} else {
				$data[$key] = $value;
			}
		}
		return $data;
	}

    protected function validField($data) {
		//交换输入数据的键值对
		$cacheFields = array_flip($this->cacheFields);

		//以第一个数组为基准，查找两个数组共有的键，然后将第一个数组中该键对应的值返回至新数组
		$data = array_intersect_key($data,$cacheFields);
		return $data;
	}	
}
