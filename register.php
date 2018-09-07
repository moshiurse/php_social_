<?php
//errror show
error_reporting(0);
//session start
session_start();
//Create connection with db
$con = mysqli_connect("localhost","root","","test");
// Check connection
if (mysqli_connect_errno())
{
echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

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
	$email = ucfirst($email);
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

<!DOCTYPE html>
<html>
<head>
	<title>Register Here</title>
</head>
<body>
	<form action="register.php" method="POST">

	<input type="text" name="reg_fname" placeholder="First Name"
	value="<?php 
	if(isset($_SESSION['reg_fname'])){
		echo $_SESSION['reg_fname'];
	}	 ?>" required>
	<?php if(in_array("First name Should be between 2 and 25 characters!<br>", $error_array))
	 echo "First name Should be between 2 and 25 characters!"; ?>
	<br> 
	<input type="text" name="reg_lname" placeholder="Last Name"
		value="<?php 
	if(isset($_SESSION['reg_lname'])){
		echo $_SESSION['reg_lname'];
	} ?>" required>

	<?php if(in_array("Last name Should be between 2 and 25 characters!", $error_array))
	 echo "Last name Should be between 2 and 25 characters!<br>"; ?>
	<br>

	<input type="email" name="reg_email" placeholder="Email" 
		value="<?php 
	if(isset($_SESSION['reg_email'])){
		echo $_SESSION['reg_email'];
	}	 ?>" required>

	<?php if(in_array("email already in use !<br>", $error_array))
	 echo "email already in use !"; ?>

	 <?php if(in_array("Invalid Email format<br>", $error_array))
	 echo "Invalid Email format"; ?>
	<br>
	<input type="password" name="reg_pass" placeholder="Password" required>
	<br>
	<input type="password" name="reg_con_pass" placeholder="Confirm password" required>
	<?php if(in_array("password didn't match<br>", $error_array)) echo "password didn't match";
	else if(in_array("pass should contain letter & number<br>", $error_array)) echo "pass should contain letter & number";
	else if(in_array("password should between 5 & 30<br>", $error_array)) echo "password should between 5 & 30"; ?>

	<br>
	<input type="submit" name="register" value="Register">
	<br>
<!-- 	 <?php if(in_array("<span style='color: green;'>Successfully Inserted! <br> Please Log in to continue!<br></span>", $error_array))
	 echo "<span>Successfully Inserted! <br> Please Log in to continue!<br></span>"; ?> -->

	</form>

</body>
</html>