<?php 
require 'inc/head.php';

require_once 'inc/db.php';

date_default_timezone_set('Asia/Manila');
 require_once 'header.php';
$qrcode = mysqli_real_escape_string($conn, $_GET['code']);
$subject = mysqli_real_escape_string($conn, $_GET['subj']);

$ar = mysqli_query($conn, "SELECT * FROM registered WHERE qrcode = '$qrcode'");
    $userData = $ar->fetch_assoc();
if ($userData) {
    

    $reg_id = $userData['id'];
    $firstname = $userData['firstname'];
    $lastname = $userData['lastname'];
    $photo = $userData['photo'];
    $type = $userData['type'];
    $course = $userData['course'];
    $year = $userData['year'];
    $section = $userData['section'];
    $reg_id = $userData['id'];
    $name = $firstname." ".$lastname;
    $today = date('Y-m-d');
    $log = mysqli_query($conn, "SELECT * FROM login WHERE reg_id = '$reg_id' and login between '$today 00:00:00' and '$today 23:59:59' and logout is null");
    $login = $log->fetch_assoc();
    $timestamp =date("Y-m-d H:i:s");
    $timestampFormated =date("g:i:s A F j, Y l");
    if ($login) {
        $loggedin = date("g:i:s A F j, Y l", strtotime($login['login'])) ;
        $loggedout = $timestampFormated;
        $title = 'logout';
    } else {
            $title = 'login';
            $loggedin = $timestampFormated;
            $loggedout = '';
    }
    $getReport = mysqli_query($conn, "SELECT * FROM `report` where not remove=1 and reg_id=".$reg_id);
    $report = $getReport->fetch_assoc();
 ?>
<body class="bg-main-light">
<div class="bg-main-light">
    <div class="container pb-5">
            <div class="text-center">
                <img src="assets/pup.png" width="100px" class="mt-3">
            </div>
            <div class="row p-5 border-third m-3 ">
                <div class="col-sm-4 float-right">
                    <img src="uploads/profile/<?php echo $photo; ?>" width='300px'>
                </div>
                <div class="col-sm-8">
                    <table class="table table-borderless">
                        <tr>
                            <th>
                                <?php if ($title === 'logout') { ?>
                                <h2 class="">Good bye</h2>                

                                <?php } else { ?>
                                <h2 class="">Welcome</h2>                
                                <?php } ?>
                                
                            </th>
                            <td colspan="3">
                                <h3 class="m-0">
                                    <?php echo $name; ?>
                                </h3>
                                    <?php echo $course.' '.$year.'-'.$section; ?>
                            </td>
                            
                        </tr>
                        <tr>
                            <td colspan='2'>
                                <?php  if(isset($report['report'])){
                                    echo '<i class="text-error h3"><b>REPORT: '.$report['report'].'</b></i>';
                                } else {
                                    echo '<i class="">REPORT: NONE</i>';
                                }
                                ?>
                                
                            </td>
                        </tr>
                        <tr>
                            <td>Subject:</td>
                            <td><?php echo $subject; ?></td>
                            <th>&nbsp;</th>
                            <th>&nbsp;</th>
                        </tr>
                        <tr>
                            <td>TIME-IN:</td>
                            <td><?php echo $loggedin; ?></td>
                            <th>&nbsp;</th>
                            <th>&nbsp;</th>
                        </tr>
                        <tr>
                            <td>TIME-OUT:</td>
                            <td><?php echo $loggedout; ?></td>
                            <th>&nbsp;</th>
                            <th>&nbsp;</th>
                        </tr>
                        <tr>
                            <form action="stud_log.php" method="post">
                                <input type="hidden" name="code" value="<?php echo $reg_id; ?>">
                                <input type="hidden" name="subject" value="<?php echo $subject; ?>">
                                <input type="hidden" name="name" value="<?php echo $name; ?>">
                                <input type="hidden" name="time" value="<?php echo $timestamp; ?>">
                                <?php if ($title === 'logout') { ?>
                                    <input type="hidden" name="type" value="out">
                                    <td><button type="submit" class="btn bg-main text-white ">Logout</button></td>
                                <?php } else { ?>
                                    <input type="hidden" name="type" value="in">
                                    <td><button type="submit" class="btn bg-main text-white ">Login</button></td>
                                <?php } ?>
                                <td><a href="index.php" class="btn bg-danger text-white ">Cancel</a></td>                                
                            </form>
                        </tr>
                    </table>
                </div>
            </div>
    </div>    
</div>
<?php } else { ?>

                <h1 class="text-center text-second  p-5">QR Invalid</h1>    
<div class="container">
        <div class="row p-5">
            <div class="col-sm-8">
                <table class="table  table-borderless">
                    <tr>
                        <th colspan='2'><h3>We cant accept the QR Code</h3></th>
                    </tr>
                </table>
            </div>
        </div>
</div>
<?php } ?>

<?php require 'inc/bottom.php' ?>
<script type="text/javascript">
	// setTimeout(function(){ window.close(); }, 5000);
</script>