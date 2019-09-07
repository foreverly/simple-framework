<?php
namespace framework\core;

/**
 * DB类
 */
class Database
{
	private $dsn;
    private $sth;
    private $dbh;
    private $user;
    private $charset;
    private $password;

    public $lastSQL = '';

    public function __setup($config = array())
    {
        $this->dsn = 'mysql:dbname=sql2019_dj95_co;host=47.52.150.127';
        $this->user = 'sql2019_dj95_co';
        $this->password = 'E7fe3cxEHm';
        $this->charset = 'utf8';
        $this->connect();
    }

    private function connect()
    {
        if(!$this->dbh){
            $options = array(
                \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES ' . $this->charset,
            );
            $this->dbh = new \PDO($this->dsn, $this->user,
                $this->password, $options);
        }
    }

    public function beginTransaction()
    {
        return $this->dbh->beginTransaction();
    }

    public function inTransaction()
    {
        return $this->dbh->inTransaction();
    }

    public function rollBack()
    {
        return $this->dbh->rollBack();
    }

    public function commit()
    {
        return $this->dbh->commit();
    }

    function watchException($execute_state)
    {
        if(!$execute_state){
            throw new MySQLException("SQL: {$this->lastSQL}\n".$this->sth->errorInfo()[2], intval($this->sth->errorCode()));
        }
    }

    public function fetchAll($sql, $parameters=[])
    {
        $result = [];
        $this->lastSQL = $sql;
        $this->sth = $this->dbh->prepare($sql);
        $this->watchException($this->sth->execute($parameters));
        while($result[] = $this->sth->fetch(\PDO::FETCH_ASSOC)){ }
        array_pop($result);
        return $result;
    }

    public function fetchColumnAll($sql, $parameters=[], $position=0)
    {
        $result = [];
        $this->lastSQL = $sql;
        $this->sth = $this->dbh->prepare($sql);
        $this->watchException($this->sth->execute($parameters));
        while($result[] = $this->sth->fetch(\PDO::FETCH_COLUMN, $position)){ }
        array_pop($result);
        return $result;
    }

    public function exists($sql, $parameters=[])
    {
        $this->lastSQL = $sql;
        $data = $this->fetch($sql, $parameters);
        return !empty($data);
    }

    public function query($sql, $parameters=[])
    {
        $this->lastSQL = $sql;
        $this->sth = $this->dbh->prepare($sql);
        $this->watchException($this->sth->execute($parameters));
        return $this->sth->rowCount();
    }

    public function fetch($sql, $parameters=[], $type=\PDO::FETCH_ASSOC)
    {
        $this->lastSQL = $sql;
        $this->sth = $this->dbh->prepare($sql);
        $this->watchException($this->sth->execute($parameters));
        return $this->sth->fetch($type);
    }

    public function fetchColumn($sql, $parameters=[], $position=0)
    {
        $this->lastSQL = $sql;
        $this->sth = $this->dbh->prepare($sql);
        $this->watchException($this->sth->execute($parameters));
        return $this->sth->fetch(\PDO::FETCH_COLUMN, $position);
    }

    public function update($table, $parameters=[], $condition=[])
    {
        $table = $this->format_table_name($table);
        $sql = "UPDATE $table SET ";
        $fields = [];
        $pdo_parameters = [];
        foreach ( $parameters as $field=>$value){
            $fields[] = '`'.$field.'`=:field_'.$field;
            $pdo_parameters['field_'.$field] = $value;
        }
        $sql .= implode(',', $fields);
        $fields = [];
        $where = '';
        if(is_string($condition)) {
            $where = $condition;
        } else if(is_array($condition)) {
            foreach($condition as $field=>$value){
                $parameters[$field] = $value;
                $fields[] = '`'.$field.'`=:condition_'.$field;
                $pdo_parameters['condition_'.$field] = $value;
            }
            $where = implode(' AND ', $fields);
        }
        if(!empty($where)) {
            $sql .= ' WHERE '.$where;
        }
        return $this->query($sql, $pdo_parameters);
    }

    public function insert($table, $parameters=[])
    {
        $table = $this->format_table_name($table);
        $sql = "INSERT INTO $table";
        $fields = [];
        $placeholder = [];
        foreach ( $parameters as $field=>$value){
            $placeholder[] = ':'.$field;
            $fields[] = '`'.$field.'`';
        }
        $sql .= '('.implode(",", $fields).') VALUES ('.implode(",", $placeholder).')';

        $this->lastSQL = $sql;
        $this->sth = $this->dbh->prepare($sql);
        $this->watchException($this->sth->execute($parameters));
        $id = $this->dbh->lastInsertId();
        if(empty($id)) {
            return $this->sth->rowCount();
        } else {
            return $id;
        }
    }

    public function errorInfo()
    {
        return $this->sth->errorInfo();
    }

    protected function format_table_name($table)
    {
        $parts = explode(".", $table, 2);

        if(count($parts) > 1) {
            $table = $parts[0].".`{$parts[1]}`";
        } else {
            $table = "`$table`";
        }
        return $table;
    }

    function errorCode()
    {
        return $this->sth->errorCode();
    }

	// private $host;
	// private $name;
	// private $port;
	// private $user;
	// private $pass;
	// private $_db;
	// private static $_instance;
	
	/**
	 * 私有构造函数，防止外部重新构造
	 */
	// private function __construct($config = array())
	// {
	// 	// $this->host = '47.106.209.53';
	// 	$this->host = '47.52.150.127'; // DJ网
	// 	$this->name = 'sql2019_dj95_co';
	// 	$this->user = 'sql2019_dj95_co';
	// 	$this->pass = 'E7fe3cxEHm';
	// 	$this->port = '3306';
	// 	// self::$host = $GLOBALS['config']['DB_HOST'];
	// 	// self::$name = $GLOBALS['config']['DB_NAME'];
	// 	// self::$port = $GLOBALS['config']['DB_PORT'];
	// 	// self::$user = $GLOBALS['config']['DB_USER'];
	// 	// self::$pass = $GLOBALS['config']['DB_PASS'];
	// 	$this->_db = $this->connect();
	// }

	// /**
	//  * 复写克隆方法，禁止克隆
	//  */
	// private function __clone() {}

	// public static function getInstance()
 //    {
 //        if(!self::$_instance instanceof self)
 //        {
 //            self::$_instance = new self; // 若当前对象实例不存在
 //        }
 //        // $db = self::$_instance; // 获取当前单例        
 //        // return $db::connect() ;  // 调用对象私有方法连接 数据库
 //        return self::$_instance;
 //    }

 //    /**
 //     * 销毁自己的操作类时，同时销毁被创建了的PDO对象
 //     */
 //    public function __destruct()
 //    {
 //        $this->pdo = null;
 //    }

 //    /**
 //     * 连接到数据库
 //     */
 //    private function connect()
 //    {
 //        try {
 //        	// mysql方式连接
 //            // $connect = @mysql_connect($this->host, $this->user, $this->pass);   //数据库地址和密码等
 //            // if (!$connect) {
 //            // 	die("could not connect to the database:\n" . mysql_error());
 //            // }
 //            // mysql_query("set names 'utf8'");//编码转化
 //            // // 选择数据库
 //            // if (! @mysql_select_db($this->name)) {
 //            // 	die("could not connect to the db:\n" .  mysql_error());
 //            // }
 //            // mysqli方式连接
 //        	// $connect = @new mysqli($this->host, $this->user, $this->pass);
	// 		// if ($connect->connect_errno) {
	// 		// 	die("could not connect to the database:\n" . $connect->connect_error);
	// 		// }
	// 		// $connect->query("set names 'utf8';");//编码转化
	// 		// if (!$connect->select_db($this->name);) {
	// 		// 	die("could not connect to the db:\n" .  $connect->error);
	// 		// }
	// 		// PDO方式连接
	// 		$dsn = "mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->name;
	// 		$connect = new \PDO($dsn, $this->user, $this->pass);
	// 		$connect->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);//异常错误模式
	// 		$connect->exec("set names 'utf8'");
	// 	} catch (Exception $e) {
	// 		echo $e->getMessage().'<br/>';exit;
	// 	}
	// 	return $connect;        
 //    }

 //    /**
 //     * 只支持 ? 占位符的方式，参数数组为一维按参数顺序
 //     */
 //    public function query($sql = '', $values = [])
 //    {
 //    	$pdo = $this->_db;
 //    	$stmt = $pdo->prepare($sql);
	// 	foreach ($values as $key => $value) {
	// 		$stmt->bindValue($key+1, $value, \PDO::PARAM_STR);
	// 	}
	// 	$rs = $stmt->execute();
	// 	var_dump(1);
	// 	$data = [];
	// 	if ($rs) {
	// 	    // PDO::FETCH_ASSOC 关联数组形式
	// 	    // PDO::FETCH_NUM 数字索引数组形式
	// 	    // while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
	// 	    //     $data[] = $row;
	// 	    // }
	// 		$i = 1;
	// 	    while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
	// 	    	if($i >=10) {
	// 	var_dump($data);exit;
	// 	    	}
	// 	        $data[] = $row;
	// 	        $i++;
	// 	    }
	// 	}
	// 	var_dump($data);exit;
	// 	$pdo = null;
	// 	return $data;
 //    }

 //    /**
 //     * 只支持 ? 占位符的方式，参数数组为一维按参数顺序
 //     */
 //    public function insert($sql = '', $values = [])
 //    {
 //    	$pdo = $this->_db;
 //    	$stmt = $pdo->prepare($sql);
	// 	foreach ($values as $key => $value) {
	// 		$stmt->bindValue($key+1, $value, \PDO::PARAM_STR);
	// 	}

	// 	$rs = $stmt->execute();
	// 	$id = $rs ? (int)$pdo->lastInsertId() : null;
	// 	$pdo = null;

	// 	return $id;
 //    }

 //    /**
 //     * 只支持 ? 占位符的方式，参数数组为一维按参数顺序
 //     */
 //    public function update($sql = '', $values = [])
 //    {
 //    	$pdo = $this->_db;
 //    	$stmt = $pdo->prepare($sql);
	// 	foreach ($values as $key => $value) {
	// 		$stmt->bindValue($key+1, $value, \PDO::PARAM_STR);
	// 	}

	// 	$rs = $stmt->execute();
	// 	$pdo = null;

	// 	return $stmt->rowCount();
 //    }
}
