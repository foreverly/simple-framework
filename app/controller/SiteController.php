<?php
namespace app\controller;
// use Simple\Controller;
use framework\core\Controller;

class SiteController extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function actionIndex()
	{
		return $this->fetch();
	}
}