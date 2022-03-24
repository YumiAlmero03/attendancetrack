<?php 	
require_once '../inc/session.php';
require '../inc/head.php';
require_once '../inc/db.php';
require_once '../inc/hash.php';
require_once 'head.php';
require_once '../inc/otp.php';
require_once '../inc/mail.php';
require_once '../inc/qr.php';


$username = mysqli_real_escape_string($conn, $_POST['username']);
$fn = mysqli_real_escape_string($conn, $_POST['fn']);
$ln = mysqli_real_escape_string($conn, $_POST['ln']);
$name = $fn . ' ' . $ln;
$level = mysqli_real_escape_string($conn, $_POST['level']);
$pass = mysqli_real_escape_string($conn, $_POST['pass']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$gen = createRandomPassword();
$otp = createOTP($gen);
$otp->setLabel('Student Management And Attendance Monitoring System');
$grCodeUri = $otp->getQrCodeUri(
    'https://api.qrserver.com/v1/create-qr-code/?data=[DATA]&size=300x300&ecc=M',
    '[DATA]'
);
$otpcode = $otp->getSecret();
$mailbody = 'You have been  registered in Student Management And Attendance Monitoring System as '.$level.' 
<br> 
here is your login details:
<br> 
Username:"'.$username.'"
<br> 
Password: "'.$pass.'"
<br> 
<br> 
<br> 

your qr code is attached below 
<br> 
<img src="'.$grCodeUri.'">
<br>
<h3>Manual</h3>
email: '.$email.'
key: '.$gen.'
secret: '.$otpcode.'
type: TOTP
email: 6
email: SHA1
interval: [Depends]

';
$fetchuser = mysqli_query($conn, "SELECT * FROM users where username='$username'");
$user = $fetchuser->fetch_assoc();
function uploadFile($post)
{
  
  // photoupload
  $target_dir = "";
  $filename = basename($post["photo"]["name"]);
  $target_file = $target_dir . basename($post["photo"]["name"]);
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

  // Check if image file is a actual image or fake image
  $check = getimagesize($post["photo"]["tmp_name"]);
  if($check !== false) {
    $msg = "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    $msg = "File is not an image.";
    $uploadOk = 0;
  }


  // Check file size
  if ($post["photo"]["size"] > 500000) {
    $msg = "Sorry, your file is too large.";
    $uploadOk = 0;
  }

  // Allow certain file formats
  if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
  && $imageFileType != "gif" ) {
    $msg = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
  }
  // Check if $uploadOk is set to 0 by an error
  if ($uploadOk === 0) {
    return  ['msg' => $msg, 'type' => 'error'];
  // if everything is ok, try to upload file
  } else {
    if (move_uploaded_file($post["photo"]["tmp_name"], $target_file)) {
      return ['msg' => "The file ". htmlspecialchars( basename( $post["photo"]["name"])). " has been uploaded.", 'type' => 'info', 'filename' => $filename];
    } else {
      return ['msg' => "Sorry, there was an error uploading your file.", 'type' => 'error'];
    }
  }
}

if (preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.* )(?=.*[^a-zA-Z0-9]).{8,16}$/m', $pass)) {
  if (!empty($user)) {
      $_SESSION["error"] = "Username Already taken";
    header("location: users.php");
  } else {
    $password = encryp_word($pass);
    $insert_code = "INSERT INTO `registered`(`qrcode`, `firstname`, `lastname`, `type`, `course`, `year`, `section`, `bday`, `email`, `address`, `pname`, `pcontact`, `photo`, `qrphoto`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $insert_code)){
        $_SESSION["error"] = "Registration Failed!";
      header("location: users.php");
    }
    else{

        if ($level === 'class') {
          $type = 'Student';
          $studid = mysqli_real_escape_string($conn, $_POST['meta']['stud_num']);
          $course = $_POST['meta']['course'];
          $yr = $_POST['meta']['yr'];
          $sec = $_POST['meta']['sec'];
          $qrfile = upload_qr($studid, $studid.$course.$yr.$sec.$ln);
        } elseif ($level === 'faculty') {
          $type = 'Faculty';
          $studid = mysqli_real_escape_string($conn, $_POST['meta']['id_num']);
          $course = $_POST['meta']['department'];
          $yr = null;
          $sec = null;
          $qrfile = upload_qr($studid, $studid.$course.$ln);
        }
          $bday = $_POST['meta']['bday'];
          $add = $_POST['meta']['address'];
          $pname = $_POST['meta']['emergency'];
          $pnum = $_POST['meta']['emergency_num'];
          // $msg = uploadFile($_FILES);
          $filename =  $msg['filename'];
          $filename = uploadS3($post["photo"]["name"],$post["photo"]["tmp_name"]);

        mysqli_stmt_bind_param($stmt, "ssssssssssssss", $studid, $fn, $ln, $type, $course, $yr, $sec, $bday, $email, $add, $pname, $pnum, $filename, $qrfile);
        mysqli_stmt_execute($stmt);
        $reg_id = mysqli_stmt_insert_id($stmt);

        // user create
        // mysqli_query($conn, "INSERT INTO `users` (`username`, `password`, `level`, `name`, `email`, `otp`) VALUES ('$username', '$password', '$level', '$name', '$email', '$otpcode')"); 
        $insert_code = "INSERT INTO `users` (`username`, `password`, `level`, `name`, `email`, `otp`, `reg_id`) 
        VALUES (?,?,?,?,?,?,?)";

        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $insert_code)){
            $_SESSION["error"] = "Registration Failed!";
          header("location: users.php");
        }
        else{
            mailSend($email,$name,'User Created',$mailbody);
            mailQR($email, $fn.' '.$ln, $qrfile, $course.$yr.$sec.$ln);
            mysqli_stmt_bind_param($stmt, "sssssss", $username, $password, $level, $name, $email,$otpcode,$reg_id );
            mysqli_stmt_execute($stmt);
            $id = mysqli_stmt_insert_id($stmt);
          // meta
          foreach ($_POST['meta'] as $key => $value) {
            mysqli_query($conn, "INSERT INTO `meta`(`key`,`value`, `user_id`) VALUES ('$key','$value','$id')"); 
          }
        }
        // mysqli_stmt_close($stmt);

        $_SESSION["info"] = "Registered!";
      header("location: users.php");
    }
  }
  
} else {
    $_SESSION["error"] = "Password Invalid! Password must have atleast one capital letter, symbol and number";
    header("location: users.php");
}

 ?>

 <div class="container-fluid p-5">
    <div class="card">
      <div class="card-header bg-main text-white text-center">
        <h3 class="text-white">User Created</h3>
      </div>
      <div class="card-body">
        <table class="table  table-borderless">
          <tr>
            <th class="text-second">Username: </th>
            <td><?php  echo $username; ?></td>
            <th class="text-second">Full Name: </th>
            <td><?php  echo $name; ?></td>
          </tr><tr>
            <th class="text-second">Email: </th>
            <td><?php  echo $email; ?></td>
            <th class="text-second">Password: </th>
            <td><?php  echo $pass; ?></td>
          </tr><tr>
            <th class="text-second text-center" colspan="4">QR: </th>
          </tr>
          <tr>
            <td class="text-center" colspan="4"><img src="<?php  echo $grCodeUri; ?>"></td>
          </tr>
          <tr>
            <th class="text-second">Secret: </th>
            <td colspan="3"><?php  echo $otpcode; ?></td>
          </tr>
          <tr>
            <th class="text-second">Type: </th>
            <td>TOTP</td>
            <th class="text-second">User Level: </th>
            <td><?php  echo ucfirst($level); ?></td>
          </tr>
        </table>
      </div>
      <div class="card-footer">
          <a href="users.php" class="btn bg-second text-white btn-block" >Back</a>
      </div>
    </div>
 	<h3>
 	</h3>

 </div>