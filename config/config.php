<?php

//errror show
error_reporting(0);

ob_start();
//session start
session_start();

$timezone = date_default_timezone_set("Asia/Dhaka");
//Create connection with db
$con = mysqli_connect("localhost","root","","test");
// Check connection
if (mysqli_connect_errno())
{
echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

?>