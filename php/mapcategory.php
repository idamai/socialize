<?php session_start() ?>
<?php

require_once('includes/connection.php');
require_once('includes/safety_feature.php');

$grp_name = $_POST['group'];
$category = $_POST['category'];

$query = "INSERT INTO group_category VALUES ('{$grp_name}','{$category}')";
$result = mysql_query($query);

if (!$result) {
    echo "Categorizing fail error: " . mysql_error();	
} else {
    echo "Your group current category:</br>";
}

$query = "SELECT gc.cat_name FROM group_category gc WHERE gc.grp_name = '{$grp_name}'";
$result = mysql_query($query);
$size = mysql_num_rows($result);
for ($j = 0; $j < $size; $j++) {
    $row = mysql_fetch_array($result);
    $group_cat = $row['cat_name'];
    echo $group_cat . "</br>";
}
?>