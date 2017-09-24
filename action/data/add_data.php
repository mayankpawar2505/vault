<?php
	session_start();
	include_once('../functions.php');
	if($_POST['token'] == $_SESSION['token']){
		$data = [
					'table' => 'data',  
	             	'column_name' => ['title', 'body', 'enc_key', 'category_id'],
	             	'column_value' => [$_POST['title'], $_POST['body'], $_POST['k'], $_POST['category_id']],
	             	'column_type' => ['s','s','s','s']
	            ];
		$resp = set_data($data);
		echo json_encode($resp);
	}
?>