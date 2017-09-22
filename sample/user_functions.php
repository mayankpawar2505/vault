<?php
	function generate_username($fname){
        $data;
        $split[0] = strtolower(explode(' ', $fname)[0]);
        for($i=0; $i<3; $i++){
            $split[1] = rand(1, 99);
            $data[] = implode('', $split);
        }
        return $data;
    }

    function check_username($mysqli, $username){
        /* Check username generated */
        if($stmt = $mysqli->prepare('SELECT id FROM user_logins WHERE username IN (?)')){
            $unm = implode(', ', $username);
            $stmt->bind_param("s", $unm);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if($result->num_rows > 0){
              $stmt->free_result();
              return false;
            }else{
                  $stmt->free_result();
                  return true;
            }
        }else{
            return false;
        }
    }

    function check_disposable_emails($mail){
        $mail_domains_ko = file('../../config/disposable-email-domains-master/disposable_email_blacklist.conf', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        //Need to ensure the mail contains an @ to avoid undefined offset
        return in_array(explode('@', $mail)[1], $mail_domains_ko);
    }

	function check_email_and_username($mysqli, $email, $username){
		if($stmt = $mysqli->prepare('SELECT id FROM user_logins WHERE email = ? || username = ?' )){
            $stmt->bind_param("ss", $email,$username);
            $stmt->execute();
            $result = $stmt->get_result();
            if($result->num_rows>0){
				$stmt->free_result();	
            	return true;
            }else{
				$stmt->free_result();	
            	return false;
            }
        }else{
        	return false;
        }
	}

    function check_verify_token($mysqli,$token){
        if($stmt = $mysqli->prepare('SELECT id, name, email, username, user_type_id, token_id, status, modified FROM user_logins WHERE verification_code = ? ' )){
            $stmt->bind_param("s", $token);
            $stmt->execute();
            $result = $stmt->get_result();
            if($result->num_rows>0){
                $row = $result->fetch_array(MYSQLI_ASSOC);
                $stmt->free_result();
                $stmt->close();
                return $row;
            }else{
                $stmt->free_result();   
                return false;
            }
        }else{
            return false;
        }
    }

    // Function to get the client ip address
    function get_client_ip_env() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
     
        return $ipaddress;
    }

    // Function to get the client ip address
    function get_client_ip_server() {
        $ipaddress = '';
        if ($_SERVER['HTTP_CLIENT_IP'])
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if($_SERVER['HTTP_X_FORWARDED_FOR'])
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if($_SERVER['HTTP_X_FORWARDED'])
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if($_SERVER['HTTP_FORWARDED_FOR'])
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if($_SERVER['HTTP_FORWARDED'])
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if($_SERVER['REMOTE_ADDR'])
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
     
        return $ipaddress;
    }

    function get_blocked_ip_status($mysqli,$ip){
        if($stmt = $mysqli->prepare('SELECT id, ip, status, blocked_till, created, modified FROM blocked_ips WHERE ip = ? ORDER BY id DESC LIMIT 1' )){
            $stmt->bind_param("i", $ip);
            $stmt->execute();
            $result = $stmt->get_result();
            if($result->num_rows>0){
                $row = $result->fetch_array(MYSQLI_ASSOC);
                $stmt->free_result();
                $stmt->close();
                return $row;
            }else{
                $stmt->free_result();   
                return false;
            }
        }else{
            return false;
        }
    }

    function get_invalid_attempts_by_ip($mysqli, $ip, $time, $duration){
        if($time != 'FOREVER'){
            $attempt_type = 'verification code';
            $result = $mysqli->query('SELECT id FROM invalid_attempts WHERE client_ip_server="'.$ip.'" AND TIMESTAMPDIFF('.$duration.',created,NOW()) <= '.$time.' AND attempt_type = "'.$attempt_type.'"');
            if($result->num_rows > 0){
                $row = $result->fetch_all(MYSQLI_ASSOC);
                $result->free();
                return $row;
                exit;
            }else{
                return false;
            }
        }else{

            return false;
        }
    }

    
    /* Select single row */
    function get_user_login_data($mysqli, $data){
        /*
            $data = [
                    'fields' => ['id', 'name', 'username', 'email', 'password', 'user_type_id', 'token_id', 'status'],
                    'table' => 'user_logins',
                    'where' => ['verification_code' => $_POST['token'], 'status' => '0'],
                    'where_type' => ['s','i'] 
                ];
        */

        $fields = implode(', ', $data['fields']);
        $table = $data['table'];

        $query = "SELECT $fields FROM $table ";

        if(isset($data['join_type']) && !empty($data['join_type'])){
            if(is_array($data['join_type'])){
                /* Code to join more than 2 tables */
                foreach ($data['join_type'] as $key => $join_type) {
                    $query .= ' '.$join_type.' '.$data['join_table'][$key].' ON '.$data['on'][$key];
                }
            }else{
                /* Code to join 2 tables */
                $query .= ' '.$data['join_type'].' '.$data['join_table'].' ON '.$data['on'];
            }
        }

        /* bind param special functions */
        $a_params = array();

        if(isset($data['where_type']) && !empty($data['where_type'])){
            $data_value_type = '';
            foreach ($data['where_type'] as $key => $value) {
                $data_value_type .= $value;
            }

            /* with call_user_func_array, array params must be passed by reference */
            $a_params[] = & $data_value_type;
        }

        $data_column = array();
        $data_column_or = array();
        $data_column_and = array();

        if(isset($data['where']) && !empty($data['where'])){
            foreach ($data['where'] as $column => $value) {
                
                if( strcasecmp($column, 'OR') == 0 || $column == '||'){
                    foreach ($value as $table_column => $val) {
                        /*if(operator_checker($table_column)){
                            $data_column[] = $table_column.' ? ';
                        }else{
                            $data_column[] = $table_column.' = ? ';
                        }*/

                        $data_column_or[] = $table_column.' = ? ';

                        /* with call_user_func_array, array params must be passed by reference */
                        $a_params[] = & $data['where'][$column][$table_column];
                    }
                    $data_column[] = '('.implode(' OR ', $data_column_or).')';
                }else if(strcasecmp($column, 'AND') == 0 || $column == '&&'){
                    foreach ($value as $table_column => $val) {
                        
                        $data_column_and[] = $table_column.' = ? ';
                        /*if(operator_checker($table_column)){
                            $data_column[] = $table_column.' ? ';
                        }else{
                            $data_column[] = $table_column.' = ? ';
                        }*/
                        /* with call_user_func_array, array params must be passed by reference */
                        $a_params[] = & $data['where'][$column][$table_column];
                    }
                    $data_column[] = '('.implode(' AND ', $data_column_and).')'; 

                }else{
                    $data_column[] = $column.' = ? ';
                    /*if(operator_checker($column)){
                        $data_column[] = $column.' ? ';
                    }else{
                        $data_column[] = $column.' = ? ';
                    }*/
                    
                    /* with call_user_func_array, array params must be passed by reference */
                    $a_params[] = & $data['where'][$column];
                }

            }

            $where_data = '('.implode(' AND ', $data_column).')';
            $query .= ' WHERE '.$where_data;
        }        

        if(isset($data['sub_query']) && !empty($data['sub_query'])){
            foreach ($data['sub_query'] as $key => $sub_query) {
                $query .= ' '.$sub_query;
            }
        }

        if(isset($data['order']) && !empty($data['order'])){
            $query .= ' ORDER BY '.$data['order'];
        }

        if(isset($data['limit']) && !empty($data['limit'])){
            $query .= ' LIMIT '.$data['limit'];
        }

        // echo $query;

        if($stmt = $mysqli->prepare($query)){

            /* use call_user_func_array, as $stmt->bind_param('s', $param); does not accept params array */
            call_user_func_array(array($stmt, 'bind_param'), $a_params);
            // $stmt->bind_param($value_type_data, $value_data);
            
            $stmt->execute();
            $result = $stmt->get_result();
            if($result->num_rows>0){
                $row = $result->fetch_array(MYSQLI_ASSOC);
                $stmt->free_result();
                $stmt->close();
                return $row;
            }else{
                $stmt->free_result();   
                return false;
            }
        }else{
            die('execute() failed: ' . htmlspecialchars($mysqli->error));
            return false;
        }

    }

    /* Select multiple rows  */
    function get_user_login_results($mysqli, $data){
        $fields = implode(', ', $data['fields']);
        $table = $data['table'];

        $query = "SELECT $fields FROM $table ";

        if(isset($data['join_type']) && !empty($data['join_type'])){
            if(is_array($data['join_type'])){
                /* Code to join more than 2 tables */
                foreach ($data['join_type'] as $key => $join_type) {
                    $query .= ' '.$join_type.' '.$data['join_table'][$key].' ON '.$data['on'][$key];
                }
            }else{
                /* Code to join 2 tables */
                $query .= ' '.$data['join_type'].' '.$data['join_table'].' ON '.$data['on'];
            }
        }
        /* bind param special functions */
        $a_params = array();

        if(isset($data['where_type']) && !empty($data['where_type'])){
            $data_value_type = '';
            foreach ($data['where_type'] as $key => $value) {
                $data_value_type .= $value;
            }

            /* with call_user_func_array, array params must be passed by reference */
            $a_params[] = & $data_value_type;
        }

        $data_column = array();
        $data_column_or = array();
        $data_column_and = array();

        if(isset($data['where']) && !empty($data['where'])){
            foreach ($data['where'] as $column => $value) {
                
                if( strcasecmp($column, 'OR') == 0 || $column == '||'){
                    foreach ($value as $table_column => $val) {

                        if(operator_checker($table_column)){
                            $data_column_or[] = $table_column.' ? ';
                        }else{
                            $data_column_or[] = $table_column.' = ? ';
                        }

                        /* with call_user_func_array, array params must be passed by reference */
                        $a_params[] = & $data['where'][$column][$table_column];
                    }
                    $data_column[] = '('.implode(' OR ', $data_column_or).')';
                }else if(strcasecmp($column, 'AND') == 0 || $column == '&&'){
                    foreach ($value as $table_column => $val) {
                        
                        if(operator_checker($table_column)){
                            $data_column_and[] = $table_column.' ? ';
                        }else{
                            $data_column_and[] = $table_column.' = ? ';
                        }

                        /* with call_user_func_array, array params must be passed by reference */
                        $a_params[] = & $data['where'][$column][$table_column];
                    }
                    $data_column[] = '('.implode(' AND ', $data_column_and).')'; 

                }else{
                    if(operator_checker($column)){
                        $data_column[] = $column.' ? ';
                    }else{
                        $data_column[] = $column.' = ? ';
                    }

                    /* with call_user_func_array, array params must be passed by reference */
                    $a_params[] = & $data['where'][$column];
                }

            }

            $where_data = '('.implode(' AND ', $data_column).')';
            $query .= ' WHERE '.$where_data;

        }

        if(isset($data['sub_query']) && !empty($data['sub_query'])){
            foreach ($data['sub_query'] as $key => $sub_query) {
                $query .= ' '.$sub_query;
            }
        }

        if(isset($data['order']) && !empty($data['order'])){
            $query .= ' ORDER BY '.$data['order'];
        }

        if(isset($data['limit']) && !empty($data['limit'])){
            $query .= ' LIMIT '.$data['limit'];
        }

        // echo $query;
        
        if($stmt = $mysqli->prepare($query)){

            /* use call_user_func_array, as $stmt->bind_param('s', $param); does not accept params array */
            call_user_func_array(array($stmt, 'bind_param'), $a_params);
            // $stmt->bind_param($value_type_data, $value_data);
            
            $stmt->execute();
            $result = $stmt->get_result();
            if($result->num_rows>0){
                $row = $result->fetch_all(MYSQLI_ASSOC);
                $stmt->free_result();
                $stmt->close();
                return $row;
            }else{
                $stmt->free_result();   
                return false;
            }
        }else{
            die('execute() failed: ' . htmlspecialchars($mysqli->error));
            return false;
        }
    }

    /* Insert in to table */
    function set_user_login_data($mysqli,$data){
        /*
            $data = ['table' => 'user_logins',  
             'column_name' => ['name', 'username', 'email', 'password', 'user_type_id', 'status'],
             'column_value' => [$fullname, $username, $email, $password, $user_type, $is_active],
             'column_type' => ['s','s','s','s','s','i']
            ];
        */
        $query = '';
        /* bind param special functions */
        $a_params = array();

        if(isset($data['column_type']) && !empty($data['column_type'])){
            $data_value_type = '';
            foreach ($data['column_type'] as $key => $value) {
                $data_value_type .= $value;
            }

            /* with call_user_func_array, array params must be passed by reference */
            $a_params[] = & $data_value_type;
        }
 
        if(isset($data['table']) && !empty($data['table'])){
            $query .= 'INSERT INTO '.$data['table'];
        }

        if(isset($data['column_name']) && !empty($data['column_name'])){
            $column_name = implode(', ', $data['column_name']);
            $query .= ' ('.$column_name.')';
        }

        if(isset($data['column_value']) && !empty($data['column_value'])){
            foreach ($data['column_value'] as $key => $value) {
                $data_val[] = '?';
                $a_params[] = & $data['column_value'][$key];
            }
            $column_name = implode(', ', $data_val);
            $query .= ' VALUES ('.$column_name.')';
        }
        // echo $query;

        if($stmt = $mysqli->prepare($query)){
            /* use call_user_func_array, as $stmt->bind_param('s', $param); does not accept params array */
            call_user_func_array(array($stmt, 'bind_param'), $a_params);

            if($stmt->execute()){
                $last_id = $stmt->insert_id;
                return $last_id;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }


    /* Update user records */
    function update_user_data($mysqli, $data){
        /*
            $data = [
                'table' => 'user_logins',
                'columns' => ['name', 'username', 'email', 'password', 'emp_id'],
                'column_value' => [$_POST['fullname'], $_POST['username'], $_POST['email'], md5($_POST['password']), $_POST['employee_id']]
                'where' => ['id' => $_POST['id']],
                'column_type' => ['s','s','s','s','i']
            ];
        */

        $query = '';
        
        /* bind param special functions */
        $a_params = array();
        if(isset($data['column_type']) && !empty($data['column_type'])){
            $data_value_type = '';
            foreach ($data['column_type'] as $key => $value) {
                $data_value_type .= $value;
            }

            /* with call_user_func_array, array params must be passed by reference */
            $a_params[] = & $data_value_type;
        }

        if(isset($data['table']) && !empty($data['table'])){
            $query .= 'UPDATE '.$data['table'];
        }
        
        if(isset($data['join_type']) && !empty($data['join_type'])){
            if(is_array($data['join_type'])){
                /* Code to join more than 2 tables */
                foreach ($data['join_type'] as $key => $join_type) {
                    $query .= ' '.$join_type.' '.$data['join_table'][$key].' ON '.$data['on'][$key];
                }
            }else{
                /* Code to join 2 tables */
                $query .= ' '.$data['join_type'].' '.$data['join_table'].' ON '.$data['on'];
            }
        }

        if(isset($data['columns']) && !empty($data['columns'])){
            $col = array();
            foreach ($data['columns'] as $key => $value) {
                $col[] = $value.' = ?';
            }
            $column = implode(', ', $col);
            $query .= ' SET '.$column.' ';
        }

        if(isset($data['column_value']) && !empty($data['column_value'])){
            foreach ($data['column_value'] as $key => $value) {
                $a_params[] = & $data['column_value'][$key];
            }
        }

        $data_column = array();
        $data_column_or = array();
        $data_column_and = array();

        if(isset($data['where']) && !empty($data['where'])){
            foreach ($data['where'] as $column => $value) {
                
                if( strcasecmp($column, 'OR') == 0 || $column == '||'){
                    foreach ($value as $table_column => $val) {
                        $data_column_or[] = $table_column.' = ? ';

                        /* with call_user_func_array, array params must be passed by reference */
                        $a_params[] = & $data['where'][$column][$table_column];
                    }
                    $data_column[] = '('.implode(' OR ', $data_column_or).')';
                }else if(strcasecmp($column, 'AND') == 0 || $column == '&&'){
                    foreach ($value as $table_column => $val) {
                        
                        $data_column_and[] = $table_column.' = ? ';

                        /* with call_user_func_array, array params must be passed by reference */
                        $a_params[] = & $data['where'][$column][$table_column];
                    }
                    $data_column[] = '('.implode(' AND ', $data_column_and).')'; 

                }else{
                    $data_column[] = $column.' = ? ';

                    /* with call_user_func_array, array params must be passed by reference */
                    $a_params[] = & $data['where'][$column];
                }

            }
            $where_data = '('.implode(' AND ', $data_column).')';
            $query .= ' WHERE '.$where_data;

        }

        // echo $query;

        if($stmt = $mysqli->prepare($query)){
            /* use call_user_func_array, as $stmt->bind_param('s', $param); does not accept params array */
            call_user_func_array(array($stmt, 'bind_param'), $a_params);

            if($stmt->execute()){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    
    }

    /* Delete from table */
    function remove_user($mysqli,$data){
        $query = '';
        if(isset($data['table']) && !empty($data['table'])){
            $query .= 'DELETE FROM '.$data['table'];
        }

        if(isset($data['where']) && !empty($data['where'])){
            $where =  array();
            foreach ($data['where'] as $column => $value) {
                $where[] = $column.' = '. $value;
            }
            $w_dt = implode(' AND ', $where);
            $query .= ' WHERE '.$w_dt;
        }
        if($mysqli->query($query)){
            return true;
        }else{
            return false;
        }
    }

    function remove_data($mysqli,$data){
        $query = '';
        if(isset($data['table']) && !empty($data['table'])){
            $query .= 'DELETE FROM '.$data['table'];
        }

        if(isset($data['where']) && !empty($data['where'])){
            $where =  array();
            foreach ($data['where'] as $column => $value) {
                $where[] = $column.' = '. $value;
            }
            $w_dt = implode(' AND ', $where);
            $query .= ' WHERE '.$w_dt;
        }

        // pr($query);
        if($mysqli->query($query)){
            return true;
        }else{
            return false;
        }
    }

    function operator_checker($str){
        $operator_array = ['=', '>', '<', '>=', '<=', '!='];

        foreach($operator_array as $a) {
            if (stripos($str,$a) !== false) return true;
        }
    }

     function hobbies_selected($mysqli, $data){
        // echo 'SELECT id FROM interest WHERE id IN ('.$data.')';
        if($stmt = $mysqli->prepare('SELECT id,name,media_path FROM interest WHERE id IN ('.$data.')')){
           // $stmt->bind_param("s", '('.$data.')');
            $stmt->execute();
            $result = $stmt->get_result();
            if($result->num_rows>0){
                $row = $result->fetch_all(MYSQLI_ASSOC);
                $stmt->free_result();
                $stmt->close();
                return $row;
            }else{
                $stmt->free_result();   
                return false;
            }
        }else{
            return false;
        }
    }


?>