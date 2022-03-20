<?php 	
require_once '../inc/session.php';
require '../inc/head.php';
require_once '../inc/db.php';
require_once '../inc/hash.php';
require_once 'head.php';


$username = mysqli_real_escape_string($conn, $_POST['username']);
$name = mysqli_real_escape_string($conn, $_POST['name']);
$pass = mysqli_real_escape_string($conn, $_POST['pass']);
$id = mysqli_real_escape_string($conn, $_POST['id']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$fetchuser = mysqli_query($conn, "SELECT * FROM users where username='$username' and NOT id=$id");
$user = $fetchuser->fetch_assoc();
if (preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.* )(?=.*[^a-zA-Z0-9]).{8,16}$/m', $pass)) {
  if (!empty($user)) {
      $_SESSION["error"] = "Username Already taken";
    header("location: users.php");
  } else {
    $password = encryp_word($pass);
    $insert_code = "UPDATE users set username='$username',password='$password',name='$name',email='$email' where id=$id";
    mysqli_query($conn, $insert_code);
    if (isset($_POST['meta'])) {
      foreach ($_POST['meta'] as $key => $value) {
        $insert_code = "UPDATE meta set value='$value' where id='$key'";
        mysqli_query($conn, $insert_code);
      }
    }
    $_SESSION["info"] = "Edit Success!";
    header("location: users.php");
  }
  

} else {
      $_SESSION["error"] = "Password Invalid";
  
    header("location: users.php");
}

 ?>