<?php 

require_once '../inc/session.php';
require_once '../inc/head.php';
require_once 'head.php';
require_once '../inc/db.php';

if (isset($_GET['name'])) {
  $name = $_GET['name'];
  $ar = mysqli_query($conn, "SELECT * FROM registered where lastname like '%$name%'  WHERE type='Student'");
} else {
  $ar = mysqli_query($conn, "SELECT * FROM registered WHERE type='Student' limit 50 ");
}
$photo = '../assets/pup.png';

$rows = $ar->fetch_all();
$count = mysqli_query($conn, "SELECT count(*) as count FROM registered WHERE type='Student'");
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

          <div class="float-right">
            <a class="btn bg-second text-white mb-2" href="register.php">Register</a>
            <a  class="btn bg-second text-white mb-2" data-toggle="modal" data-target="#reportModalClass">Create Class Representative</a>
          </div>
      </div>
    <table class="table">
      <thead>
        <tr class="bg-main text-white">
          <th scope="col">Student Number</th>
          <th scope="col">Course</th>
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
          <td><?php echo $value['5']; ?></td>
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
            <a href="regremove.php?id=<?php echo $value['0']; ?>" class="btn bg-third text-white">Delete</a>
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
    <div class="modal fade" id="reportModalClass" tabindex="-1" aria-labelledby="visitorModalLabelAdd" aria-hidden="true">
      <div class="modal-dialog ">
        <div class="modal-content bg-third p-5">
          <div class="modal-header text-second text-center">
            <h3 class="modal-title text-center " id="visitorModalLabelAdd">Create User</h3>
          </div>
          <div class="modal-body">
            <h3 class="modal-title pb-3" id="visitorModalLabelAdd">Access Level: Class Representative</h3>
            <form action="userclass.php" method="post" enctype="multipart/form-data">
              <div class="form-row">
                <div class="float-left text-center">
                    <img id="previewClass" src="<?php echo $photo ?>" alt="your image" width="190px"/>
                    <label class="btn bg-second text-white pt-2 btn-block m-0" for="photo">Choose File</label>
                    <?php 
                      if (isset($_GET['id'])) {
                      ?>
                    <input  type='file' onchange="readURLClass(this);" id="photo" name="photo" accept="image/*" />
                      <?php
                      } else {
                      ?> 
                    <input  type='file' onchange="readURLClass(this);" id="photo" name="photo" accept="image/*" required />
                    <?php
                      }
                    ?>
                </div>
                <div class="form-group col-md-9">
                  <label for="username">Username</label>
                  <input name="username" type="text" class="form-control" id="username" required>
                </div>
                <div class="form-group col-md-9">
                  <label for="username">Class Representative (name)</label>
                </div>
                <div class="form-group col-md-4">
                  <label for="name">First Name</label>
                  <input name="fn" type="text" class="form-control" id="fn" required>
                </div>
                <div class="form-group col-md-5">
                  <label for="name">Last Name</label>
                  <input name="ln" type="text" class="form-control" id="ln" required>
                </div>
                <div class="form-group col-md-9">
                  <label for="email">Email</label>
                  <input name="email" class="form-control" id="email" value="studentmngmt@gmail.com" required>
                </div>
                <div class="form-group col-md-9">
                  <label for="email">Course</label>
                  <select name="meta[course]" class="form-control" id="inCourse" required value="">
                        <option disabled >Select Course</option>
                        <option value="BSA" >BS Accountancy</option>
                        <option value="BSBAFM" >BSBA Financial Management</option>
                        <option value="BSEDUC" >BS English</option>
                        <option value="BSENTREP" >BS Entrepreneurship</option>
                        <option value="BSHM" >BS Hospitality Management</option>
                        <option value="BSIT" >BS Information Technology</option>
                        <option value="BSPSYCH" >BS Psychology</option>
                  </select>
                </div>
                <div class="form-group col-md-9">
                  <label for="email">Year</label>
                  <input name="meta[yr]" type="text" class="form-control" id="num" required>
                </div>
                <div class="form-group col-md-9">
                  <label for="email">Section</label>
                  <input name="meta[sec]" type="text" class="form-control" id="num" required>
                </div>
                <div class="form-group col-md-9">
                  <label for="email">Student Number</label>
                  <input name="meta[stud_num]" type="text" class="form-control" id="num" required>
                </div>
                <div class="form-group col-md-9">
                  <label for="email">Birthday</label>
                  <input name="meta[bday]" type="date" class="form-control" id="num" required>
                </div>
                <div class="form-group col-md-9">
                  <label for="email">Address</label>
                  <input name="meta[address]" type="text" class="form-control" id="num" required>
                </div>
                <div class="form-group col-md-9">
                  <label for="email">Contact person in case of Emergency</label>
                  <input name="meta[emergency]" type="text" class="form-control" id="num" required>
                </div>
                <div class="form-group col-md-9">
                  <label for="email">Contact Number</label>
                  <input name="meta[emergency_num]" type="text" class="form-control" id="num" required>
                </div>

              </div> 
              <div class="form-row">
                <div class="form-group col-md-9">
                  <label for="pass">Password</label>
                  <input type="hidden" name="level" value="class">
                  <input name="pass" type="password" class="form-control" id="pass" required>
                </div>
              </div>
              <button type="submit" class="btn bg-second text-white">Create</button>
            </form>
            
          </div>
        </div>
      </div>
    </div>
</div>
</div>
<?php 
require_once '../inc/bottom.php';
?>
<script type="text/javascript">
    function readURLClass(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#previewClass')
                    .attr('src', e.target.result)
                    .width(150)
                    .height(200);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

</script>