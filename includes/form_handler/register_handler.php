<?php


//Declare variable
$fname = "";
$lname = "";
$email = "";
$pass = "";
$conpass = "";
$date = "";
$error_array = array();

if (isset($_POST['register'])) {
	
	$fname = strip_tags($_POST['reg_fname']);
	$fname = str_replace(" ", "", $fname);
	$fname = ucfirst($fname);
	$_SESSION['reg_fname'] = $fname;

	$lname = strip_tags($_POST['reg_lname']);
	$lname = str_replace(" ", "", $lname);
	$fname = ucfirst($fname);
	$_SESSION['reg_lname'] = $lname;
	
	$email = strip_tags($_POST['reg_email']);
	$email = str_replace(" ", "", $email);
	$_SESSION['reg_email'] = $email;
	
	$pass = strip_tags($_POST['reg_pass']);
	$conpass = strip_tags($_POST['reg_con_pass']);

	$date = date("Y-m-d");

	if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$email = filter_var($email, FILTER_VALIDATE_EMAIL);

		$email_check = mysqli_query($con, "SELECT email FROM users WHERE email='$email'");

		$row_count = mysqli_num_rows($email_check);

		if($row_count > 0 ){
			array_push($error_array, "email already in use !<br>") ;
		}

	}else{
		array_push($error_array, "Invalid Email format<br>");
	}

	if (strlen($fname) > 25 || strlen($fname) < 2) {
		array_push($error_array, "First name Should be between 2 and 25 characters!<br>");
	}

	if (strlen($lname) > 25 || strlen($fname) < 2) {
		array_push($error_array, "Last Name Should be between 2 and 25 characters!<br>");
	}

	if ($pass != $conpass) {
		array_push($error_array, "password didn't match<br>");
	}else{
		if (preg_match('/[^A_Z0-9a-z]/', $pass)) {
			array_push($error_array, "pass should contain letter & number<br>");
		}
	}

	if (strlen($pass) > 30 || strlen($pass) < 5) {
		array_push($error_array, "password should between 5 & 30<br>");
	}

	if (empty($error_array)) {
		$pass = md5($pass);

		$username = strtolower($fname ."_" . $lname);
		$check_username = mysqli_query($con, "SELECT user_name FROM users WHERE user_name = '$username'");

		$i = 0;

		while (mysqli_num_rows($check_username) != 0) {
			$i++;
			$username = $username . "_" . $i;
			$check_username = mysqli_query($con, "SELECT user_name FROM users WHERE user_name = '$username'");

		}

		$rand = rand(1,2);
		if ($rand == 1) {
			$profile_pic = "assets/img/profile_pic/default/default1.jpg";
		}else if($rand == 2){
			$profile_pic = "assets/img/profile_pic/default/default2.jpg";
		}

		$insert_query = mysqli_query($con, "INSERT INTO users VALUES('', '$fname', '$lname', '$username', '$email', '$pass', '$date', '$profile_pic', '0', '0', 'no', ',')");

		// $array_push($error_array, "<span style='color: green;'>Successfully Inserted! <br> Please Log in to continue!<br></span>");

		$_SESSION['reg_fname'] = "";
		$_SESSION['reg_lname'] = "";
		$_SESSION['reg_email'] = "";
		
	}
}

?>