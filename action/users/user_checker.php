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
			            'column_name' => ['email', 'username', 'password', 'is_active', 'enc_key', 'iv'],
			            'column_value' => [$_POST['email'], $_POST['username'], $_POST['password'], 0,$_POST['key'], $_POST['iv']],
			            'column_type' => ['s','s','s','i','s','s']
			        ];

			$resp = set_data($data);
			echo json_encode($resp);
		}

		/* User login */
		if($_POST['token'] == 'user_login'){
			include_once('../functions.php');
			// prd($_POST);
			$data = [
						'table' => 'users',  
			            'column_name' => ['email', 'username', 'password', 'is_active', 'enc_key', 'iv'],
			            'column_value' => [$_POST['email'], $_POST['username'], $_POST['password'], 0,$_POST['key'], $_POST['iv']],
			            'column_type' => ['s','s','s','i','s','s']
			        ];

			$resp = set_data($data);
			echo json_encode($resp);
		}

	}
?>