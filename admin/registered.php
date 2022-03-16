<?php 

require_once '../inc/session.php';
require_once '../inc/head.php';
require_once 'head.php';
require_once '../inc/db.php';

if (isset($_GET['name'])) {
  $name = $_GET['name'];
  $ar = mysqli_query($conn, "SELECT * FROM registered where lastname like '%$name%'");
} else {
  $ar = mysqli_query($conn, "SELECT * FROM registered limit 50");
}

$rows = $ar->fetch_all();
$count = mysqli_query($conn, "SELECT count(*) as count FROM registered");
$num = $count->fetch_assoc();
?>
<div class="bg-main-light">
    <div class="container-fluid p-5">
        <ul class="nav nav-tabs page-title">
          <li ><a data-toggle="tab" href="#student" class="active">Registered Students </a></li>
        </ul>
        <div class="float-right">
          <h3>Total number of registered: <?php echo $num['count']; ?></h3>
        </div>
    </div>
<div class="container-fluid p-5">
      <div class="search pb-5">
          <div class="float-left">
            <form class="form-inline " >
              <div class="form-group mb-2">
                <input type="text" class="form-control-plaintext" id="staticEmail2" name="name" placeholder="Enter Lastname">   
              </div>
              <button type="submit" class="btn bg-second text-white mb-2">Search</button>
            </form>
          </div>

          <div class="float-right"><a class="btn bg-second text-white mb-2" href="register.php">Register</a></div>
      </div>
    <table class="table">
      <thead>
        <tr class="bg-main text-white">
          <th scope="col">Student Number</th>
          <th scope="col">First Name</th>
          <th scope="col">Last Name</th>
          <th scope="col">Report</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        foreach ($rows as $value) {
        ?>

        <tr>
          <td><?php echo $value['1']; ?></td>
          <td><?php echo $value['2']; ?></td>
          <td><?php echo $value['3']; ?></td>
          <?php 
              $getReport = mysqli_query($conn, "SELECT * FROM `report` where not remove=1 and reg_id=".$value['0']);
              $report = $getReport->fetch_assoc();
           ?>
          <td>
             <?php 
             if ($report) {
               echo $report['report'];
             }
              ?>
          </td>
          <td>
            <?php 
              if ($report) {
              ?>
                <form action="report_remove.php" method="post">
                  <input type="hidden" name="id" value="<?php echo $value['0']; ?>">
                <button type="submit" class="btn text-white  bg-main">Remove report</button>
            <?php if ($_SESSION["level"] === 'admin') { ?>
            <a href="register.php?id=<?php echo $value['0']; ?>" class="btn text-white  bg-third">Edit</a>
            <?php } ?>
                </form>
              <?php
              } else {
             ?>
            <a  class="btn bg-third text-white" data-toggle="modal" data-target="#reportModal<?php echo $value['0']; ?>">Report</a>
            <?php if ($_SESSION["level"] === 'admin') { ?>
            <a href="register.php?id=<?php echo $value['0']; ?>" class="btn bg-third text-white">Edit</a>
            <?php } ?>
            <div class="modal fade" id="reportModal<?php echo $value['0']; ?>" tabindex="-1" aria-labelledby="visitorModalLabel<?php echo $value['0']; ?>" aria-hidden="true">
              <div class="modal-dialog ">
                <div class="modal-content bg-third p-5">
                  <div class=" text-second text-center">
                    <h4 class="modal-title text-center" id="visitorModalLabel<?php echo $value['0']; ?>">Add Report</h4>
                  </div>
                    <form action="report.php" method="post">
                      <div class="modal-body">
                          <div class="form-group">
                            <label for="visitorName">Send report</label>
                            <input type="text" name="report" class="form-control" id="visitorName" >
                            <input type="hidden" name="id" class="form-control" value="<?php echo $value['0']; ?>" >
                          </div>
                      </div>
                      <div class="">
                        <div class="row">
                            <div class="col-sm-6 text-center">
                                <button type="button" class="btn bg-second text-white" data-dismiss="modal">Cancel</button>
                            </div>
                            <div class="col-sm-6 text-center">
                                <button type="submit" class="btn bg-second text-white">Submit</button>
                            </div>
                        </div>
                      </div>
                    </form>
                </div>
              </div>
            </div>
            <?php 
            }
            ?>
          </td>
        </tr>

        <?php 
        }
        ?>

      </tbody>
    </table>
</div>
</div>
<?php 
require_once '../inc/bottom.php';
?>