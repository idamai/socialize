<?php
	require_once('includes/connection.php');
	
	if (!$db_server) 
	{
		die("Unable to connect to MySQL: " . mysql_error());
	}
	
	$query = 	"SELECT g.name
				FROM interest_groups g
				WHERE NOT EXISTS (
					SELECT *
					FROM users u
					WHERE NOT EXISTS (
						SELECT *
						FROM member_of m
						WHERE m.usr_email = u.email
						AND m.grp_name = g.name))";
	
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
	
	echo json_encode($rows);
?>

