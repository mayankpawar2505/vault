<?php
	if(isset($_POST) && !empty($_POST)){

		/* unique email id check */
		if($_POST['token'] == 'verify_email'){	
			include_once('../functions.php');

	        $data = [
		                'fields' => ['id'],
		                'table' => 'users',
		                'where' => ['email' => $_POST['email']],
		                'where_type' => ['s'] 
		            ];
			$resp = get_single_row_data($data);

			if(empty($resp)){
				echo "true";
			}else{
				echo "false";
			}
		}

		/* unique username check */
		if($_POST['token'] == 'verify_username'){	
			include_once('../functions.php');

	        $data = [
		                'fields' => ['id'],
		                'table' => 'users',
		                'where' => ['username' => $_POST['username']],
		                'where_type' => ['s'] 
		            ];
			$resp = get_single_row_data($data);

			if(empty($resp)){
				echo "true";
			}else{
				echo "false";
			}
		}


		/* User registration */
		if($_POST['token'] == 'user_register'){
			include_once('../functions.php');
			// prd($_POST);
			$data = [
						'table' => 'users',  
			            'column_name' => ['email', 'username', 'password', 'is_active', 'enc_key'],
			            'column_value' => [$_POST['email'], $_POST['username'], $_POST['password'], 0,$_POST['key']],
			            'column_type' => ['s','s','s','i','s']
			        ];

			$resp = set_data($data);
			echo json_encode($resp);
		}

		/* User login */
		if($_POST['token'] == 'user_login'){
			include_once('../functions.php');
			$data = [
	                    'fields' => ['id','username', 'password', 'is_active', 'enc_key'],
	                    'table' => 'users',
	                    'where' => [ 
	                    				'OR' => [
	                    					'username' => $_POST['username'], 'email' => $_POST['username']
	                    				]
	                    			],
	                    'where_type' => ['s','s'] 
	                ];

			$resp = get_single_row_data($data);

			if(isset($resp) && !empty($resp)){
				/* check user account is active */
				if($resp['is_active'] == 0){
					echo json_encode(['err' => 'Account is Inactive']);
				}else{
					include_once('../../vendors/cryptojs-aes-php-master/cryptojs-aes.php');
					$db_pass = cryptoJsAesDecrypt($resp["enc_key"], $resp["password"]);


					/* post details check */
					$post_pass = cryptoJsAesDecrypt($_POST["key"], $_POST["password"]);

					if($db_pass == $post_pass){
						/* login verified */
						/* Set session */
						session_start();
						$_SESSION['id'] = $resp['id'];
						$_SESSION['username'] = $resp['username'];
						$_SESSION['formStarted'] = true;
						$token = md5(uniqid(rand(), TRUE));
						$_SESSION['token'] = $token;
						
						echo json_encode(['resp' => 'true']);
					}else{
						/* invalid password */
						echo json_encode(['err' => 'Invalid Username or Password']);
					}
				}
			}else{
				/* invalid username */
				echo json_encode(['err' => 'Invalid Username or Password']);
			}
		}

	}
?>