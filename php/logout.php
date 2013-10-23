<?php session_start() ?>
<?php

require_once ('includes/connection.php');

if (isset($_SESSION['email'])) {
    $_SESSION = array();
    if (session_id() != "" || isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 3592000, '/');
        setcookie("first_name", '', time() - 3592000, '/');
        setcookie("last_name", '', time() - 3592000, '/');
    }
    session_destroy();

	header('Location: ../index.html');    
} else {
    
    // destroy cookies if they still exist.
    setcookie(session_name(), '', time() - 3592000, '/');
    setcookie("first_name", '', time() - 3592000, '/');
    setcookie("last_name", '', time() - 3592000, '/');
    header('Location: ../index.html');    
    // echo "You cannot log out because you are not logged in. Go back to the <a href='../index.html'>main page.</a>";
}
?>