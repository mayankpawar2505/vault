<?php
	include_once('../config.php');

	function test(){
		global $mysqli;
		print_r($mysqli);
		die('heree');
	}

	test();