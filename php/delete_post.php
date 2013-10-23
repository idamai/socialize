<?php
session_start();
require_once('includes/connection.php');

if ( isset ($_POST['post_id']))
{		
	$pid = $_POST['post_id'];	
	
	$query = "DELETE FROM posts WHERE post_id=$pid";	
	$result = mysql_query($query);	
	if ($result)
	{
		echo "delete successful";
	}
	else
	{
		echo "failed";
		die(mysql_error());
	}
	
}
?>