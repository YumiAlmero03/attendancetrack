<?php 	
require '../inc/head.php';
require_once '../inc/db.php';
require_once '../inc/qr.php';


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
$studid = mysqli_real_escape_string($conn, $_POST['studid']);

// photoupload
$target_dir = "../uploads/profile/";
$target_file = $target_dir . basename($_FILES["photo"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// // Check if image file is a actual image or fake image
// if(isset($_POST["submit"])) {
//   $check = getimagesize($_FILES["photo"]["tmp_name"]);
//   if($check !== false) {
//     $msg =  "File is an image - " . $check["mime"] . ".";
//     $uploadOk = 1;
//   } else {
//     $msg =  "File is not an image.";
//     $uploadOk = 0;
//   }
// }

// // Check if file already exists
// if (file_exists($target_file)) {
//   $msg =  "Sorry, file already exists.";
//   $uploadOk = 0;
// }

// // Check file size
// if ($_FILES["photo"]["size"] > 500000) {
//   $msg =  "Sorry, your file is too large.";
//   $uploadOk = 0;
// }

// // Allow certain file formats
// if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
// && $imageFileType != "gif" ) {
//   $msg =  "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
//   $uploadOk = 0;
// }

// // Check if $uploadOk is set to 0 by an error
// if ($uploadOk == 0) {
//   // $msg =  "Sorry, your file was not uploaded.";
// // if everything is ok, try to upload file
// } else {
//   if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
//     $msg =  "The file ". htmlspecialchars( basename( $_FILES["photo"]["name"])). " has been uploaded.";
//   } else {
//     $msg = "Sorry, there was an error uploading your file.";
//   }
// }
// upload end
  $filename = uploadS3($_FILES["photo"]["name"],$_FILES["photo"]["tmp_name"]);


$insert_code = "INSERT INTO `registered`(`qrcode`, `firstname`, `lastname`, `type`, `course`, `year`, `section`, `bday`, `email`, `address`, `pname`, `pcontact`, `photo`, `qrphoto`) 
VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

$stmt = mysqli_stmt_init($conn);

if(!mysqli_stmt_prepare($stmt, $insert_code)){
    $msg = "Registration Failed!";
}
else{
	$qrfile = upload_qr($studid);
    mysqli_stmt_bind_param($stmt, "ssssssssssssss", $studid, $fn, $ln, $type, $course, $yr, $sec, $bday, $email, $add, $pname, $pnum, $filename, $qrfile);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

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
          <a href="register.php" class="btn bg-second text-main btn-block" >Back</a>
          <a download="<?php echo $qrfile; ?>" href="<?php echo $qrfile; ?>" class="btn bg-main text-second btn-block">
             Download QR Code
          </a>
      </div>
    </div>
 	<h3>
 	</h3>

 </div>