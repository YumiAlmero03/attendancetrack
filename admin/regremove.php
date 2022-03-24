<?php 
require_once '../inc/db.php';

$id = mysqli_real_escape_string($conn, $_GET['id']);

$insert_code = "DELETE FROM `registered` where id=?";

$stmt = mysqli_stmt_init($conn);

if(!mysqli_stmt_prepare($stmt, $insert_code)){
    $msg = "Delete Failed!";
}
else{
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    $msg = "Delete Success!";
    header("location: ". $_SERVER['HTTP_REFERER']);
}

 ?>