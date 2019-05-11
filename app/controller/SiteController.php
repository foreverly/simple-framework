<?php
namespace app\controller;
// use Simple\Controller;

/**
 * 
 */
// class SiteController extends Controller
class SiteController
{
	
	public function __construct()
	{
		echo "site init";
	}

	public function actionIndex()
	{
		echo "site index";
	}
}