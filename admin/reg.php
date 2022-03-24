<?php   
require_once '../inc/session.php';
require '../inc/head.php';
require_once '../inc/db.php';
require_once '../inc/qr.php';
require_once '../inc/mail.php';


$fn = mysqli_real_escape_string($conn, $_POST['fn']);
$ln = mysqli_real_escape_string($conn, $_POST['ln']);
$course = mysqli_real_escape_string($conn, $_POST['course']);
$yr = mysqli_real_escape_string($conn, $_POST['yr']);
$sec = mysqli_real_escape_string($conn, $_POST['sec']);
$bday = mysqli_real_escape_string($conn, $_POST['bday']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$add = mysqli_real_escape_string($conn, $_POST['add']);
$pname = mysqli_real_escape_string($conn, $_POST['pname']);
$pnum = mysqli_real_escape_string($conn, $_POST['pnum']);
$type = mysqli_real_escape_string($conn, $_POST['type']);

  $target_dir = "../uploads/profile/";
  $filename = basename($post["photo"]["name"]);
  $target_file = $target_dir . basename($post["photo"]["name"]);
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));



if (isset($_POST['register'])) {
$studid = mysqli_real_escape_string($conn, $_POST['studid']);

  $filename = uploadS3($studid.$sec.$ln.'-profile.png',$_FILES["photo"]["tmp_name"]);
  $insert_code = "INSERT INTO `registered`(`qrcode`, `firstname`, `lastname`, `type`, `course`, `year`, `section`, `bday`, `email`, `address`, `pname`, `pcontact`, `photo`, `qrphoto`) 
  VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

  $stmt = mysqli_stmt_init($conn);
  if(mysqli_stmt_prepare($stmt, $insert_code)){
    // if ($msg['type'] === 'info') {
      $qrfile = upload_qr($studid, $studid.$course.$ln.'-qr');
      // $filename =  $msg['filename'];
        mysqli_stmt_bind_param($stmt, "ssssssssssssss", $studid, $fn, $ln, $type, $course, $yr, $sec, $bday, $email, $add, $pname, $pnum, $filename, $qrfile);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        mailQR($email, $fn.' '.$ln, $qrfile, $course.$yr.$sec.$ln);
        header("location: registered.php");
      $_SESSION["info"] = "Registered!";
    // } else {
    //    $_SESSION["error"] = $msg['msg'];
    //     // header("location: register.php");
    // }
  }
  else{
       $_SESSION["error"] = 'Registration Failed!';
      header("location: register.php");
  }
} elseif(isset($_POST['update'])) {
  $reg_id = $_POST['reg_id'];
  $getReg = mysqli_query($conn, "SELECT * FROM `registered` where id=$reg_id");
              $registered = $getReg->fetch_assoc();
  $qrfile = $registered['qrphoto'];
    $filename = $registered['photo'];
    if ($_FILES['photo']['name'] != '') {
        $filename = uploadS3($studid.$sec.$ln.'-profile.png',$_FILES["photo"]["tmp_name"]);
    }
    // var_dump($filename);
  $test = mysqli_query($conn, "UPDATE `registered` SET `firstname` = '".$fn."', `lastname` = '".$ln."', `course` = '".$course."', `year` = '".$yr."', `section` = '".$sec."', `bday` = '".$bday."', `email` = '".$email."', `address` = '".$add."', `pname` = '".$pname."', `pcontact` = '".$pnum."', `photo` = '".$filename."' WHERE `id`=".$reg_id); 
      $_SESSION["info"] = "Edited!";
  header("location: register.php?id=".$reg_id);
}
 ?>

 <div class="center-div">
    <div class="card">
      <div class="card-header bg-main">
        <h3 class="text-second">Registered</h3>
      </div>
      <div class="card-body">
        <div class="text-center">
          <img src="<?php echo $qrfile; ?>">
        </div>
        <table class="table  table-borderless">
          <tr>
            <th class="text-second">Name: </th>
            <td><?php  echo $fn ." ". $ln; ?></td>
            <th class="text-second">Course: </th>
            <td><?php  echo $course; ?></td>
          </tr>
          <tr>
            <th class="text-second">Year: </th>
            <td><?php  echo $yr; ?></td>
            <th class="text-second">Section: </th>
            <td><?php  echo $sec; ?></td>
          </tr>
          <tr>
            <th class="text-second">Birthday: </th>
            <td><?php  echo $bday; ?></td>
            <th class="text-second">Email: </th>
            <td><?php  echo $email; ?></td>
          </tr>
          <tr>
            <th colspan="1" class="text-second">Address: </th>
            <td colspan="3"><?php  echo $add; ?></td>
          </tr>
          <tr>
            <th class="text-second">Parent Name: </th>
            <td><?php  echo $pname; ?></td>
            <th class="text-second">Parent Number: </th>
            <td><?php  echo $pnum; ?></td>
          </tr>
        </table>
      </div>
      <div class="card-footer">
          <?php //echo $msg; ?>
          <a href="register.php" class="btn bg-second btn-block text-white" >Back</a>
          <a download href="<?php echo $qrfile; ?>" class="btn bg-main text-white btn-block">
             Download QR Code
          </a>
      </div>
    </div>
  <h3>
  </h3>

 </div>