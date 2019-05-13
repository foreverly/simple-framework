<?php
namespace framework\core;

//权限判断：以后的文件都会用到入口文件所定义的常量‘ACCESS’来判断
if (!defined('ACCESS')) 
{
    //非法访问权限
    header('Location:/index.php');
    die;
}

/**
 * 核心启动类
 */
class Framework {

	public static function run()
	{		
		self::init();
		self::setSysError();
		self::autoload();
		self::dispatch();
	}


	//	初始化方法
	private static function init()
	{

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
		define("VENDOR_PATH", 			ROOT . "../../vendor" . DS);
		//index.php?p=admin&c=goods&a=add--后台的GoodsController中的addAction
		define("CONTROLLER", 			$controllerName ? ucfirst($controllerName) : "Site" );
		define("ACTION", 				$actionName ? ucfirst($actionName) : "Index" );
		define("MODULE", 				end(explode(DIRECTORY_SEPARATOR, dirname(ROOT))));

		//加载核心类
		include CORE_PATH . "Controller.php";
		include CORE_PATH . "Model.php";
		include DB_PATH . "Database.php";

		//载入配置文件
		$GLOBALS['config'] = include CONFIG_PATH. "config.php";


		//开启session
		session_start();
	}

	/**
	 * 设定错误控制
	 */
    private static function setSysError(){
        //两种级别：级别显示，是否显示
        @ini_set('error_reporting', E_ALL);
        @ini_set('display_errors', 1);
    }


	/**
	 * 路由分发
	 */
	private static function dispatch(){
		$controller_name = CONTROLLER . "Controller";
		$action_name = "action" . ACTION;
		// $controller_name = "app\controller\\" . $controller_name;

		include CONTROLLER_PATH . "{$controller_name}.php";
		$new_path = MODULE . "\controller\\" . $controller_name;
		$controller = new $new_path();
		$controller->$action_name();

	}


	/**
	 * 自动加载
	 */	
	private static function autoload()
	{
		// 由self::load方法完成所有类的自动加载
		spl_autoload_register('self::load');
	}

	/**
	 * 完成指定类的加载
	 * 此处只加载application中的controller和model,如GoodsController，BrandModel
	 */
	public static function load($className)
	{
		// if (substr($className, -10) == 'Controller') {
		// 	//控制器
		// 	if (file_exists(CONTROLLER_PATH . "{$className}.php")) {
		// 		// var_dump(CONTROLLER_PATH);exit;
		// 		include CONTROLLER_PATH . "{$className}.php";
		// 	}
		// } else
		if (substr($className, -5) == 'Model') {
			//模型
			include MODEL_PATH . "{$className}.php";
		} else {
			$classMap = [
				'framework\\core\\Controller' => CORE_PATH . 'Controller.php',
				'framework\\core\\View' => CORE_PATH . 'View.php',
				'framework\\core\\Model' => CORE_PATH . 'Model.php',
				'framework\\core\\Database' => CORE_PATH . 'Database.php',
				// 'vendor\\smarty\\smarty\\libs\\Autoloader' => VENDOR_PATH . 'smarty\\smarty\\libs\\Autoloader',
			];

			// TODO  根目录下的类调用未排除，如Smarty会进入这里
			if (isset($classMap[$className])) {
				$classFile = $classMap[$className];

				if (file_exists($classFile)) {
					include $classFile;
				}
			}
		}
	}

}
?>