<?php
	
	session_start();

	if(!empty($_POST))
	{
		extract($_POST);
		$_SESSION['error']=array();

		if(empty($fnm))
		{
			$_SESSION['error']['fnm']="Please enter Full Name";
		}
		
		if(empty($mno))
		{
			$_SESSION['error']['mno']="Please enter Mobile Number";
		}
		else if(!empty($mno))
		{
			if(!is_numeric($mno))
			{
				$_SESSION['error']['mno']="Please Enter Numeric Mobile Number";
			}
		}

		if(empty($msg))
		{
			$_SESSION['error']['msg']="Please enter Message";
		}	

		if(empty($email))
		{
			$_SESSION['error']['email']="Please enter E-Mail ID";
		}

		if(!empty($_SESSION['error']))
		{
			header("location:contact.php");
			exit();
		}
		else
		{
			include("includes/connection.php");

			$t=time();

			// Use prepared statement to prevent SQL injection
			$q = "INSERT INTO contact(c_nm, c_email, c_msg, c_time) VALUES (?, ?, ?, ?)";
			$stmt = $link->prepare($q);
			$stmt->bind_param("sssi", $fnm, $email, $msg, $t);
			
			if($stmt->execute()) {
				header("location:contact.php");
			} else {
				$_SESSION['error'][] = "Error saving your message. Please try again.";
				header("location:contact.php");
			}
			exit();
		}
	}
	else
	{
		header("location:contact.php");
		exit();
	}
?>