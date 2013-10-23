<?php session_start() ?>
<?php
	require_once('includes/connection.php');
	
	if (isset($_POST['group'])){		
		$selected = $_POST['group'];
		$query = "SELECT g.description FROM interest_groups g WHERE g.name='$selected'";
		$result = mysql_query($query);
		
		if (!$result) {
			die ("Unable to load group: ". mysql_error());			
		} else {
			$row = mysql_fetch_row($result);			
			echo $row[0];
		}
	}	
	
	
	
	
?>