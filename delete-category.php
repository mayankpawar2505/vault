<?php
	session_start();
  	include_once('action/functions.php');
  	$data = [
  				'table' => 'categories',
  				'where' => ['id'=>base64_decode($_GET['data']), 'user_id' => $_SESSION['id']]
  			];

  	$resp = delete_data($data);
  	if($resp == true){
  	
  	}else{
  		$_SESSION['error'] = 'Not Allowed to delete this category';
  	}
  	header('location:dashboard.php');
?>