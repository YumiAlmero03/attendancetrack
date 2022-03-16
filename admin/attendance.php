<?php 

require_once '../inc/session.php';
require_once '../inc/head.php';
require_once 'head.php';
require_once '../inc/db.php';

date_default_timezone_set('Asia/Manila');

$date_from = isset($_GET['date_from']) ? $_GET['date_from'] : date('Y-m-d');
$date_to =  isset($_GET['date_to']) ? $_GET['date_to'] : date('Y-m-d');
$username = $_SESSION['username'];
if ($_SESSION['level'] === 'class') {
    $fetchuser = mysqli_query($conn, "SELECT course, year, section FROM users join registered on users.reg_id = registered.id where users.username=$username");
    $user = $fetchuser->fetch_assoc();
    $ar = mysqli_query($conn, "SELECT * FROM login join registered on login.reg_id = registered.id WHERE login.type='Student' and login.login between '$date_from 00:00:00' and '$date_to 23:59:59'");
} else {
    $fetchuser = mysqli_query($conn, "SELECT value FROM users join meta on users.id = meta.user_id WHERE meta.key='department' and users.username='$username'");
    $user = $fetchuser->fetch_assoc();
    $department = $user['value'];
    $ar = mysqli_query($conn, "SELECT * FROM login join registered on login.reg_id = registered.id WHERE login.type='Student' and login.login between '$date_from 00:00:00' and '$date_to 23:59:59' and registered.course = '$department'");
}
$rows = $ar->fetch_all();
?>
<div>
  
  <div class="bg-main-light">
    <div class="container-fluid p-5">
        <ul class="nav nav-tabs page-title">
          <li ><a data-toggle="tab" href="#student" class="active">Sections</a></li>
        </ul>
    </div>
    <div class="container-fluid p-5">

        <div class="tab-content">
          <div id="student" class="tab-pane fade in active show">
            <div class="datetimepicker">
                <form class="form-inline " >
                  <div class="form-group mb-2">
                    <label for="staticEmail2" class="sr-only">Date from</label>
                    <input type="date" class="form-control-plaintext" id="staticEmail2" name="date_from" value="<?php echo $date_from; ?>">                
                  </div>
                  <div class="form-group mb-2">
                    <label for="staticEmail2" class="sr-only">Date to</label>
                    <input type="date" class="form-control-plaintext" id="staticEmail2" name="date_to" value="<?php echo $date_to; ?>">
                  </div>
                  <button type="submit" class="btn bg-second text-white mb-2">Search</button>
                </form>
            </div>
            <table class="table">
              <thead>
                <tr class="bg-main text-white">
                  <th scope="col">Student Number</th>
                  <th scope="col">Name</th>
                  <th scope="col">Year</th>
                  <th scope="col">Section</th>
                  <th scope="col">Time In</th>
                  <th scope="col">Time Out</th>
                </tr>
              </thead>
              <tbody>
                <?php
                foreach ($rows as $id => $value) {
                  $studid = $value['3'];
                  $student = mysqli_query($conn, "SELECT * FROM registered WHERE id=$studid");
                  $stud = $student->fetch_assoc();
                ?>
                <tr>
                  <td><?php echo $stud['qrcode']; ?></td>
                  <td><?php echo $value['2']; ?></td>
                  <td><?php echo $stud['year']; ?></td>
                  <td><?php echo $stud['section']; ?></td>
                  <td><?php echo $value['4']; ?></td>
                  <td><?php echo $value['5']; ?></td>
                </tr>

                <?php 
                }
                ?>
              </tbody>
            </table>
          </div>

          

        </div>
        
    </div>
  </div>
</div>
<?php 
require_once '../inc/bottom.php';
?>