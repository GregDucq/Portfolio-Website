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
	}
	
	elseif($request->command == 1){
		$conditions = "";
		
		// Check for specific values to pull up.
		if(!empty($request->studentID)){
			$conditions .= (" studentID='" . $request->studentID . "'");
		}
		
		if(!empty($request->firstName)){
			if(!empty($conditions)){
				$conditions .= " and";
			}
			
			$conditions .= (" firstName='" . $request->firstName . "'");
		}
		
		if(!empty($request->lastName)){
			if(!empty($conditions)){
				$conditions .= " and";
			}
			
			$conditions .= (" lastName='" . $request->lastName . "'");
		}
		
		if(!empty($request->address)){
			if(!empty($conditions)){
				$conditions .= " and";
			}
			
			$conditions .= (" address='" . $request->address . "'");
		}
		
		if(!empty($request->city)){
			if(!empty($conditions)){
				$conditions .= " and";
			}
			
			$conditions .= (" city='" . $request->city . "'");
		}
		
		if(!empty($request->state)){
			if(!empty($conditions)){
				$conditions .= " and";
			}
			
			$conditions .= (" state='" . $request->state . "'");
		}
		
		if(!empty($request->country)){
			if(!empty($conditions)){
				$conditions .= " and";
			}
			
			$conditions .= (" country='" . $request->country . "'");
		}
		
		if(!empty($request->phone)){
			if(!empty($conditions)){
				$conditions .= " and";
			}
			
			$conditions .= (" phone='" . $request->phone . "'");
		}
		
		if(!empty($request->email)){
			if(!empty($conditions)){
				$conditions .= " and";
			}
			
			$conditions .= (" email='" . $request->email . "'");
		}
		
		// Construct query based on what conditions are given
		$query = "select * from studentInfo";
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
		if(!empty($request->studentID)){
			$conditions .= (" studentID='" . $request->studentID . "'");
		}
		
		if(!empty($request->firstName)){
			if(!empty($conditions)){
				$conditions .= " and";
			}
			
			$conditions .= (" firstName='" . $request->firstName . "'");
		}
		
		if(!empty($request->lastName)){
			if(!empty($conditions)){
				$conditions .= " and";
			}
			
			$conditions .= (" lastName='" . $request->lastName . "'");
		}
		
		if(!empty($request->address)){
			if(!empty($conditions)){
				$conditions .= " and";
			}
			
			$conditions .= (" address='" . $request->address . "'");
		}
		
		if(!empty($request->city)){
			if(!empty($conditions)){
				$conditions .= " and";
			}
			
			$conditions .= (" city='" . $request->city . "'");
		}
		
		if(!empty($request->state)){
			if(!empty($conditions)){
				$conditions .= " and";
			}
			
			$conditions .= (" state='" . $request->state . "'");
		}
		
		if(!empty($request->country)){
			if(!empty($conditions)){
				$conditions .= " and";
			}
			
			$conditions .= (" country='" . $request->country . "'");
		}
		
		if(!empty($request->phone)){
			if(!empty($conditions)){
				$conditions .= " and";
			}
			
			$conditions .= (" phone='" . $request->phone . "'");
		}
		
		if(!empty($request->email)){
			if(!empty($conditions)){
				$conditions .= " and";
			}
			
			$conditions .= (" email='" . $request->email . "'");
		}
		
		// Construct query based on what conditions are given
		$query = "delete from studentInfo";
		if(!empty($conditions)){
			$query .= " where" . $conditions;
		}
		$query .= ";";
		
		$db->exec($query);
		
		echo "Student info from student records.";
	}
	
	elseif($request->command == 3){
		$conditions = "";
		
		
		if(!empty($request->firstName)){
			if(!empty($conditions)){
				$conditions .= ", ";
			}
			
			$conditions .= (" firstName='" . $request->firstName . "'");
		}
		
		if(!empty($request->lastName)){
			if(!empty($conditions)){
				$conditions .= ", ";
			}
			
			$conditions .= (" lastName='" . $request->lastName . "'");
		}
		
		if(!empty($request->address)){
			if(!empty($conditions)){
				$conditions .= ", ";
			}
			
			$conditions .= (" address='" . $request->address . "'");
		}
		
		if(!empty($request->city)){
			if(!empty($conditions)){
				$conditions .= ", ";
			}
			
			$conditions .= (" city='" . $request->city . "'");
		}
		
		if(!empty($request->state)){
			if(!empty($conditions)){
				$conditions .= ", ";
			}
			
			$conditions .= (" state='" . $request->state . "'");
		}
		
		if(!empty($request->country)){
			if(!empty($conditions)){
				$conditions .= ", ";
			}
			
			$conditions .= (" country='" . $request->country . "'");
		}
		
		if(!empty($request->phone)){
			if(!empty($conditions)){
				$conditions .= ", ";
			}
			
			$conditions .= (" phone='" . $request->phone . "'");
		}
		
		if(!empty($request->email)){
			if(!empty($conditions)){
				$conditions .= ", ";
			}
			
			$conditions .= (" email='" . $request->email . "'");
		}
		
		if(empty($conditions)){
			echo "No information given to update. Student data not updated.";
		}
		
		else{
			$query = "update studentInfo set" . $conditions . " where studentID='" . $request->studentID . "';";
			$db->exec($query);
			
			if($db->changes()){
				echo "Student records updated.";
			}
			
			else{
				echo "Student with the given student ID was not found. No information updated.";
			}
		}
	}
?>