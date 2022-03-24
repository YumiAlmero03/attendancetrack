<?php 

require_once '../inc/session.php';
require_once '../inc/head.php';
require_once 'head.php';
require_once '../inc/db.php';

if (isset($_GET['name'])) {
  $name = $_GET['name'];
  $ar = mysqli_query($conn, "SELECT * FROM registered where name like '%$name%'  WHERE type='staff'");
} else {
  $ar = mysqli_query($conn, "SELECT * FROM registered WHERE type='staff' limit 50 ");
}
$photo = '../assets/pup.png';

$rows = $ar->fetch_all();
$count = mysqli_query($conn, "SELECT count(*) as count FROM registered WHERE type='staff'");
$num = $count->fetch_assoc();
?>
<div class="bg-main-light">
    <div class="container-fluid p-5">
        <ul class="nav nav-tabs page-title">
          <li ><a data-toggle="tab" href="#student" class="active">Registered Personnel</a></li>
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
            <a class="btn bg-second text-white mb-2" href="addpersonel.php">Register</a>
          </div>
      </div>
    <table class="table">
      <thead>
        <tr class="bg-main text-white">
          <th scope="col">ID Number</th>
          <th scope="col">Office</th>
          <th scope="col">First Name</th>
          <th scope="col">Last Name</th>
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
            <a  class="btn bg-third text-white" data-toggle="modal" data-target="#reportModal<?php echo $value['0']; ?>">Report</a>
            <?php if ($_SESSION["level"] === 'admin') { ?>
            <a href="register.php?id=<?php echo $value['0']; ?>" class="btn bg-third text-white">Edit</a>
            <a href="regremove.php?id=<?php echo $value['0']; ?>" class="btn bg-third text-white">Delete</a>
            <?php } ?>
            
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