<?php session_start() ?>
<?php
	require_once('includes/connection.php');

	$current_user = $_SESSION['email'];
	$timestamp = time();

	$query = "SELECT * FROM users u WHERE u.email = '{$current_user}'";
	$result = mysql_query($query);

	if (!$result) {
        die(mysql_error());
    } else {
        $row = mysql_fetch_row($result);

        echo "<br>";
        echo "<b><u>Name</u>: $row[2]</b>";
        echo "<br><br>";
        echo "<b><u>Lastname</u>: $row[3]</b>";
        echo "<br><br>";
        echo "<b><u>Birthday</u>: $row[4]</b>";
        echo "<br><br>";
        echo "<b><u>Marital Status</u>: $row[7]</b>";
        echo "<br><br><br><br>";
    }

?>