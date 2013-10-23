<?php
	require_once('includes/connection.php');
	
	if (!$db_server) 
	{
		die("Unable to connect to MySQL: " . mysql_error());
	}
	if (isset($_POST['usr_email'])){		
		$groupName = mysql_real_escape_string($_POST['usr_email']);
		
		
		$query = 	"SELECT g.name
					FROM interest_groups g, member_of m
					WHERE g.name = m.grp_name
					AND m.usr_email = ANY (
					SELECT * FROM search_for_members)";
		
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
	}
?>

