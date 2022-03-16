<?php 

require_once '../inc/session.php';
require_once '../inc/head.php';
require_once 'head.php';
require_once '../inc/db.php';


$date_from = date('Y-m-d');
$date_to = date('Y-m-d');
$ar = mysqli_query($conn, "SELECT * FROM login WHERE login between '$date_from 00:00:00' and '$date_to 23:59:59'");
$rows = $ar->fetch_all();
?>
<div class="container py-5">
    <h1 class="text-second"> 
        Logins
    </h1>
</div>
<div class="container">
    <div>
        <form class="form-inline" >
          <div class="form-group mb-2">
            <div class="datetimepicker">
                <label for="staticEmail2" class="sr-only">Date from</label>
                <input type="date" readonly class="form-control-plaintext" id="staticEmail2" name="date_from">                
            </div>
          </div>
          <div class="form-group mb-2">
            <label for="staticEmail2" class="sr-only">Date to</label>
            <input type="date" readonly class="form-control-plaintext" id="staticEmail2" name="date_to">
          </div>
          <button type="submit" class="btn bg-second text-main mb-2">Search</button>
        </form>
    </div>
    <table class="table">
      <thead>
        <tr class="bg-second text-main">
          <th scope="col">ID</th>
          <th scope="col">Name</th>
          <th scope="col">Type</th>
          <th scope="col">Time In</th>
        </tr>
      </thead>
      <tbody>
        <?php
        foreach ($rows as $value) {
        ?>

        <tr>
          <td><?php echo $value['0']; ?></td>
          <td><?php echo $value['2']; ?></td>
          <td><?php echo $value['1']; ?></td>
          <td><?php echo $value['4']; ?></td>
        </tr>

        <?php 
        }
        ?>

      </tbody>
    </table>
</div>

<?php 
require_once '../inc/bottom.php';
?>