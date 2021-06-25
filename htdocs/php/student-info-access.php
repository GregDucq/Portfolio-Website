<?php
	//error_reporting (E_ERROR); // Restrict error reporting to errors only to prevent failed SQL queries from being included in output.
	
	$postdata = file_get_contents("php://input");
	$request = json_decode($postdata);
	$db = new SQLite3('../../sqlite3/dbs/college-records/college-records.db');
	if($request->command == 0){	
		$query = 'INSERT INTO studentInfo (studentID, firstName, lastName, address, city, state, country, phone, email) VALUES('. 
			'\'' . $request->studentID . '\',' .
			'\'' . $request->firstName . '\',' .
			'\'' . $request->lastName . '\',' .
			'\'' . $request->address . '\',' .
			'\'' . $request->city . '\',' .
			'\'' . $request->state . '\',' .
			'\'' . $request->country . '\',' .
			'\'' . $request->phone . '\',' .
			'\'' . $request->email . 
			'\');';
		
		$res = $db->exec($query);
		
		if($res){
			echo "Student entered into database." ;
		}
		
		else{
			echo "Failed to enter student";
		}
		
		if(empty($request->firstName)){
			echo "NO FIRST NAME GIVEN!";
		}
		
		else{
			echo "FIRST NAME FOUND";
		}
	}
	
	elseif($request->command == 1){
		$conditions = "";
		
		// Check for specific values to pull up.
		if(!empty($request->studentID)){
			$conditions .= (" studentID='" . $request->studentID . "'");
		}
		
		if(!empty($request->firstName)){
			$conditions .= (" firstName='" . $request->firstName . "'");
		}
		
		if(!empty($request->lastName)){
			$conditions .= (" lastName='" . $request->lastName . "'");
		}
		
		if(!empty($request->address)){
			$conditions .= (" address='" . $request->address . "'");
		}
		
		if(!empty($request->city)){
			$conditions .= (" city='" . $request->city . "'");
		}
		
		if(!empty($request->state)){
			$conditions .= (" state='" . $request->state . "'");
		}
		
		if(!empty($request->country)){
			$conditions .= (" country='" . $request->country . "'");
		}
		
		if(!empty($request->phone)){
			$conditions .= (" phone='" . $request->phone . "'");
		}
		
		if(!empty($request->email)){
			$conditions .= (" email='" . $request->email . "'");
		}
		
		// Construct query based on what conditions are given
		$query = "select * from studentInfo";
		if(!empty($conditions)){
			$query .= " where" . $conditions;
		}
		$query .= ";";
		
		$res = $db->query($query);
		$json_result = array();
		while($row = $res->fetchArray(SQLITE3_ASSOC)){
			$encoded_row = json_encode($row);
			array_push($json_result, $row);	
		}
		
		echo json_encode($json_result);
		//echo $query;
	}
	
	elseif($request->command == 2){
				$conditions = "";
		
		// Check for specific values to pull up.
		if(!empty($request->studentID)){
			$conditions .= (" studentID='" . $request->studentID . "'");
		}
		
		if(!empty($request->firstName)){
			$conditions .= (" firstName='" . $request->firstName . "'");
		}
		
		if(!empty($request->lastName)){
			$conditions .= (" lastName='" . $request->lastName . "'");
		}
		
		if(!empty($request->address)){
			$conditions .= (" address='" . $request->address . "'");
		}
		
		if(!empty($request->city)){
			$conditions .= (" city='" . $request->city . "'");
		}
		
		if(!empty($request->state)){
			$conditions .= (" state='" . $request->state . "'");
		}
		
		if(!empty($request->country)){
			$conditions .= (" country='" . $request->country . "'");
		}
		
		if(!empty($request->phone)){
			$conditions .= (" phone='" . $request->phone . "'");
		}
		
		if(!empty($request->email)){
			$conditions .= (" email='" . $request->email . "'");
		}
		
		// Construct query based on what conditions are given
		$query = "delete from studentInfo";
		if(!empty($conditions)){
			$query .= " where" . $conditions;
		}
		$query .= ";";
		
		$db->query($query);
		
		echo "Student info from student records.";
	}
?>