<?php
	error_reporting (E_ERROR); // Restrict error reporting to errors only to prevent failed SQL queries from being included in output.
	
	$postdata = file_get_contents("php://input");
	$request = json_decode($postdata);
	$db = new SQLite3('../../sqlite3/dbs/college-records/college-records.db');
	$db->exec("PRAGMA foreign_keys = ON;"); // Needed to enforce foreign key links
	
	if($request->command == 0){	
		$query = 'INSERT INTO studentCourseInfo (studentID, courseID, grade) VALUES('. 
			'\'' . $request->studentID . '\',' .
			'\'' . $request->courseID . '\',' .
			'\'' . $request->grade . 
			'\');';
		
		$res = $db->exec($query);
		
		if($res){
			echo "Student-course entered into database.";
		}
		
		else{
			echo "Failed to enter Student-course";
		}
	}
	
	elseif($request->command == 1){
		$conditions = "";
		
		// Check for specific values to pull up.
		if(!empty($request->studentID)){
			$conditions .= (" studentID='" . $request->studentID . "'");
		}
		
		if(!empty($request->courseID)){
			if(!empty($conditions)){
				$conditions .= " and";
			}
			
			$conditions .= (" courseID='" . $request->courseID . "'");
		}
		
		if(!empty($request->grade)){
			if(!empty($conditions)){
				$conditions .= " and";
			}
			
			$conditions .= (" grade='" . $request->grade . "'");
		}
		
		// Construct query based on what conditions are given
		$query = "select * from studentCourseInfo";
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
		
		if(!empty($request->courseID)){
			if(!empty($conditions)){
				$conditions .= " and";
			}
			
			$conditions .= (" courseID='" . $request->courseID . "'");
		}

		if(!empty($request->grade)){
			if(!empty($conditions)){
				$conditions .= " and";
			}
			
			$conditions .= (" grade='" . $request->grade . "'");
		}
		
		// Construct query based on what conditions are given
		$query = "delete from studentCourseInfo";
		if(!empty($conditions)){
			$query .= " where" . $conditions;
		}
		$query .= ";";
		
		$db->exec($query);
		
		echo "Student-Course info from student records.";
	}
	
	elseif($request->command == 3){
		$conditions = "";
		
		
		if(!empty($request->courseID)){
			if(!empty($conditions)){
				$conditions .= ", ";
			}
			
			$conditions .= (" courseID='" . $request->courseID . "'");
		}
		
		if(!empty($request->grade)){
			if(!empty($conditions)){
				$conditions .= ", ";
			}
			
			$conditions .= (" grade='" . $request->grade . "'");
		}
		
		if(empty($conditions)){
			echo "No information given to update. Student-Course data not updated.";
		}
		
		else{
			$query = "update studentCourseInfo set" . $conditions . " where studentID='" . $request->studentID . "';";
			$db->exec($query);
			
			if($db->changes()){
				echo "Student-Course records updated.";
			}
			
			else{
				echo "Student-Course with the given course ID was not found. No information updated.";
			}
		}
	}
?>