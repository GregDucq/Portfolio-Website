<?php
	$event = $_GET["event"];
	
	if($event == "add"){
		$name = $_GET["name"];
		$id = $_GET["id"];
		$query = 'INSERT INTO basic_id (name, id) VALUES(\'' . $name . '\', \'' . $id . '\');';
		
		$db = new SQLite3('../sql/test.db');
		$db->query($query);
		
		$processed_text = "You entered: " . $name . ". Their ID is: " . $id;
		
		echo $processed_text;
	}
		
	elseif($event == "display"){
		$query = 'SELECT * from basic_id';
		$db = new SQLite3('../sql/test.db');
		
		$res = $db->query($query);
		$processed_text = "Values entered into database:\n";
		
		while($row = $res->fetchArray()){
			$processed_text = $row[0] . " | " . $row[1] . "\n"; 
		}
		
		echo $processed_text;
	}
	
	elseif($event == "clear"){
		$query = 'DELETE FROM basic_id;';
		
		$db = new SQLite3('../sql/test.db');
		$db->query($query);
		echo "ID database successfully cleared.";
	}
	
	else{
		echo "Event error.";
	}
?>