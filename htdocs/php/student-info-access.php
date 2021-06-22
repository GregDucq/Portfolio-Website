<?php

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
			
		$db->query($query);
		
		echo "Student info entered";
	}
	
	elseif($request->command == 1){
		$query = "select * from studentInfo;";
		$res = $db->query($query);
		$json_result = array();
		while($row = $res->fetchArray(SQLITE3_ASSOC)){
			$encoded_row = json_encode($row);
			array_push($json_result, $row);	
		}
		
		echo json_encode($json_result);
	}
	
	elseif($request->command == 2){
		$query = 'delete from studentInfo where studentID=\'' . $request->studentID . '\';';
		$db->query($query);
		
		echo "Student info deleted with query: " . $query;
	}
?>