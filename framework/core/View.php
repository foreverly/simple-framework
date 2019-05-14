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
			// 设置左右界定符
			$this->smarty->left_delimiter  = $GLOBALS['config']['SMARTY_LEFT'];
			$this->smarty->right_delimiter  = $GLOBALS['config']['SMARTY_RIGHT'];
		}else{
			die("模板引擎不存在");
		}
	}

	/**
	 * 加载模板输出
	 */
	public function fetch($template = '')
	{
		// 引入模板文件
		if (!$template) {
			$tpl_path = APP_PATH . 'view' . DIRECTORY_SEPARATOR . strtolower(CONTROLLER) . DIRECTORY_SEPARATOR . "index.html";

			return $this->smarty->fetch($tpl_path);
		}
	}

	/**
	 * 加载模板输出
	 */
	public function display($template = '')
	{
		$tpl_path = APP_PATH . 'view' . DIRECTORY_SEPARATOR;
		// 引入模板文件
		if (!$template) {
			$tpl_path .= strtolower(CONTROLLER) . DIRECTORY_SEPARATOR . "index.html";
		}else{
			$path_arr = explode('/', $template);
			if (FALSE === strpos($template, '/')) {
				$tpl_path .= strtolower(CONTROLLER) . DIRECTORY_SEPARATOR . $template;
			}else{
				$tpl_path .= strtolower($path_arr[0]) . DIRECTORY_SEPARATOR . $path_arr[1];
			}
		}

		$this->smarty->display($tpl_path);
	}

	/**
     * 模板变量赋值
     */
    public function assign($name, $value = '')
    {
        return $this->smarty->assign($name, $value);
    }
}