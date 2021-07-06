<?php
	//error_reporting (E_ERROR); // Restrict error reporting to errors only to prevent failed SQL queries from being included in output.
	
	$postdata = file_get_contents("php://input");
	$request = json_decode($postdata);
	$db = new SQLite3('../../sqlite3/dbs/college-records/college-records.db');
	if($request->command == 0){	
		$query = 'INSERT INTO profInfo (profID, profName) VALUES('. 
			'\'' . $request->profID . '\',' .
			'\'' . $request->profName .
			'\');';
		
		$res = $db->exec($query);
		
		if($res){
			echo "Professor entered into database with query.";
		}
		
		else{
			echo "Failed to enter Professor";
		}
	}
	
	elseif($request->command == 1){
		$conditions = "";
		
		// Check for specific values to pull up.
		if(!empty($request->profID)){
			$conditions .= (" profID='" . $request->profID . "'");
		}
		
		if(!empty($request->profName)){
			if(!empty($conditions)){
				$conditions .= " and";
			}
			
			$conditions .= (" profName='" . $request->profName . "'");
		}
		
		// Construct query based on what conditions are given
		$query = "select * from profInfo";
		if(!empty($conditions)){
			$query .= (" where" . $conditions);
		}
		$query .= ";";

		$res = $db->query($query);
		$json_result = array();
		while($row = $res->fetchArray(SQLITE3_ASSOC)){
			$encoded_row = json_encode($row);
			array_push($json_result, $row);	
		}
		
		echo json_encode($json_result);
	}
	
	elseif($request->command == 2){
		$conditions = "";
		
		// Check for specific values to pull up.
		if(!empty($request->profID)){
			$conditions .= (" profID='" . $request->profID . "'");
		}
		
		if(!empty($request->profName)){
			if(!empty($conditions)){
				$conditions .= " and";
			}
			
			$conditions .= (" profName='" . $request->profName . "'");
		}
		
		// Construct query based on what conditions are given
		$query = "delete from profInfo";
		if(!empty($conditions)){
			$query .= " where" . $conditions;
		}
		$query .= ";";
		
		$db->exec($query);
		
		echo "Professor info from student records.";
	}
	
	elseif($request->command == 3){
		$conditions = "";
		
		
		if(!empty($request->profName)){
			if(!empty($conditions)){
				$conditions .= ", ";
			}
			
			$conditions .= (" profName='" . $request->profName . "'");
		}
		
		if(empty($conditions)){
			echo "No information given to update. Professor data not updated.";
		}
		
		else{
			$query = "update profInfo set" . $conditions . " where profID='" . $request->profID . "';";
			$db->exec($query);
			
			if($db->changes()){
				echo "Professor records updated.";
			}
			
			else{
				echo "Professor with the given course ID was not found. No information updated.";
			}
		}
	}
?>