<?php
	$name = $_GET["name"];
	$id = $_GET["id"];
	$query = 'INSERT INTO basic_id (name, id) VALUES(\'' . $name . '\', \'' . $id . '\')';
	
	$db = new SQLite3('../sql/test.db');
	//$db->query($query);
	
	$processed_text = "You entered: " . $name . ". Their ID is: " . $id;
	
	echo $processed_text
?>