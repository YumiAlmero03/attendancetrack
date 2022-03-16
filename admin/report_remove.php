<?php 
require_once '../inc/db.php';

$id = $_POST['id'];
var_dump($id);
mysqli_query($conn, "update report set remove = 1 where reg_id=$id"); 

header("location: registered.php");

 ?>