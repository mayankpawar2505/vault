<?php

	$host = 'localhost';

	$username = 'root';

	$password = '';

	$database = 'vault';



  // $mysqli->close();



	$mysqli = new mysqli($host,$username,$password,$database);

	

	// Check connection

	if ($mysqli->connect_errno){

  		echo "Failed to connect to MySQL: " . $mysqli->connect_error;

  	}



  	function pr($val){

  		echo "<pre>";

  		print_r($val);

  		echo "</pre>";

  	}

  	function prd($val){

  		echo "<pre>";

  		print_r($val);

  		echo "</pre>";

  		die;

  	}

  	function csrf(){
  		$token = '';
  		if (!isset($_SESSION)) {
		    session_start();
			$_SESSION['formStarted'] = true;
		}
		if (!isset($_SESSION['token'])){
			$token = md5(uniqid(rand(), TRUE));
			$_SESSION['token'] = $token;
		}
		if(isset($token) && !empty($token))
			echo '<input type="hidden" name="csrf_token" value="'.$token.'" />';
		else
			echo 'asd';
  	}

?>