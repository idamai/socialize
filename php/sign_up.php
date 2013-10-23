<?php
	require_once('includes/connection.php');
	require_once('includes/safety_feature.php'); 		
	
	$email = mysql_entities_fix_string($_POST["email"]);
	$password = sha1(mysql_entities_fix_string($_POST["password"]));
	$firstName = mysql_entities_fix_string($_POST["firstName"]);
	$lastName = mysql_entities_fix_string($_POST["lastName"]);
	$birthday = mysql_entities_fix_string($_POST["birthday"]);
	$gender = mysql_entities_fix_string($_POST["gender"]);
	$status_update = "What''s on your mind?";
    $status_marital = mysql_entities_fix_string($_POST["marital"]);
	// $privacy = mysql_entities_fix_string($_POST["privacy"]);
        $privacy = 0; // all profiles are set to public for now. -PH (14 April 1.30pm)
	$picture = "img/profile-photo.jpg";
	
	$query = "INSERT INTO users VALUES(" .
			"'$email',
			'$password', 
			'$firstName', 
			'$lastName',
			'$birthday',
			'$gender',
			'$status_update',
			'$status_marital',
			'$privacy',
			'$picture'
			)";
		
	if (!mysql_query($query, $db_server)) {
		die("INSERT FAILED" . mysql_error());
	} else {
		session_start();
		$_SESSION['first_name'] = $firstName;
		$_SESSION['last_name'] = $lastName;	
		$_SESSION['email'] = $email;	
		
		// TODO change cookie expire to longer perhaps
		// set cookies that expire in 30 sec for javascript access in index.html
		// so that user that has logged in does not need to enter pass again
		setcookie("first_name",  $firstName, time() + 24 * 60 * 60, '/');
		setcookie('last_name', $lastName, time() + 24 * 60 * 60, '/');
	
		header("Location: ../main.html");
	}
	
	function mysql_entities_fix_string($string)
	{
		return htmlentities(mysql_fix_string($string));
	}	
	
	function mysql_fix_string($string)
	{
		if (get_magic_quotes_gpc()) $string = stripslashes($string);
		return mysql_real_escape_string($string);
	}
?>