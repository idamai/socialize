<?php
	require_once('includes/connection.php');
	
	if (!$db_server) 
	{
		die("Unable to connect to MySQL: " . mysql_error());
	}
	
	$query = 	"SELECT m1.grp_name
				FROM member_of m1
				GROUP BY m1.grp_name
				HAVING COUNT(m1.usr_email) >= ALL (
					SELECT COUNT(m2.usr_email)
					FROM member_of m2
					GROUP BY m2.grp_name)";
	
	$result = mysql_query($query);
	if (!$result) 
	{
		die ("Database access failed: " . mysql_error());
	}
	
	$rows = array();
	while ($row = mysql_fetch_assoc($result))
	{
		echo $row['grp_name'];
	}
?>