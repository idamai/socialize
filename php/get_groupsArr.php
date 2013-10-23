<?php

require_once ('includes/connection.php');

$query = "SELECT * FROM interest_groups";
$result = mysql_query($query);
if (!$result) {
	die ("Database access failed: " . mysql_error());
} else {
	$int_grp_arr = array();	
	while ($row = mysql_fetch_assoc($result)) {		
		array_push($int_grp_arr, $row['name']);
	}
	echo json_encode($int_grp_arr);
}
   
?>