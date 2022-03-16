<?php 	
require 'inc/head.php';
require_once 'inc/db.php'; 
require_once 'header.php';
date_default_timezone_set('Asia/Manila');
$passnum = mysqli_real_escape_string($conn, $_POST['passnum']);
$type = 'visitor';

$search_visit = "SELECT * FROM visitor where passnum='$passnum'";
$visit = mysqli_query($conn,$search_visit);
$visitor = $visit->fetch_assoc();

if (isset($visitor['id'])) {
    $id = $visitor['id'];
    // code...
    $search_login = "SELECT * FROM login where reg_id='$id' and logout is null";
    $logs = mysqli_query($conn,$search_login);
    $login = $logs->fetch_assoc();
    if ($login) {

        $loginID = $login['id'];
        $loggedin = date("g:i:s A F j, Y l", strtotime($login['login']));
        $loggedout = date("g:i:s A F j, Y l");
         ?>
        <body class="bg-main-light">

        <div class="bg-main-light">
            <div class="container">
                <div class="text-center">
                    <img src="assets/pup.png" width="100px" class="mt-3">
                </div>
                <div class="row p-5">
                    <div class="col-sm-8">
                        <table class="table  table-borderless" width="100%" class="form-main">
                            <tr>
                                <th colspan='2'><h3 class="text-second">
                                    Exit Visitor Log
                                </h3></th>
                            </tr>
                            <tr>
                                <th colspan='2'><h3>
                                    <?php echo $visitor['name']; ?>
                                </h3></th>
                            </tr>
                            <tr>
                                <th>Purpose:</th>
                                <td><input type="text" readonly value="<?php echo $visitor['purpose']; ?>" class="form-control"></td>
                            </tr>
                            <tr>
                                <th>Address:</th>
                                <td><textarea class="form-control" readonly><?php echo $visitor['address']; ?></textarea></td>
                            </tr>
                            <tr>
                                <th>Contact Number:</th>
                                <td><input type="text" readonly value="<?php echo $visitor['email']; ?>" class="form-control"></td>
                            </tr>
                            <tr>
                                <th>Pass Number:</th>
                                <td><input type="text" readonly value="<?php echo $visitor['passnum']; ?>" class="form-control"></td>
                            </tr>
                            <tr>
                                <th>Time-in:</th>
                                <td><input type="text" readonly value="<?php echo $loggedin; ?>" class="form-control"></td>
                            </tr>
                            <tr>
                                <th>Time-out:</th>
                                <td><input type="text" readonly value="<?php echo $loggedout; ?>" class="form-control"></td>
                            </tr>
                            <tr>
                                <th colspan="2">
                                    <form action="logout.php" method="post">

                                        <input type="hidden" name="id" value="<?php echo $login['id']; ?>" >
                                        <input type="hidden" name="time" value="<?php echo date('Y-m-d H:i:s'); ?>" >
                                        <button type="submit" class="btn bg-second text-white">Exit</button>
                                    </form>
                                </th>
                            </tr>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    <?php } else { ?>
        <h1 class="text-center text-second  p-5">Can't find Visitor</h1>    
        <div class="container">
                <div class="row p-5">
                    <div class="col-sm-8">
                        <table class="table  table-borderless">
                            <tr>
                                <th colspan='2'><h3>Maybe the Passnumber is not being used for now</h3></th>
                            </tr>
                        </table>
                    </div>
                </div>
        </div>
    <script type="text/javascript">
      setTimeout(function(){ window.close(); }, 5000);
    </script>
<?php } 
} else { ?>
<h1 class="text-center text-second  p-5">Can't find Visitor</h1>    
    <div class="container">
            <div class="row p-5">
                <div class="col-sm-8">
                    <table class="table  table-borderless">
                        <tr>
                            <th colspan='2'><h3>Maybe the Passnumber is not being used for now</h3></th>
                        </tr>
                    </table>
                </div>
            </div>
    </div>
<script type="text/javascript">
  setTimeout(function(){ window.close(); }, 5000);
</script>
<?php } ?>
<?php require 'inc/bottom.php' ?>