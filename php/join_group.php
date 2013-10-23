<?php session_start() ?>
<?php
	require_once('includes/connection.php');
	
	$current_user = $_SESSION['email'];
	$selected_group = sanitizeMySQL($_POST['selectedGroup']);
	$timestamp = time();
	
	$query = "SELECT * FROM member_of m WHERE m.usr_name = '{$current_user}' AND m.grp_name = '{$selected_group}'";
	$result = mysql_query($query);
	
	

	if ($result) {
		echo "You are already registered to this group. Click <a href='../group.html?group={$selected_group}'>here</a> to open group page.</br>";
	} else {
		$query = "INSERT INTO member_of VALUES ('{$selected_group}','{$current_user}',FROM_UNIXTIME({$timestamp}))";
		
		$result_insert = mysql_query($query);
		if (!$result_insert){
			die ("Operation fail! " . mysql_error());
		} else {
			// echo "Success! </br>";
		}
	}
	
?>