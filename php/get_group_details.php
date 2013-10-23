<?php session_start() ?>
<?php
	require_once('includes/connection.php');
	/*
	$current_group = $_SESSION['group'];
	$current_user = $_SESSION['user'];
	
	$query = "SELECT * FROM interest_groups g WHERE g.name='{$current_group}'";
	*/
	
		
	if (isset($_POST['selected_group'])){		
		$groupName = mysql_real_escape_string($_POST['selected_group']);
		$query = "SELECT * FROM interest_groups g WHERE g.name='$groupName'";
		$result = mysql_query($query);
		
		if (!$result) {
			die ("Unable to load group: ". mysql_error());
		} else {
			$row = mysql_fetch_array($result);
						
			$grp_name =	$row['name'];
			$grp_admin  =	$row['admin'];
			$grp_description  =	$row['description'];
			$grp_icon  =	$row['icon'];
						
			echo "<h1>$grp_name</h1>";
		}
	}	
	
	
	
	
?>