<?php

require_once ('includes/connection.php');

$query = "SELECT * FROM interest_groups";
$result = mysql_query($query);
if (!$result) {
	die ("Database access failed: " . mysql_error());
} else {		
	while ($row = mysql_fetch_assoc($result)) {		
		echo "<option value=" . $row['name'] . ">" . $row['name'] . "</option>";
	}
}
   
?>