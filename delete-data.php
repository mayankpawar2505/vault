<?php
    session_start();
  	include_once('action/functions.php');
  	$data = [
      				'table' => 'data',
      				'where' => ['id'=>base64_decode($_GET['data'])]
      			];

  	$resp = delete_data($data);
  	if($resp == true){
  	
  	}else{
  		$_SESSION['error'] = 'Not Allowed to delete this category';
  	}
  	header('location:dashboard.php');
?>