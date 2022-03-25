<?php 
require 'inc/head.php';

require_once 'inc/db.php';

date_default_timezone_set('Asia/Manila');
 require_once 'header.php';
$reg_id = mysqli_real_escape_string($conn, $_POST['code']);
$name = mysqli_real_escape_string($conn, $_POST['name']);
$log = mysqli_real_escape_string($conn, $_POST['type']);
$subject = mysqli_real_escape_string($conn, $_POST['subject']);
$type = mysqli_real_escape_string($conn, $_POST['level']);
$timestamp = mysqli_real_escape_string($conn, $_POST['time']);
$today = date('Y-m-d');
    $log = mysqli_query($conn, "SELECT * FROM login WHERE reg_id = '$reg_id' and login between '$today 00:00:00' and '$today 23:59:59' and logout is null");
    $login = $log->fetch_assoc();
    $timestamp =$_POST['time'];
    $timestampFormated =date("g:i:s A F j, Y l");
    if ($login) {
        $loginID = $login['id'];
        mysqli_query($conn, "update login set logout = '$timestamp' where id=$loginID");   
        $loggedin = date("g:i:s A F j, Y l", strtotime($login['login'])) ;
    } else {
        $insert_code = "INSERT INTO `login`(`name`, `type`, `reg_id`, `date`, `subj`, `login`) VALUES (?,?,?,?,?,?)";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $insert_code)){
            $errors['username'] = "Registration Failed!";
        }
        else{
            mysqli_stmt_bind_param($stmt, "ssssss", $name, $type, $reg_id, $today,$subject,$timestamp);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }        
    }
    // var_dump($errors['username']);
      header("location: index.php");

 ?>