<?php
	require_once('includes/connection.php');

	if (!$db_server)
	{
		die("Unable to connect to MySQL: " . mysql_error());
	}
	if (isset($_POST['selected_group'])){
		$groupName = mysql_real_escape_string($_POST['selected_group']);


		$query = 	"SELECT COUNT(*) c FROM member_of m, users u
					WHERE m.grp_name = '$groupName'
					AND m.usr_email = u.email
					AND u.gender = 'M'
					AND u.status_marital ='SINGLE'";

		$result = mysql_query($query);
		if (!$result)
		{
			die ("Database access failed: " . mysql_error());
		}

		$row = mysql_fetch_assoc($result);
		echo $row['c'];
	}
?>