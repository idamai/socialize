<?php
	require_once('includes/connection.php');

	if (!$db_server)
	{
		die("Unable to connect to MySQL: " . mysql_error());
	}

	$query = 	"SELECT COUNT(*) c
				FROM users";

	$result = mysql_query($query);
	if (!$result)
	{
		die ("Database access failed: " . mysql_error());
	}

	$row = mysql_fetch_assoc($result);
    echo $row['c'];
?>