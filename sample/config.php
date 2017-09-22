<?php

	$host = 'localhost';

	$username = 'devteste_mayank';

	$password = 'm@Demo123';

	$database = 'devteste_pro199';



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

?>