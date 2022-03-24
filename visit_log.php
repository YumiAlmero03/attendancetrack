<?php 
require 'inc/head.php';

require_once 'inc/db.php';
date_default_timezone_set('Asia/Manila');
$name = mysqli_real_escape_string($conn, $_POST['name']);
$purpose = mysqli_real_escape_string($conn, $_POST['purpose']);
$address = mysqli_real_escape_string($conn, $_POST['address']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$passnum = mysqli_real_escape_string($conn, $_POST['passnum']);
$type = mysqli_real_escape_string($conn, $_POST['type']);
$time = mysqli_real_escape_string($conn, $_POST['time']);
$today = date('Y-m-d');

$img = $_POST['image'];
    $folderPath = "uploads/visit/";
  
    $image_parts = explode(";base64,", $img);
    $image_type_aux = explode("image/", $image_parts[0]);
    $image_type = $image_type_aux[1];
  
    $image_base64 = base64_decode($image_parts[1]);
    $fileName = uniqid() . '.png';
  
    $file = uploadS3($fileName,$_POST['image']);
    ;

$insert_visit = "INSERT INTO visitor (name, purpose, address,email,passnum,photo,type) VALUES ('$name','$purpose','$address','$email','$passnum','$file','$type')";
    mysqli_query($conn,$insert_visit);
    $getID = mysqli_insert_id($conn);
    $insert_code = "INSERT INTO `login` (`name`, `type`, `reg_id`, `date`, `login`) VALUES (?,?,?,?,?)";

    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $insert_code)){
        $msg = "Registration Failed!";
    }
    else{
        mysqli_stmt_bind_param($stmt, "sssss", $name, $type,$getID,$today,$time);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

    }
    header("location: index.php");
    
 ?>