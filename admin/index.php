<?php 
require_once '../inc/session.php';
if (!($_SESSION["level"] === 'admin' || $_SESSION["level"] === 'staff')) { 
   header("location: attendance.php");
}
require_once '../inc/head.php';
require_once 'head.php';
require_once '../inc/db.php';

date_default_timezone_set('Asia/Manila');

$date_from = isset($_GET['date_from']) ? $_GET['date_from'] : date('Y-m-d');
$date_to =  isset($_GET['date_to']) ? $_GET['date_to'] : date('Y-m-d');

$ar = mysqli_query($conn, "SELECT * FROM login WHERE type='Student' and login between '$date_from 00:00:00' and '$date_to 23:59:59'");
$rows = $ar->fetch_all();
$visitor = mysqli_query($conn, "SELECT * FROM login WHERE type<>'Student' and login between '$date_from 00:00:00' and '$date_to 23:59:59'");
$visitors = $visitor->fetch_all();

// counts

$getStud = mysqli_query($conn, "SELECT COUNT(id) as count FROM registered WHERE type='Student'");
$studentCount = $getStud->fetch_assoc();

$getVisitors = mysqli_query($conn, "SELECT COUNT(id) as count FROM visitor ");
$visitorsCount = $getVisitors->fetch_assoc();
$getParent = mysqli_query($conn, "SELECT COUNT(id) as count FROM visitor WHERE type='Parent'");
$parentCount = $getParent->fetch_assoc();
$getAlumni = mysqli_query($conn, "SELECT COUNT(id) as count FROM visitor WHERE type='Alumni'");
$alumniCount = $getAlumni->fetch_assoc();
$getVisit = mysqli_query($conn, "SELECT COUNT(id) as count FROM visitor WHERE type='Visitor'");
$visitCount = $getVisit->fetch_assoc();
$getAccounts = mysqli_query($conn, "SELECT COUNT(id) as count FROM users ");
$accountsCount = $getAccounts->fetch_assoc();
$getPersonel = mysqli_query($conn, "SELECT COUNT(id) as count FROM users where level<>'class' and level<>'faculty'");
$personelCount = $getPersonel->fetch_assoc();
?>
<div>
  
  <div class="bg-main-light">
    <div class="container-fluid p-5">
        <div class="row py-2">
            <div class="col-md-4 px-2">
                <div class="row bg-white px-2 py-4 set-middle">
                    <div class="col-lg-6 ">
                       <h4 class="text-second set-middle">Registered Students</h4> 
                    </div>
                    <div class="col-lg-6 text-right">
                       <h1 class="text-main set-middle"><?php echo $studentCount['count']; ?></h1> 
                    </div>
                </div>
            </div>
            <div class="col-md-8 px-2">
                <div class="row bg-white px-2 py-4 set-middle">
                    <div class="col-lg-3 ">
                       <h4 class="text-second set-middle">Visitor Logs</h4> 
                    </div>
                    <div class="col-lg-3 text-center">
                       <h1 class="text-main set-middle"><?php echo $visitorsCount['count']; ?></h1> 
                    </div>
                    <div class="col-lg-2 text-center">
                       <h2 class="text-main set-middle"><?php echo $parentCount['count']; ?></h2> 
                       <h5 class="text-second set-second">Parent</h5> 
                    </div>
                    <div class="col-lg-2 text-center">
                       <h2 class="text-main set-middle"><?php echo $alumniCount['count']; ?></h2> 
                       <h5 class="text-second set-second">Alumni</h5> 
                    </div>
                    <div class="col-lg-2 text-center">
                       <h2 class="text-main set-middle"><?php echo $visitCount['count']; ?></h2> 
                       <h5 class="text-second set-second">Visitor</h5> 
                    </div>
                </div>
            </div>
        </div>
        <div class="row py-2">
            <div class="col-md-3 px-2">
                <div class="row bg-white px-2 py-4 set-middle">
                    <div class="col-lg-6 ">
                       <h4 class="text-second set-middle">Accounts</h4> 
                    </div>
                    <div class="col-lg-6 text-right">
                       <h1 class="text-main set-middle"><?php echo $accountsCount['count']; ?></h1> 
                    </div>
                </div>
            </div>
            <div class="col-md-6 px-2">
                <div class="row bg-white px-2 py-4 set-middle">
                    <div class="col-md-6 ">
                       <h4 class="text-second set-middle">Registered Personnel</h4> 
                    </div>
                    <div class="col-md-6 text-center">
                       <h1 class="text-main set-middle"><?php echo $personelCount['count']; ?></h1> 
                    </div>
                </div>
            </div>
            <div class="col-md-3 px-2">
                <div class="row bg-white px-2 py-4 set-middle">
                    <div class="col-md-12 text-justify">
                       <h1 class="text-main set-middle"><?php echo date('F j, Y'); ?></h1> 
                    </div>
                    <div class="col-lg-4 text-left">
                       <h3 class="text-second set-middle"><?php echo date('l'); ?></h3> 
                    </div>
                    <div class="col-lg-8 text-right">
                       <h3 class="text-second set-middle" id="MyClockDisplay" class="clock" onload="showTime()"></h3> 
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid p-5">
        <ul class="nav nav-tabs page-title">
          <li ><a data-toggle="tab" href="#morning" class="active">Morning</a></li>
          <li ><a data-toggle="tab" href="#afternoon" >Afternoon</a></li>
          <li ><a data-toggle="tab" href="#month" >Visitors by month</a></li>
        </ul>
    </div>
    <div class="container-fluid px-5">
            <div class="datetimepicker">
                <form class="form-inline " >
                  <div class="form-group mb-2">
                    <label for="staticEmail2" class="sr-only">Date from</label>
                    <input type="date" class="form-control-plaintext" id="staticEmail2" name="date_from" value="<?php echo $date_from; ?>">                
                  </div>
                  <div class="form-group mb-2">
                    <label for="staticEmail2" class="sr-only">Date from</label>
                    <input type="date" class="form-control-plaintext" id="staticEmail2" name="date_to" value="<?php echo $date_from; ?>">                
                  </div>
                  <button type="submit" class="btn bg-second text-white mb-2">Search</button>
                </form>
            </div>
        <div class="tab-content">
          <div id="morning" class="tab-pane fade in active show">
            <canvas id="chartMorning" width="400" height="100"></canvas>
          </div>
          <div id="afternoon" class="tab-pane fade in ">
            <canvas id="chartAfternoon" width="400" height="100"></canvas>
          </div>
          <div id="month" class="tab-pane fade in">
            <canvas id="chartMonth" width="400" height="100"></canvas>
          </div>
        </div>
    </div>
  </div>
</div>
<?php 
require_once '../inc/bottom.php';
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js" integrity="sha512-QSkVNOCYLtj73J4hbmVoOV6KVZuMluZlioC+trLpewV8qMjsWqlIQvkn1KGX2StWvPMdWGBqim1xlC8krl1EKQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
const ctxAm = document.getElementById('chartMorning');
const chartMorning = new Chart(ctxAm, {
    type: 'bar',
    data: {
        labels: [
          <?php 
            $class = mysqli_query($conn, "SELECT registered.course,COUNT(*) FROM `login` JOIN registered on login.reg_id = registered.id WHERE login.type='Student' and login.login between '$date_from 00:00:00' and '$date_from 11:59:59' GROUP BY registered.course");
            $lbl1 = $class->fetch_all();
            foreach ($lbl1 as $value) {
              echo( "'".$value[0]."'");
            }
           ?>
        ],
        datasets: [{
            label: '# of Students',
            data: [
              <?php 
                foreach ($lbl1 as $value) {
                  echo( "'".$value[1]."'");
                }
               ?>
            ],
            backgroundColor: [
                'rgba(75, 192, 192, 0.2)'
            ],
            borderColor: [
                'rgba(75, 192, 192, 0.2)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// 
const ctxPm = document.getElementById('chartAfternoon');
const chartAfternoon = new Chart(ctxPm, {
    type: 'bar',
    data: {
        labels: [
          <?php 
            $class = mysqli_query($conn, "SELECT registered.course,COUNT(*) FROM `login` JOIN registered on login.reg_id = registered.id WHERE login.type='Student' and login.login between '$date_from 12:00:00' and '$date_from 23:59:59' GROUP BY registered.course");
            $lbl2 = $class->fetch_all();
            foreach ($lbl2 as $value) {
              echo( "'".$value[0]."'");
            }
           ?>
        ],
        datasets: [{
            label: '# of Students',
            data: [
                    <?php 
                      foreach ($lbl2 as $value) {
                        echo( "'".$value[1]."'");
                      }
                    ?>
                  ],
            backgroundColor: [
                'rgba(75, 192, 192, 0.2)'
            ],
            borderColor: [
                'rgba(75, 192, 192, 0.2)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// 
const ctxMnt = document.getElementById('chartMonth');
const chartMonth = new Chart(ctxMnt, {
    type: 'bar',
    data: {
        labels: [
          <?php 
            $month = [  'January',
                        'February',
                        'March',
                        'April',
                        'May',
                        'June',
                        'July ',
                        'August',
                        'September',
                        'October',
                        'November',
                        'December'];
                        $year = date('Y');
            $visitor = mysqli_query($conn, "SELECT MONTH(login.date),COUNT(*) FROM `login` WHERE login.type<>'Student' and YEAR(login.date) = '$year' GROUP BY MONTH(login.date)");
            $lbl3 = $visitor->fetch_all();
            foreach ($lbl3 as $value) {
                $mon = $value[0] - 1;
              echo( "'".$month[$mon]."'");
            }
           ?>
        ],
        datasets: [{
            label: '# of Visitors',
            data: [
              <?php 
                      foreach ($lbl3 as $value) {
                        echo( "'".$value[1]."'");
                      }
                    ?>
            ],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>