<?php

	echo sha1("pass");


	/* require_once('includes/connection.php');
	
	if (!$db_server) 
	{
		die("Unable to connect to MySQL: " . mysql_error());
	}
	
	$query = "SELECT * FROM users";
	
	$result = mysql_query($query);
	if (!$result) 
	{
		die ("Database access failed: " . mysql_error());
	}
	
	$rows = array();
	while ($row = mysql_fetch_assoc($result))
	{
		$rows[] = $row;
	}
	
	echo json_encode($rows); */
?>