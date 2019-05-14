<?php
namespace framework\core;

/**
 * Request类
 */
class Request
{
	function __construct()
	{
		# code...
	}

	public static function isPost()
	{
		return isset($_SERVER['REQUEST_METHOD']) && !strcasecmp($_SERVER['REQUEST_METHOD'],'POST');
	}

	public static function isGet()
	{
		return isset($_SERVER['REQUEST_METHOD']) && !strcasecmp($_SERVER['REQUEST_METHOD'],'GET');
	}

	public static function isAjax()
	{
		return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') ? true : false;
	}

	public static function post($name = null, $set_value = '')
	{
		if (!$name) {
			return $_POST;
		}
		
		return !isset($_POST[$name]) ? $set_value : ($_POST[$name] ?: $set_value);
	}

	public static function get($name = null, $set_value = '')
	{
		if (!$name) {
			return $_GET;
		}
		
		return !isset($_GET[$name]) ? $set_value : ($_GET[$name] ?: $set_value);
	}
}