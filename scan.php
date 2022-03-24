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
            <div class="p-4 text-center">
                
            </div>
            <div class="row p-5 border-third m-3 ">
                <div class="col-sm-4 float-right text-center">
                    <img src="<?php echo $photo; ?>" width='300px'>

                            <td colspan="3">
                                <h2 class="m-0">
                                    <?php echo $name; ?>
                                </h2>
                                    <?php 
                                    if ($type === 'Staff') {
                                        echo $course.' Department'; 
                                    } else {

                                        echo $course.' '.$year.'-'.$section; 
                                    }
                                    ?>
                            </td>
                </div>
                <div class="col-sm-8">
                    <img src="assets/pup.png" width="100px" class="absolute-right">
                    <table class="table table-borderless">
                        <tr>
                            <th>
                                <?php if ($title === 'logout') { ?>
                                <h1 class=" text-second">Good bye!</h1>                

                                <?php } else { ?>
                                <h1 class=" text-second">Welcome!</h1>                
                                <?php } ?>
                                
                            </th>
                            
                        </tr>
                        <?php if ($subject != 'Entry') { ?>
                        <tr>
                            <td>Subject:</td>
                            <td><?php echo $subject; ?></td>
                            <th>&nbsp;</th>
                            <th>&nbsp;</th>
                        </tr>
                        <?php } ?>
                        <tr>
                            <td><b>TIME-IN:</b></td>
                            <td><?php echo $loggedin; ?></td>
                            <th>&nbsp;</th>
                            <th>&nbsp;</th>
                        </tr>
                        <tr>
                            <td><b>TIME-OUT:</b></td>
                            <td><?php echo $loggedout; ?></td>
                            <th>&nbsp;</th>
                            <th>&nbsp;</th>
                        </tr>
                        <tr>
                            <td colspan='2'>
                                <h3 class="text-error m-0">Notice</h3>
                                
                            </td>
                        </tr>
                        <tr>
                            <td colspan='2'>
                                <?php  if(isset($report['report'])){
                                    echo '<p class=" "> '.$report['report'].'</p>';
                                } else {
                                    echo '<p class="">NONE</p>';
                                }
                                ?>
                                
                            </td>
                        </tr>
                        <tr>
                            <form action="stud_log.php" method="post">
                                <input type="hidden" name="code" value="<?php echo $reg_id; ?>">
                                <input type="hidden" name="subject" value="<?php echo $subject; ?>">
                                <input type="hidden" name="name" value="<?php echo $name; ?>">
                                <input type="hidden" name="time" value="<?php echo $timestamp; ?>">
                                <input type="hidden" name="type" value="<?php echo $type; ?>">
                                <?php if ($title === 'logout') { ?>
                                    <input type="hidden" name="type" value="out">
                                    <td><button type="submit" class="btn bg-main text-white ">Accept</button></td>
                                <?php } else { ?>
                                    <input type="hidden" name="type" value="in">
                                    <td><button type="submit" class="btn bg-main text-white ">Accept</button></td>
                                <?php } ?>
                                <td><a href="index.php" class="btn bg-danger text-white ">Decline</a></td>                                
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