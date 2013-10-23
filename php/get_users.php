<?php
	$db_server = mysql_connect("localhost", "root", "");
	if (!$db_server) die("Unable to connect to MySQL: " . mysql_error());
	mysql_select_db("socialize", $db_server) or die("Unable to select database: " . mysql_error());
	
	$query = "SELECT first_name, last_name, birthday FROM users";
	$result = mysql_query($query);
	if (!$result) die ("Database access failed: " . mysql_error());
	$rows = mysql_num_rows($result);
		
	
	echo "<table><tr> <th>First Name</th> <th>Last Name</th>
	<th>Birthday</th></tr>";
	
	for ($j = 0	 ; $j < $rows ; ++$j)
	{
	$row = mysql_fetch_row($result);
	echo "<tr>";
	for ($k = 0 ; $k < 3 ; ++$k) echo "<td>$row[$k]</td>";
	echo "</tr>";
	}
	echo "</table>";
?>