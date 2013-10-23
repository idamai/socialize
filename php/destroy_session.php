<?php
session_start();
destroy_session_and_data();

function destroy_session_and_data()
{
	$_SESSION = array();
	if (session_id() != "" || isset($_COOKIE[session_name()]))
	setcookie(session_name(), '', time() - 2592000, '/');
	session_destroy();
}
?>