<?php
	/* Select multiple rows  */
    function get_multiple_results($mysqli, $data){
        
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

            // echo $query;

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

        /*echo $query;
        pr($a_params);*/
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
?>