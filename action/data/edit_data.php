<?php
	session_start();
	include_once('../functions.php');
	if($_POST['token'] == $_SESSION['token']){
		$data = [
	                'table' => 'data',
	                'columns' => ['title','body','enc_key'],
	                'column_value' => [$_POST['title'], $_POST['body'], $_POST['k']],
	                'where' => ['id' => $_POST['id']],
	                'column_type' => ['s','s','s','i']
	            ];
		$resp = update_data($data,true);
		echo json_encode($resp);
	}
?>