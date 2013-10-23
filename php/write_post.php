<?php
session_start();
require_once('includes/connection.php');

if ( isset ($_POST['message']) && isset ($_POST['group']) )
{	
	$user = $_SESSION['email'];
	$group = $_POST['group'];
	$message = mysql_real_escape_string(nl2br($_POST['message']));
	$time = date("Y-m-d H:i:s");

	
	
	$query = "INSERT INTO posts (time, contents, poster, grp_name) VALUES ('$time','$message', '$user', '$group')";
	$result = mysql_query($query);	
	if ($result)
	{	
		$message = str_replace("\\n", "", $message);		
		$pid = mysql_insert_id();
		echo "<li class='post' data-pid=$pid>";
		echo "<div class='poster'>$user</div>";				
		echo "<div class='message'>$message</div>";
		echo "<div style='display:none' class='edit_post'>
		<textarea type='text'>$message</textarea>
		<a class='confirm' href=''><img src='img/confirm.png' alt='confirm' width=20/></a>
		</div>";
		echo "<div class='time'>posted on $time</div>";
		echo "<a href='#' class='delete'><img alt='delete' src='img/delete.png' width=16/></a>";
		echo "<a href='#' class='edit'><img alt='edit' src='img/edit.png' width=16/></a>";
		echo "</li>";				
	}
	else
	{
		echo "failed";
		die(mysql_error());
	}
	
}
?>