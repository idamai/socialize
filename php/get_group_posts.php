<?php session_start() ?>
<?php
	require_once('includes/connection.php');	
		
	if (isset($_POST['selected_group'])){		
		$groupName = mysql_real_escape_string($_POST['selected_group']);
		$query = "SELECT * FROM posts p 
				  WHERE p.grp_name='$groupName'
				  ORDER BY time DESC";
		$result = mysql_query($query);
		$user = $_SESSION['email'];
		
		if (!$result) {
			die ("Unable to load group: ". mysql_error());
		} else {			
			echo "<ul>";						
			while ($row = mysql_fetch_array($result))
			{	
				$pid = $row['post_id'];
				$poster = $row['poster'];
				$msg  =	$row['contents'];	
				$time = $row['time'];
				
				echo "<li class='post' data-pid=$pid>";
				echo "<div class='poster'>$poster</div>";				
				echo "<div class='message'>$msg</div>";
				echo "<div class='time'>posted on $time</div>";
				// only the poster of can delete / edit 
				if ($poster == $user)
				{
					$msg = str_replace('<br />',"\n",$msg);
					echo "<div style='display:none' class='edit_post'>
					<textarea type='text'>$msg</textarea>
					<a class='confirm' href=''><img src='img/confirm.png' alt='confirm' width=20/></a></div>";
					echo "<a href='#' class='delete'><img alt='delete' src='img/delete.png' width=16/></a>";
					echo "<a href='#' class='edit'><img alt='edit' src='img/edit.png' width=16/></a>";
				}
				echo "</li>";				
			}			
			echo "</ul>";			
		}
	}	

?>