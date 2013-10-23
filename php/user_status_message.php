<?php

/**
 * This file contains the implementation of the page in SOCialize where an user
 * can create, view, update and delete his personal status message.
 */
session_start();

require_once('includes/connection.php');
require_once('includes/safety_feature.php');

$signUpPage = "signUp.html";
$logInPage = "index.html";
$new_status = "";

// Check if user is logged in.
$isLoggedIn = isset($_SESSION['email']);
$user_email = "";
$user_firstName = "";


// Stop at this point, if user is not logged in.
if (!$isLoggedIn) {

    echo <<<_NOTIF
    <h3>You aren't SOCializing yet.</h3>
        <p><a href='$signUpPage'>Sign up</a> or
            <a href='$logInPage'> log in</a>.</p>
_NOTIF;

    die();
    
} else {
    $user_email = $_SESSION['email'];
    $user_firstName = $_SESSION['first_name'];
}

// If there was a previous POST request to this page (to change the user's
// personal status), propagate the request to the underlying database now.
if (isset($_POST['status_message'])) {

    $new_status = $_POST['status_message'];
    $clean_status = sanitizeMySQL($_POST['status_message']);

    // Replace multiple whitespace with a single one.
    $clean_status = preg_replace('/\s\s+/', ' ', $clean_status);

    // Query the database.
    $result = mysql_query("UPDATE users u SET u.status_update='$clean_status' WHERE u.email='$user_email'");

    // Catch SQL errors.
    if (!$result) {  
        die('Failed to update status message. ' . mysql_error());
    } else {
        // A success message for the calling AJAX function.
        echo $new_status;
    }
    
} else {
    
    // Display the user's details.
    // Show his personal status.
    
    $result = mysql_query("SELECT u.status_update FROM users u WHERE u.email='$user_email'");

    if (!$result) {

        die(mysql_error());
        
    } else {

        $row = mysql_fetch_row($result);

        // TODO: echo a single JSON object below, and do html/text in the calling html doc instead.
        
        echo "<b>Hello $user_firstName. Previously you said</b>: \"";

        if (!is_null($row[0])) {
            $current_status = $row[0];
            echo $current_status;
        } else {
            echo "<i>Looks like you had nothing to say.</i>";
        }
        echo "<br><br>";
    }
}
?>