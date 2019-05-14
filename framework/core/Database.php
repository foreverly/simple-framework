<?php
namespace framework\core;

/**
 * DB类
 */
class Database
{
	private $host;
	private $name;
	private $port;
	private $user;
	private $pass;

	private $_db;
	private static $_instance;
	
	/**
	 * 私有构造函数，防止外部重新构造
	 */
	private function __construct()
	{
		$this->host = $GLOBALS['config']['DB_HOST'];
		$this->name = $GLOBALS['config']['DB_NAME'];
		$this->port = $GLOBALS['config']['DB_PORT'];
		$this->user = $GLOBALS['config']['DB_USER'];
		$this->pass = $GLOBALS['config']['DB_PASS'];
		// self::$host = $GLOBALS['config']['DB_HOST'];
		// self::$name = $GLOBALS['config']['DB_NAME'];
		// self::$port = $GLOBALS['config']['DB_PORT'];
		// self::$user = $GLOBALS['config']['DB_USER'];
		// self::$pass = $GLOBALS['config']['DB_PASS'];

		$this->_db = $this->connect();
	}

	/**
	 * 复写克隆方法，禁止克隆
	 */
	private function __clone() {}

	public static function getInstance()
    {
        if(!self::$_instance instanceof self)
        {
            self::$_instance = new self; // 若当前对象实例不存在
        }

        // $db = self::$_instance; // 获取当前单例        
        // return $db::connect() ;  // 调用对象私有方法连接 数据库
        return self::$_instance;
    }

    /**
     * 连接到数据库
     */
    private function connect()
    {
        try {        	
        	// mysql方式连接
            // $connect = @mysql_connect($this->host, $this->user, $this->pass);   //数据库地址和密码等
            // if (!$connect) {
            // 	die("could not connect to the database:\n" . mysql_error());
            // }
            // mysql_query("set names 'utf8'");//编码转化
            // // 选择数据库
            // if (! @mysql_select_db($this->name)) {
            // 	die("could not connect to the db:\n" .  mysql_error());
            // }

            // mysqli方式连接
        	// $connect = @new mysqli($this->host, $this->user, $this->pass);
			// if ($connect->connect_errno) {
			// 	die("could not connect to the database:\n" . $connect->connect_error);
			// }
			// $connect->query("set names 'utf8';");//编码转化
			// if (!$connect->select_db($this->name);) {
			// 	die("could not connect to the db:\n" .  $connect->error);
			// }

			// PDO方式连接
			$dsn = "mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->name;
			$connect = new \PDO($dsn, $this->user, $this->pass);
			$connect->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);//异常错误模式
			$connect->exec("set names 'utf8'");

		} catch (Exception $e) {
			echo $e->getMessage().'<br/>';    
		}

		return $connect;        
    }

    /**
     * 只支持 ? 占位符的方式，参数数组为一维按参数顺序
     */
    public function query($sql = '', $values = [])
    {
    	$pdo = $this->_db;

    	$stmt = $pdo->prepare($sql);
		foreach ($values as $key => $value) {
			$stmt->bindValue($key+1, $value, \PDO::PARAM_STR);
		}

		$rs = $stmt->execute();
		$data = [];
		if ($rs) {
		    // PDO::FETCH_ASSOC 关联数组形式
		    // PDO::FETCH_NUM 数字索引数组形式
		    while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
		        $data[] = $row;
		    }
		}

		$pdo = null;

		return $data;
    }
}