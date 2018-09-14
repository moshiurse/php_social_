<?php
 if (isset($_POST['login'])) {
 	
 	$email = filter_var($_POST['log_email'], FILTER_SANITIZE_EMAIL);

 	$_SESSION['log_email'] = $email;
 	$pass = md5($_POST['log_pass']);

 	$check_db = mysqli_query($con, "SELECT * FROM users WHERE email='$email' AND password='$pass'");

 	$check_login = mysqli_num_rows($check_db);

 	if ($check_login == 1) {
 		
 		$row = mysqli_fetch_array($check_db);
 		$username = $row['username'];

 		$user_closed_query = mysqli_query($con, "SELECT * FROM users WHERE email='$email' AND user_closed='yes'");
 		if (mysqli_num_rows($user_closed_query) == 1) {
 			$reopen_account = mysqli_query($con, "UPDATE users SET user_closed='no' WHERE email='$email'");
 		}

 		$_SESSION['username'] = $username;
 		header("Location: index.php");
 		exit();
 	}
 	else{
 		array_push($error_array, "Email or Password is incorrect!!<br>");
 	}

 }

?>