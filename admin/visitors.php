<?php 

require_once '../inc/session.php';
require_once '../inc/head.php';
require_once 'head.php';
require_once '../inc/db.php';

date_default_timezone_set('Asia/Manila');

if (isset($_GET['name'])) {
  $name = $_GET['name'];
  $visitor = mysqli_query($conn, "SELECT * FROM visitor where name like '%$name%'");
} else {
  $visitor = mysqli_query($conn, "SELECT * FROM visitor limit 50");
}

$visitors = $visitor->fetch_all();
?>
<div>
  
  <div class="bg-main-light">
    <div class="container-fluid p-5">
        <ul class="nav nav-tabs page-title">
          <li><a data-toggle="tab" href="#visitor" class="active">Visitor Logs</a></li>
        </ul>
    </div>
    <div class="container-fluid p-5">

        <div class="tab-content">
          <div id="visitor" class="tab-pane fade active show">
            <div class="search pb-5">
              <div class="float-left">
                <form class="form-inline " >
                  <div class="form-group mb-2">
                    <input type="text" class="form-control-plaintext" id="staticEmail2" name="name" placeholder="Enter Name">   
                  </div>
                  <button type="submit" class="btn bg-second text-white mb-2">Search</button>
                </form>
              </div>
          </div>
            <table class="table">
              <thead>
                <tr class="bg-main text-white">
                  <th scope="col">ID</th>
                  <th scope="col">Full name</th>
                  <th scope="col">Type</th>
                  <th scope="col">Purpose</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                foreach ($visitors as $value) {

                  $visitid = $value['0'];
                  $visit = mysqli_query($conn, "SELECT * FROM login WHERE reg_id=$visitid and type<>'Student'");
                  $data = $visit->fetch_assoc();
                ?>
                <tr>
                  <td><?php echo $value['0']; ?></td>
                  <td><?php echo $value['1']; ?></td>
                  <td><?php echo $value['7']; ?></td>
                  <td><?php echo $value['2']; ?></td>
                  <td>
                    <a  class="btn bg-third text-white" data-toggle="modal" data-target="#reportModal<?php echo $value['0']; ?>">View</a>
                    <div class="modal fade" id="reportModal<?php echo $value['0']; ?>" tabindex="-1" aria-labelledby="visitorModalLabel<?php echo $value['0']; ?>" aria-hidden="true">
                      <div class="modal-dialog ">
                        <div class="modal-content bg-third p-5">
                          <div class="modal-header text-second text-center">
                            <h4 class="modal-title text-center" id="visitorModalLabel<?php echo $value['0']; ?>">Visitor Log</h4>
                          </div>
                              <div class="modal-body">
                                <div class="form-row">
                                  <div class="form-group col-md-6">
                                    <label for="visitorName">Full Name</label>
                                    <input readonly type="text" class="form-control" id="visitorName" value="<?php echo $value['1']; ?>" >
                                  </div>
                                  <div class="form-group col-md-6">
                                    <label for="visitorName">Purpose</label>
                                    <input readonly type="text" class="form-control" id="visitorName" value="<?php echo $value['2']; ?>" >
                                  </div>
                                </div>
                                <div class="form-row">
                                  <div class="form-group col-md-12">
                                    <label for="visitorName">Address</label>
                                    <input readonly type="text" class="form-control" id="visitorName" value="<?php echo $value['3']; ?>" >
                                  </div>
                                </div>
                                <div class="form-row">
                                  <div class="form-group col-md-6">
                                    <label for="visitorName">Contact Number</label>
                                    <input readonly type="text" class="form-control" id="visitorName" value="<?php echo $value['4']; ?>" >
                                        <button type="button" class="btn bg-second text-white mt-5" data-dismiss="modal">Back</button>
                                  </div>
                                  <div class="form-group col-md-6">
                                    <img src="/<?php echo $value['6']; ?>" width="100%">
                                  </div>
                                </div>
                              </div>
                              <div class="">
                                <div class="row">
                                    <div class="col-sm-12 text-center">
                                    </div>
                                </div>
                              </div>
                        </div>
                      </div>
                    </div>
                  </td>
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