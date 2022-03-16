<?php 

require_once '../inc/session.php';
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
?>
<div>
  
  <div class="bg-main-light">
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
            $visitor = mysqli_query($conn, "SELECT MONTH(login.date),COUNT(*) FROM `login` WHERE login.type<>'Student' and login.date between '$date_from' and '$date_to' GROUP BY MONTH(login.date)");
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