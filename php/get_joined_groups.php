<?php
session_start();
require_once("includes/connection.php");
$current_user = $_SESSION['email'];

$query = "SELECT ig.name FROM member_of m, interest_groups ig
            WHERE m.grp_name=ig.name AND m.usr_email='{$current_user}'";
$result = mysql_query($query);

if (!$result) {
	die ("Database access failed: " . mysql_error());
} else {			
	while ($row = mysql_fetch_assoc($result)) {		
		// TODO make ul and li
		echo "<img height='16' class='loading_image' src='img/ajax_loader.gif' style='display:none;'/><a class='ellipsis' href=" . $row["name"] . ">" . $row["name"] . "</a>";
	}
}

?>