<?php
require_once ('includes/connection.php');
session_start();

$category = $_POST['category'];
$user = $_SESSION['email'];

if ($category != "All") 
{
	$query = "SELECT g.name FROM interest_groups g, group_category c
		WHERE g.name = c.grp_name 	
		AND c.cat_name = '$category'
		AND g.name NOT IN 
			(SELECT m.grp_name FROM member_of m
				WHERE usr_email = '$user')";
}
else 
{
	$query = "SELECT g.name FROM interest_groups g			
		WHERE g.name NOT IN 
			(SELECT m.grp_name FROM member_of m
				WHERE usr_email = '$user')";
}

$result = mysql_query($query);

if (!$result)
{
	die ("Database access failed: " . mysql_error());
} 		


while ($row = mysql_fetch_row($result)) 
{
	echo "<a href = ". $row[0] . ">" . $row[0] . "</a>";
} 
	
	

   
?>