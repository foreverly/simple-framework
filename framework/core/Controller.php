<?php
namespace framework\core;

use framework\core\View;

/**
 * Controller基类
 */
class Controller
{
	protected $view;

	function __construct()
	{
		$this->view = new View();
	}


	/**
	 * 加载模板输出
	 * @return $this
	 */
	protected function fetch($template = '', $vars = [], $config = [])
	{
		// TODO 调用视图类处理渲染操作
		return $this->view->fetch($template, $vars, $config);
	}

	/**
     * 模板变量赋值
     * @access protected
     * @param  mixed $name  要显示的模板变量
     * @param  mixed $value 变量的值
     * @return $this
     */
    protected function assign($name, $value = '')
    {
        return $this->view->assign($name, $value);
    }
}