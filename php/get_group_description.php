<?php session_start() ?>
<?php
	require_once('includes/connection.php');

	if (isset($_POST['selected_group'])){
		$groupName = mysql_real_escape_string($_POST['selected_group']);
		$query = "SELECT ig.description FROM interest_groups ig WHERE ig.name='$groupName'";
		$result = mysql_query($query);

		if (!$result) {
        	die ("Database access failed: " . mysql_error());
        } else {
        	while ($row = mysql_fetch_assoc($result)) {
        		// TODO make ul and li
        		echo $row["description"];
            }
	    }
	}
?>