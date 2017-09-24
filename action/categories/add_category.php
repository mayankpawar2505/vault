<?php
	session_start();
	include_once('../functions.php');
	if($_POST['token'] == $_SESSION['token']){
		$data = [
					'table' => 'categories',  
	             	'column_name' => ['category_name', 'enc_key', 'user_id'],
	             	'column_value' => [$_POST['category_name'], $_POST['k'], $_SESSION['id']],
	             	'column_type' => ['s','s','i']
	            ];
		$resp = set_data($data);
		echo json_encode($resp);
	}
?>