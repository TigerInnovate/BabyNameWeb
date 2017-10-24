<?php
	//绑定手机号
	include 'model.class.php';
$ModelController = new ModelController();
	$mobile = $_POST['mobile'];
	$order_num = $_POST['order_num'];

	//修改预留的手机号
	if($ModelController->update_order_mobile($mobile, $order_num)){
		echo 'success';
	}else{
		echo 'fail';
	}