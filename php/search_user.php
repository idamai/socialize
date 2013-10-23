<?php // userSearchResult.php
function IsChecked($check,$value)
    {
        if(!empty($_POST[$check]))
        {
            foreach($_POST[$check] as $chkval)
            {
                if($chkval == $value)
                {
                    return true;
                }
            }
        }
        return false;
    }
	
require_once 'includes/connection.php'; 

$nameiwant = $_POST["namesrch"];
$emailiwant = $_POST["emailsrch"];
$yrJDiwant = $_POST["year_JDsrch"];
$mthJDiwant = $_POST["mth_JDsrch"];
$dayJDiwant = $_POST["day_JDsrch"];

$JDiwant = $yrJDiwant."-".$mthJDiwant."-".$dayJDiwant;

$name_query = "SELECT distinct * FROM `users` u WHERE u.first_name = '$nameiwant' OR u.last_name = '$nameiwant'";
$email_query = "SELECT * FROM `users` u WHERE u.email = '$emailiwant'";
$JD_query = "SELECT * FROM `users` u, `member_of` m WHERE m.join_date = '$JDiwant' AND m.usr_name = u.email";

if (IsChecked('check','A') AND IsChecked('check','B') AND IsChecked('check','C'))
	$result = mysql_query($name_query." INTERSECT ".$email_query." INTERSECT ".$JD_query);
else if (IsChecked('check','A') AND IsChecked('check','B'))
	$result = mysql_query($name_query." INTERSECT ".$email_query);
else if (IsChecked('check','A') AND IsChecked('check','C'))
	$result = mysql_query($name_query." INTERSECT ".$JD_query);
else if	 (IsChecked('check','B') AND IsChecked('check','C'))
	$result = mysql_query($email_query." INTERSECT ".$JD_query);
else if	 (IsChecked('check','A'))
	$result = mysql_query($name_query);
else if	 (IsChecked('check','B'))
	$result = mysql_query($email_query);
else if	 (IsChecked('check','C'))
	$result = mysql_query($JD_query);
else {
	echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Pls check the fields you want to search!!')
        window.location.href='\searchUser.html'
        </SCRIPT>");
	echo "<br>";
	$result = -1;}

if ($result == false)
	$result = -1;
	
if ($result <> -1)
	$num_results = mysql_num_rows($result);
else
	$num_results = -1;

if ($num_results > 0) {
	while($row = mysql_fetch_array($result))
	{
	echo $row['profile_picture'];
	echo "<br>";
	echo "Name: " . $row['first_name'] . " " . $row['last_name'];
	echo "<br>";
	echo "Email: " . $row['email'];
	echo "<br>";
	echo "Birthday: " . $row['birthday'];
	echo "<br>";
	echo "Gender: " . $row['gender'];
	echo "<br>";
	echo "Status: " . $row['status'];
	echo "<br>";
	echo "<br>";

	}
}
else {
	echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Result Not Found!!')
        window.location.href='\searchUser.html'
        </SCRIPT>");
}
?>