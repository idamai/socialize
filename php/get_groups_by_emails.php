<?php
require_once ('includes/connection.php');
session_start();

$email_str = $_POST['email'];
$user = $_SESSION['email'];



$email_arr = array_map('trim', explode(",", $email_str));

while (list($key, $email) = each($email_arr))
{
	$frag = "SELECT m.grp_name FROM member_of m	WHERE m.usr_email = '$email' ";
	if ($key != 0)
	{
		$query = $query . " AND m.grp_name IN($frag)"; 
	}
	else
	{
		$query = $frag;
	}
}

// exclude grp that you have joined
$query .= "AND m.grp_name NOT IN 
			(SELECT m1.grp_name FROM member_of m1
				WHERE usr_email = '$user')";		
			
$result = mysql_query($query);
while ($row = mysql_fetch_row($result)) 
{
	echo "<a href = ". $row[0] . ">" . $row[0] . "</a>";
}
   
?>