<?php session_start() ?>
<?php
		require_once('includes/connection.php');
		require_once('includes/safety_feature.php'); 
		
		$current_user = $_SESSION['email'];
		$current_group = $_SESSION['group'];
		$query = "SELECT g.admin FROM interest_groups g WHERE g.name = '{$current_group}'";
		$result = mysql_query($query);
		if(!$result) die ("MySql: " . mysql_error());
		$row = mysql_fetch_array($result);
		$grp_admin = $row['admin'];
		
		if ($current_user == $grp_admin ) {
			$query = "DELETE FROM interest_groups WHERE name = '{$current_group}'";
			$result = mysql_query($query);
			if(!$result) {
				die ("MySql: " . mysql_error());
			} else {
				echo "Delete success of " . $current_group;
				$_SESSION['group'] = NULL;
			}
		}
?>