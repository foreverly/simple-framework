<?php
// namespace framework\core;

//核心启动类
class Framework {
	//run方法
	public static function run(){
		// echo "hello,world!";
		self::init();
		// self::autoload();
		// self::dispatch();
	}


	//	初始化方法
	private static function init(){

		// 获取路由
		$router = trim($_SERVER['REQUEST_URI'], '/');
		// 将路由按/分割赋值
		list($controllerName, $actionName) = explode('/', $router);

		//路径的常量
		define("DS", 					DIRECTORY_SEPARATOR);
		define("ROOT", 					getcwd() . DS); //根路径
		define("APP_PATH", 				ROOT . ".." . DS);

		define("FRAMEWORK_PATH",		ROOT . "../../framework" . DS);
		define("PUBLIC_PATH", 			ROOT . "public" . DS);
		define("CONFIG_PATH", 			APP_PATH . "config" . DS);
		define("CONTROLLER_PATH", 		APP_PATH . "controller" . DS);
		define("MODEL_PATH", 			APP_PATH . "model" . DS);
		define("VIEW_PATH", 			APP_PATH . "view" . DS);
		define("CORE_PATH", 			FRAMEWORK_PATH . "core" . DS);
		define("DB_PATH", 				FRAMEWORK_PATH . "database" . DS);
		define("LIB_PATH", 				FRAMEWORK_PATH . "library" . DS);
		define("HELPER_PATH", 			FRAMEWORK_PATH . "helper" . DS);
		define("UPLOAD_PATH", 			PUBLIC_PATH . "uploads" . DS);
		//index.php?p=admin&c=goods&a=add--后台的GoodsController中的addAction
		define("CONTROLLER", 			$controllerName ? ucfirst($controllerName) : "Index" );
		define("ACTION", 				$actionName ? : "index" );

		//加载核心类
		include CORE_PATH . "Controller.php";
		include CORE_PATH . "Model.php";
		include DB_PATH . "Mysql.php";

		//载入配置文件
		$GLOBALS['config'] = include CONFIG_PATH. "config.php";


		//开启session
		session_start();
	}


	// //路由分发，说白了，实例化对象调用方法
	// //index.php?p=admin&c=goods&a=add--后台的GoodsController中的addAction
	// private static function dispatch(){
	// 	$controller_name = CONTROLLER . "Controller";
	// 	$action_name = ACTION . "Action";
	// 	//实例化对象
	// 	$controller = new $controller_name();
	// 	//调用方法
	// 	$controller->$action_name();
	// }


	// //自动载入
	// //此处，只加载application中的controller和model
	// private static function autoload(){
	// 	// spl_autoload_register(array(__CLASS__,'load'));
	// 	spl_autoload_register('self::load');


	// }


	// //完成指定类的加载
	// //只加载application中的controller和model,如GoodsController，BrandModel
	// public static function load($classname){
	// 	if (substr($classname, -10) == 'Controller') {
	// 		//控制器
	// 		include CUR_CONTROLLER_PATH . "{$classname}.class.php";
	// 	} elseif (substr($classname, -5) == 'Model') {
	// 		//模型
	// 		include MODEL_PATH . "{$classname}.class.php";
	// 	} else {
	// 		//暂略
	// 	}
	// }

}