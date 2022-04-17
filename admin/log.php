<?php 
require_once '../inc/db.php';
require_once '../inc/otp.php';

session_start();
$username =  $_SESSION["username"];
$getotp = mysqli_query($conn, "SELECT * FROM users where username = '$username' ");
$otp = $getotp->fetch_assoc();
// var_dump($_POST);
// var_dump($otp);
// var_dump(otpVerify($_POST["code"], $otp['otp']));
if (otpVerify($_POST["code"], $otp['otp'])) {
    $_SESSION["loggedin"] = true;
    header("location: ../admin/index.php");
} else {
    $_SESSION["error"] = "OTP Incorrect";
    header("location: ../admin/otp.php");
}
// date_default_timezone_set('Asia/Manila');
// check if expired
// $timecreate = strtotime($otp['created_at']);
// $now = strtotime(date("Y-m-d H:i:s"));
// $mins = ($now - $timecreate)/60;
// if ($otp['code'] === $_POST["code"]) {
//     if ($mins < 15) {
//         $_SESSION["loggedin"] = true;
//         header("location: ../admin/index.php");
//     } else {
//         $_SESSION["error"] = "OTP Expired";
//         header("location: /admin/login.php");
//     }

// } else {
//     $_SESSION["error"] = "OTP Incorrect";
//     header("location: /admin/login.php");

// }
 ?>