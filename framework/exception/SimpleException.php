<?php
namespace framework\exceptions;

/**
 * SimpleException
 */
class SimpleException extends \Exception
{
	
	function __construct()
	{
		# code...
	}

	/**
     * @param $exception
     */
    public function getErrorInfo($exception)
    {
        $err = [
            'code' => $exception->getCode(),
            'msg'  => $exception->getMessage(),
            'file'    => $exception->getFile(),
            'line'   => $exception->getLine(),
            'class' => get_class($exception)
        ];
        $err = json_encode($err);
        echo $err;
        Log::info($err);
    }
    /**
     *
     */
    public function render()
    {
        // whoops 错误提示
        $whoops = new \Whoops\Run;
        $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
        $whoops->register();
        //自定义错误格式
        //set_exception_handler([$this, 'getErrorInfo']);
    }
}