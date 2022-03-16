<?php 
	
require_once 'inc/db.php'; 
date_default_timezone_set('Asia/Manila');
$loginID = mysqli_real_escape_string($conn, $_POST['id']);
$timestamp = mysqli_real_escape_string($conn, $_POST['time']);
var_dump($timestamp);
// $timestamp = date('Y-m-d H:i:s', strtotime($timestamp));
var_dump($loginID);
var_dump($timestamp);
mysqli_query($conn, "update login set logout = '$timestamp' where id=$loginID");   
    header("location: index.php");

 ?>