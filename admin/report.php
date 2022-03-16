<?php 
require_once '../inc/db.php';

$report = mysqli_real_escape_string($conn, $_POST['report']);
$id = mysqli_real_escape_string($conn, $_POST['id']);

$insert_code = "INSERT INTO `report` (`reg_id`, `report`) 
VALUES (?,?)";

$stmt = mysqli_stmt_init($conn);

if(!mysqli_stmt_prepare($stmt, $insert_code)){
    $msg = "Registration Failed!";
}
else{
    mysqli_stmt_bind_param($stmt, "ss", $id, $report);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: registered.php");
}

 ?>