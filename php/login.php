<?php	
	require_once('includes/connection.php');
	require_once('includes/safety_feature.php'); 
	
	if(!empty($_POST)){
		$password = sanitizeMySql($_POST['password']);
		$password = sha1($password);
		$email = sanitizeMySql($_POST['email']);
		$query = "SELECT u.email, u.password, u.first_name, u.last_name FROM users u WHERE u.email = '{$email}' AND u.password = '{$password}'";			
		
		$result_set = mysql_query($query);		
		if (!$result_set) {
			die("Database access failed: " . mysql_error());
		} elseif (mysql_num_rows($result_set)) {		
			$row = mysql_fetch_row($result_set);
		
			// store session after succesful login			
			session_start();
                        session_regenerate_id(true);
			$_SESSION['email'] = $row[0];
			$_SESSION['first_name'] = $row[2];
			$_SESSION['last_name'] = $row[3];		

			
			// TODO change cookie expire to longer perhaps
			// set cookies that expire in 1 day for javascript access in index.html
			// so that user that has logged in does not need to enter pass again
			setcookie("first_name",  $row[2], time() + 24 * 60 * 60, '/');
			setcookie("last_name", $row[3], time() + 24 * 60 * 60, '/');
			
			echo "login success";
			/* to destroy and kill and explode hahaha
			destroy_session_and_data();
			setcookie("first_name",  $row[2], time() - 30000, '/');
			setcookie('last_name', $row[3], time() - 30000, '/');
			*/									
			header("Location: ../main.html");			
		} else {
			echo "login error";
			header("Location: ../index.html");
		}	
	}
?>