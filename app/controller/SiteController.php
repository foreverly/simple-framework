<?php
namespace app\controller;
// use Simple\Controller;
use framework\core\Database as DB;
use framework\core\Controller;
use framework\core\Request;

class SiteController extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function actionIndex()
	{
		$this->assign('Name', 'test');
		
		// 加载view中与控制器同名的文件夹下的任意模板
		// return $this->display('test.html');
		// 加载view中指定的文件夹下的任意模板
		return $this->display('test/a.html');
		// 默认加载view中与控制器同名的文件夹下的index.html
		// return $this->display();
	}

	public function getInfo()
	{
		$db = DB::getInstance();
		$res = $db->query("select * from `user`");

		return ajaxSuccess($res);
	}
}