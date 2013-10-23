<!DOCTYPE html>
<html>
<body>
Search for group: <br><br>

<form action="catsearch.php" method="post">
Search by category: Type the category into the box below from this list: <br>

<?php
require_once 'includes/connection.php'; 

$result1 = mysql_query("SELECT name FROM `category`");
$num_results1 = mysql_num_rows($result1);

$i = 1;
if ($num_results1 > 0) {
	while($row = mysql_fetch_array($result1))
	{
	echo $i.") ";
	$name = $row['name'];
	echo $name."<br>";
	$i+=1;
	}
}
else {
	echo "Sorry, no categories available :("."<br>";
}
?>

<input type="text" name="catesearch">
<input type="submit" value="Search By Category">
</form>
<br>
OR <br><br>
<form action="searchgrp.php" method="post">
Search by Name: <br>
<input type="text" name="namesearch">
<input type="submit" value="Search">
</form>
<br><br>

</form>
</body>
</html>