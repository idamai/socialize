<?php session_start(); ?>
<?php

/**
 * This PHP script executes 2 queries, one to create a group, another to add
 * the category.
 */
require_once('includes/connection.php');

if (!isset($_SESSION['email'])) {
    header("Location: ../index.html");
    exit;
} else {
    
    $errorMsg = "";
    $successMsg = "";
    
    // Create the group.
    
    if (isset($_POST['name']) &&
            isset($_POST['description']) &&
            isset($_POST['isprivate'])) {
        $admin = $_SESSION['email'];
        $grp_name = mysql_real_escape_string($_POST['name']);
        $description = mysql_real_escape_string($_POST['description']);
        $isPrivate = mysql_real_escape_string($_POST['isprivate']);
        $icon = 'default.jpg';
        $query = "INSERT INTO interest_groups VALUES('{$admin}','{$grp_name}','{$description}','{$isPrivate}','{$icon}')";
        $result = mysql_query($query);
        if (!$result) {
            $errorMsg .= "Creating new group error: " . mysql_error();
        } else {
            $_SESSION['group'] = $grp_name;
            $timestamp = time();
            $query = "INSERT INTO member_of VALUES ('{$grp_name}','{$admin}',FROM_UNIXTIME({$timestamp}))";
            $result_insert = mysql_query($query);
            if (!$result_insert) {
                $errorMsg .= "Operation fail! " . mysql_error();
            } else {
                $successMsg .= "Group created. </br></br>";
            }
        }

        
        // Having created the group, now let's
        // add this group to the specified category.
        
        $grp_name = $_POST['name'];

        if (!isset($_POST['category'])) {
            $category = 'Other'; // This is a fall-back.
        } else {
            $category = $_POST['category'];
        }
        
        $query = "INSERT INTO group_category VALUES ('{$grp_name}','{$category}')";
        $result = mysql_query($query);

        if (!$result) {
            $errorMsg .= "Error in adding group to a category: " . mysql_error();
            echo $errorMsg; // report all errors gathered up till this point.
            die();
        } else {
            $successMsg .= "Category assigned. Your group's current category:</br>";
        }

        $query = "SELECT gc.cat_name FROM group_category gc WHERE gc.grp_name = '{$grp_name}'";
        $result = mysql_query($query);
        $size = mysql_num_rows($result);
        for ($j = 0; $j < $size; $j++) {
            $row = mysql_fetch_array($result);
            $group_cat = $row['cat_name'];
            $successMsg .= $group_cat . "</br>";
        }
        
        // Report success (if any).
        echo $successMsg;
        
        // Move user to main page.
        header("Location:../main.html");
    }
}
?>