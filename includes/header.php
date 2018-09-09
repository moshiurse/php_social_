<?php

require "config/config.php";

if (isset($_SESSION['username'])) {
	$userLogged = $_SESSION['username'];
}else {
	header("Location: register.php");
}

?>

<!DOCTYPE html>
<html>
<head>
</head>
<body>
	Hello Everyone!
</body>
</html>