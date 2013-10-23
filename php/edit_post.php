<?php
require_once('includes/connection.php');

if ( isset ($_POST['message']) && isset ($_POST['post_id']) )
{		
	$message = mysql_real_escape_string(nl2br($_POST['message'])); // keep the line breaks
	$pid = $_POST['post_id'];
	
	$query = "UPDATE posts SET contents='$message' WHERE post_id=$pid";
	$result = mysql_query($query);	
	if ($result)
	{
		echo "edit post successful";
	}
	else
	{
		echo "failed";
		die(mysql_error());
	}
	
}
?>