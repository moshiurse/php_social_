<?php

require "config/config.php";

require "includes/form_handler/register_handler.php";
require "includes/form_handler/login_handler.php";

?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="assets/css/register.css">
	<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
  <script type="text/javascript" src="assets/js/register.js"></script>
	<title>Register Here</title>
</head>
<body>

	<?php

		if (isset($_POST['register'])) {
			echo '
				<script>
				$(document).ready(function(){
						$("#log").hide();
						$("#reg").show();
					});
				</script>
			';
		}
	?>


	<div class="wrapper">
		<div class="login_box">
			<div class="login_header">
				<h3>Social</h3>
				Login or Sign Up 
			</div>
	<div id="log">
	<form action="register.php" method="POST">
		<input type="email" name="log_email" placeholder="Email" value="<?php 
	if(isset($_SESSION['log-email'])){
		echo $_SESSION['log-email'];
	}	 ?>" required>
		<br>
		<input type="password" name="log_pass" placeholder="Password">
		<br>
		<input type="submit" name="login" value="Login">
		<br>
		<a href="#" id="signup" class="signup">Need an account? Register Here!</a>
		<br>

		<?php if (in_array("Email or Password is incorrect!!<br>", $error_array)) echo "Email or Password is incorrect!!<br>"; ?>
	</form>
	</div>
<br>
	<div id="reg">
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
	<a href="#" id="signin" class="signin">Already have an account? Login Here!</a>
	<br>
<!-- 	 <?php if(in_array("<span style='color: green;'>Successfully Inserted! <br> Please Log in to continue!<br></span>", $error_array))
	 echo "<span>Successfully Inserted! <br> Please Log in to continue!<br></span>"; ?> -->

	</form>
	</div>
</div>
</div>

</body>
</html>