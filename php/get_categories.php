<?php

require_once ('includes/connection.php');

$query = "SELECT * FROM category";
$result = mysql_query($query);
if (!$result) {
	die ("Database access failed: " . mysql_error());
} else {			
	echo "<div id='radio'>";


	while ($row = mysql_fetch_assoc($result)) {				
		echo "<input type='radio' name='category' value='" . $row['name'] . "' id=" . $row['name'] . ">";
		echo "<label for=" . $row['name'] . ">" . $row['name'] . "</label>";
	}
	
	echo "</div>";
}
   
?>