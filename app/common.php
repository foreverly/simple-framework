<?php

// 应用公共文件

if (!function_exists("dd")) {
	function dd($data){
		echo "<pre>";
		print_r($data);
		echo "</pre>";
	}
}

if (!function_exists("ajaxSuccess")) {
	function ajaxSuccess(array $data, $msg = ''){
		$rdata = [
			'status' => 'success',
			'code' => 200,
			'data' => $data
		];

		if ($msg != '') {
			$rdata['msg'] = $msg;
		}
		
		echo json_encode($rdata);exit;
	}
}

if (!function_exists("ajaxError")) {
	function ajaxError($msg){
		$rdata = [
			'status' => 'error',
			'code' => -1,
			'msg' => $msg
		];

		echo json_encode($rdata);exit;
	}
}