<?php
	session_start();
	include_once('../functions.php');
	if($_POST['token'] == $_SESSION['token']){
		$data = [
	                'table' => 'categories',
	                'columns' => ['category_name','enc_key'],
	                'column_value' => [$_POST['category_name'], $_POST['k']],
	                'where' => ['id' => base64_decode($_POST['id']), 'user_id' => $_SESSION['id']],
	                'column_type' => ['s','s','i','i']
	            ];
		$resp = update_data($data);
		echo json_encode($resp);
	}
?>