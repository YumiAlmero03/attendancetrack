<?php 	
require 'inc/head.php';
require_once 'inc/db.php'; 
require_once 'header.php';
date_default_timezone_set('Asia/Manila');
$name = mysqli_real_escape_string($conn, $_POST['name']);
$purpose = mysqli_real_escape_string($conn, $_POST['purpose']);
$address = mysqli_real_escape_string($conn, $_POST['address']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$passnum = mysqli_real_escape_string($conn, $_POST['passnum']);
$type = mysqli_real_escape_string($conn, $_POST['ptype']);
// $type = 'visitor';
$search_login = "SELECT * FROM visitor join login on login.reg_id=visitor.id where passnum='$passnum' and logout is null";
$logs = mysqli_query($conn,$search_login);
$login = $logs->fetch_all();
$today = date('Y-m-d');
$timestamp =date("Y-m-d H:i:s");
if(empty($login)){

    
    $loggedin = date("g:i:s A F j, Y l");
 ?>
    <body class="bg-main-light">
    <div class="bg-main-light">
        <div class="container">
            <div class="text-center">
                <img src="assets/pup.png" width="100px" class="mt-3">
            </div>
            <div class="row p-5">
                <div class="col-sm-8">
                    <table class="table  table-borderless">
                        <tr>
                            <th colspan='2'><h3 class="text-second">
                                Visitor
                            </h3></th>
                        </tr>
                        <tr>
                            <th colspan='2'><h3>
                                <?php echo $name; ?>
                            </h3></th>
                        </tr>
                        <tr>
                            <th>
                                Photo
                            </th>
                            <td>
                                <div id="results">                                
                                    <div id="my_camera"></div>
                                    <input type=button value="Take Snapshot" onClick="take_snapshot()">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>Purpose:</th>
                            <td><input type="text" readonly value="<?php echo $purpose; ?>" class="form-control"></td>
                        </tr>
                        <tr>
                            <th>Address:</th>
                            <td><textarea class="form-control" readonly><?php echo $address; ?></textarea></td>
                        </tr>
                        <tr>
                            <th>Contact Number:</th>
                            <td><input type="text" readonly value="<?php echo $email; ?>" class="form-control"></td>
                        </tr>
                        <tr>
                            <th>Pass Number:</th>
                            <td><input type="text" readonly value="<?php echo $passnum; ?>" class="form-control"></td>
                        </tr>
                        <tr>
                            <th>Time-in:</th>
                            <td><input type="text" readonly value="<?php echo $loggedin; ?>" class="form-control"></td>
                        </tr>
                        <tr>
                                <form action="visit_log.php" method="post">
                                    <input type="hidden" name="name" value="<?php echo $name; ?>">
                                    <input type="hidden" name="purpose" value="<?php echo $purpose; ?>">
                                    <input type="hidden" name="address" value="<?php echo $address; ?>">
                                    <input type="hidden" name="email" value="<?php echo $email; ?>">
                                    <input type="hidden" name="passnum" value="<?php echo $passnum; ?>">
                                    <input type="hidden" name="type" value="<?php echo $type; ?>">
                                    <input type="hidden" name="time" value="<?php echo $timestamp; ?>">
                                    <input type="hidden" name="image" class="image-tag">                                
                                    <td><button type="submit" class="btn bg-main text-white ">Login</button></td>
                                    <td><a href="index.php" class="btn bg-danger text-white ">Cancel</a></td>                                
                                </form>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php } else { ?>

            
    <h1 class="text-center text-second  p-5">Pass Number is Used</h1>    
    <div class="container">
            <div class="row p-5">
                <div class="col-sm-8">
                    <table class="table  table-borderless">
                        <tr>
                            <th colspan='2'><h3>We cant accept the Passnumber</h3></th>
                        </tr>
                    </table>
                </div>
            </div>
    </div>
<?php } ?>
<?php require 'inc/bottom.php' ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
<script language="JavaScript">
    Webcam.set({
        width: 490,
        height: 390,
        image_format: 'jpeg',
        jpeg_quality: 90
    });
  
    Webcam.attach( '#my_camera' );
  
    function take_snapshot() {
        Webcam.snap( function(data_uri) {
            $(".image-tag").val(data_uri);
            document.getElementById('results').innerHTML = '<img src="'+data_uri+'"/>';
        } );
    }
</script>