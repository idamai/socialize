<?php
	require_once ('safety_feature.php');
	require_once ('constants.php');
	
	$db_hostname = DB_HOSTNAME;
	$db_username = DB_USERNAME;
	$db_password = DB_PASSWORD;
	$db_database = DB_DATABASE;
	
	$timezone = "Asia/Singapore"; 
		if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);

	$db_server = mysql_connect($db_hostname, $db_username, $db_password);
	
	if (!$db_server) die ("Unable to connect to MySQL: " . mysql_error());
	
	$db_select = mysql_select_db($db_database);
	if (!$db_select) die ("Unable to select database: " . mysql_error());
?>