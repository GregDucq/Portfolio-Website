<?php
	//error_reporting (E_ERROR); // Restrict error reporting to errors only to prevent failed SQL queries from being included in output.
	
	$postdata = file_get_contents("php://input");
	$request = json_decode($postdata);
	$db = new SQLite3('../../sqlite3/dbs/college-records/college-records.db');
	if($request->command == 0){	
		$query = 'INSERT INTO courseInfo (courseID, courseName, profID, courseTime, courseDays) VALUES('. 
			'\'' . $request->courseID . '\',' .
			'\'' . $request->courseName . '\',' .
			'\'' . $request->profID . '\',' .
			'\'' . $request->courseTime . '\',' .
			'\'' . $request->courseDays .
			'\');';
		
		$res = $db->exec($query);
		
		if($res){
			echo "Course entered into database";
		}
		
		else{
			echo "Failed to enter course";
		}
	}
	
	elseif($request->command == 1){
		$conditions = "";
		
		// Check for specific values to pull up.
		if(!empty($request->studentID)){
			$conditions .= (" studentID='" . $request->studentID . "'");
		}
		
		if(!empty($request->currentGPA)){
			if(!empty($conditions)){
				$conditions .= " and";
			}
			
			$conditions .= (" currentGPA='" . $request->currentGPA . "'");
		}
		
		if(!empty($request->totalGPA)){
			if(!empty($conditions)){
				$conditions .= " and";
			}
			
			$conditions .= (" totalGPA='" . $request->totalGPA . "'");
		}
		
		if(!empty($request->semCredits)){
			if(!empty($conditions)){
				$conditions .= " and";
			}
			
			$conditions .= (" semCredits='" . $request->semCredits . "'");
		}
		
		if(!empty($request->totalCredits)){
			if(!empty($conditions)){
				$conditions .= " and";
			}
			
			$conditions .= (" totalCredits='" . $request->totalCredits . "'");
		}

		if(!empty($request->canGrad)){
			if(!empty($conditions)){
				$conditions .= " and";
			}
			
			$conditions .= (" canGrad='" . $request->canGrad . "'");
		}

		// Construct query based on what conditions are given
		$query = "select * from gradeInfo";
		
		if(!empty($conditions)){
			$query .= (" where" . $conditions);
		}
		$query .= ";";
		
		$res = $db->query($query);
		$json_result = array();
		while($row = $res->fetchArray(SQLITE3_ASSOC)){
			
			$course_res = $db->query("select courseID, grade, courseStatus from studentCourseInfo where studentID='" . $row['studentID'] . "' order by courseStatus;");
			$course_grades = array();
			
			while($course_row = $course_res->fetchArray(SQLITE3_ASSOC)){
				array_push($course_grades, $course_row);
			}
			
			$row['gradeInfo'] = $course_grades;
			
			$encoded_row = json_encode($row);
			array_push($json_result, $row);	
		}
		
		//echo var_dump(json_encode($json_result));
		echo json_encode($json_result);
	}
	
	elseif($request->command == 2){
		$conditions = "";
		
		// Check for specific values to pull up.
		if(!empty($request->courseID)){
			$conditions .= (" courseID='" . $request->courseID . "'");
		}
		
		if(!empty($request->courseName)){
			if(!empty($conditions)){
				$conditions .= " and";
			}
			
			$conditions .= (" courseName='" . $request->courseName . "'");
		}
		
		if(!empty($request->profID)){
			if(!empty($conditions)){
				$conditions .= " and";
			}
			
			$conditions .= (" profID='" . $request->profID . "'");
		}
		
		if(!empty($request->courseTime)){
			if(!empty($conditions)){
				$conditions .= " and";
			}
			
			$conditions .= (" courseTime='" . $request->courseTime . "'");
		}
		
		if(!empty($request->courseDays)){
			if(!empty($conditions)){
				$conditions .= " and";
			}
			
			$conditions .= (" courseDays='" . $request->courseDays . "'");
		}
		
		// Construct query based on what conditions are given
		$query = "delete from courseInfo";
		if(!empty($conditions)){
			$query .= " where" . $conditions;
		}
		$query .= ";";
		
		$db->exec($query);
		
		echo "Course info from student records.";
	}
	
	elseif($request->command == 3){
		$conditions = "";
		
		
		if(!empty($request->courseName)){
			if(!empty($conditions)){
				$conditions .= ", ";
			}
			
			$conditions .= (" courseName='" . $request->courseName . "'");
		}
		
		if(!empty($request->profID)){
			if(!empty($conditions)){
				$conditions .= ", ";
			}
			
			$conditions .= (" profID='" . $request->profID . "'");
		}
		
		if(!empty($request->courseTime)){
			if(!empty($conditions)){
				$conditions .= ", ";
			}
			
			$conditions .= (" courseTime='" . $request->courseTime . "'");
		}
		
		if(!empty($request->courseDays)){
			if(!empty($conditions)){
				$conditions .= ", ";
			}
			
			$conditions .= (" courseDays='" . $request->courseDays . "'");
		}
		
		if(empty($conditions)){
			echo "No information given to update. Course data not updated.";
		}
		
		else{
			$query = "update courseInfo set" . $conditions . " where courseID='" . $request->courseID . "';";
			$db->exec($query);
			
			if($db->changes()){
				echo "Course records updated.";
			}
			
			else{
				echo "Course with the given course ID was not found. No information updated.";
			}
		}
	}
?>