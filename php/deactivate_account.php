<?php session_start() ?>
<?php
	require_once('includes/connection.php');
	
	$user_email = $_SESSION('email');
	
	$query = "SELECT COUNT(*) FROM interests_groups g WHERE g.admin = '{$user_email}'";
	$result = mysql_query($query);
	$num_of_groups = mysql_result($result);
	for ( $j=0; $j<
	
?>