<?php
namespace framework\core;

class View
{
	protected $smarty;

	/**
	 * init
	 */
	public function __construct()
	{
		if (file_exists(VENDOR_PATH . "smarty/smarty/libs/Autoloader.php")) {

			include VENDOR_PATH . "smarty/smarty/libs/Autoloader.php";

			\Smarty_Autoloader::register();

			$this->smarty = new \Smarty(); // 实例化
		}else{
			die("模板引擎不存在");
		}
	}

	/**
	 * 加载模板输出
	 */
	public function fetch($template = '', $vars = [], $config = [])
	{
		// 引入模板文件
		if (!$template) {
			$tpl_path = APP_PATH . 'view' . DIRECTORY_SEPARATOR . strtolower(CONTROLLER) . DIRECTORY_SEPARATOR . "index.html";

			return $this->smarty->fetch($tpl_path);
		}
	}

	/**
     * 模板变量赋值
     */
    protected function assign($name, $value = '')
    {
        return $this->smarty->assign($name, $value);
    }
}