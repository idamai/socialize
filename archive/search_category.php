<?php // catsearch.php
require_once 'includes/connection.php'; 

$whatiwant = $_POST["catesearch"];
$result = mysql_query("SELECT name, description FROM `group_category` g, `interest_groups` i 
WHERE g.cat_name = '$whatiwant' AND g.grp_name = i.name");
$num_results = mysql_num_rows($result);

if ($num_results > 0) {
	while($row = mysql_fetch_array($result))
  {
	echo "Interest Group Name: " . $row['name'];
	echo "<br>";
	echo "Group Description: " . $row['description'];
	echo "<br>";
	echo "<br>";
	}
}
else {
	echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Result Not Found!!')
        window.location.href='\searchgroup.php'
        </SCRIPT>");
}

?>