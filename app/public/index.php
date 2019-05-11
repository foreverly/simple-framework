<?php
// namespace simple;

// define('ADMIN',true);
// // // 在开发时,声明一个DEBUG模式
// // define('DEBUG',true);  
// // //检测到处于开发模式 
// // if(defined('DEBUG')) { 
// // 	error_reporting(E_ALL);
// // } else { 
// // 	error_reporting(0);
// // }

// set_error_handler('my_error_handler');

// require_once __DIR__ . '/../../vendor/autoload.php';

// echo "<pre>";
// // var_dump($_SERVER);exit;

// // 获取路由
// $router = trim($_SERVER['REQUEST_URI'], '/');
// // 将路由按/分割赋值
// list($controllerName, $actionName) = explode('/', $router);
// // 首字母改成大写
// $ucController = ucfirst($controllerName);

// $controllerName = DIRECTORY_SEPARATOR . 'controller' . DIRECTORY_SEPARATOR . $ucController . 'Controller';

// if (file_exists(__DIR__ . '/..' . $controllerName . ".php")) {
// 	require_once __DIR__ . '/..' . $controllerName . ".php";
// }else{
// 	echo "控制器不存在";
// }


// $controller = new $controllerName();
// var_dump($controller);
// // if (!$controller) {
// //     trigger_error("出错了", E_USER_ERROR);
// // }

// // return call_user_func_array([$controller, 'action'. ucfirst($actionName)];

// // echo 'Hello, Simple Framework!';



// //admin为管理员的身份判定，true为管理员。
// //自定义的错误处理函数一定要有这４个输入变量$errno,$errstr,$errfile,$errline，否则无效。
// function my_error_handler($errno, $errstr, $errfile, $errline) {
//     //如果不是管理员就过滤实际路径
//     if (!ADMIN) {
//         $errfile = str_replace(getcwd(), "", $errfile);
//         $errstr = str_replace(getcwd(), "", $errstr);
//     }
 
//     switch ($errno) {
//         case E_ERROR:
//             echo "ERROR: [ID $errno] $errstr (Line: $errline of $errfile)";
//             echo "程序已经停止运行，请联系管理员。";
//             //遇到Error级错误时退出脚本
//             exit;
//         break;
//         case E_WARNING:
//             echo "WARNING: [ID $errno] $errstr (Line: $errline of $errfile)";
//         break;
//         default:
//         //不显示Notice级的错误
//         break;
//     }
// }

//载入核心启动类
include __DIR__ . "/../../framework/core/Framework.php";

Framework::run();
// $app = new Framework();
// $app->run();