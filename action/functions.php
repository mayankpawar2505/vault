<?php
    /* Common user functions */
    include_once('config.php');


    /* Select single row */
    function get_single_row_data($data){
        /*
            $data = [
                    'fields' => ['id', 'name', 'username', 'email', 'password', 'user_type_id', 'token_id', 'status'],
                    'table' => 'user_logins',
                    'where' => ['verification_code' => $_POST['token'], 'status' => '0'],
                    'where_type' => ['s','i'] 
                ];
        */

        global $mysqli;

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
    function get_multiple_row_data($data, $debug=false){
        
        global $mysqli;

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

        if(isset($data['where_in']) && !empty($data['where_in']) && count($data['where_in']) > 0){
            $i = 1;
            foreach ($data['where_in'] as $column => $value_arr) {
                $ids = implode(',', $value_arr);
                if($i == 1){
                    $query .= " WHERE ".$column." (".$ids.")";
                }else{
                    $query .= " AND ".$column." (".$ids.")";
                }
                $i++;
            }
        }

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
            if (strpos($query, ' WHERE ') !== false) {
                if(isset($data['where_in']) && !empty($data['where_in'])){
                    $query .= ' AND '.$where_data;
                }
            }else{
                $query .= ' WHERE '.$where_data;
            }

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

        if($debug==true){
            echo $query;
            pr($a_params);
        }
        if($stmt = $mysqli->prepare($query)){

            /* use call_user_func_array, as $stmt->bind_param('s', $param); does not accept params array */
            if(!empty($a_params)){
                call_user_func_array(array($stmt, 'bind_param'), $a_params);
            }
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
    function set_data($data, $debug = false){
        /*
            $data = ['table' => 'user_logins',  
             'column_name' => ['name', 'username', 'email', 'password', 'user_type_id', 'status'],
             'column_value' => [$fullname, $username, $email, $password, $user_type, $is_active],
             'column_type' => ['s','s','s','s','s','i']
            ];
        */

        global $mysqli;

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

        if($debug == true){
            echo $query;
        }
 
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

    /* Delete record from table */
    function delete_data($data, $debug=false){
        
        global$mysqli;

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
        
        if($debug==true){
            echo $query;
        }

        if($mysqli->query($query)){
            return true;
        }else{
            return false;
        }
    }

    /* Check operators */
    function operator_checker($str){
        $operator_array = ['=', '>', '<', '>=', '<=', '!='];

        foreach($operator_array as $a) {
            if (stripos($str,$a) !== false) return true;
        }
    }


?>