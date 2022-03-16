<?php 

require_once '../inc/session.php';
require_once '../inc/head.php';
require_once 'head.php';
require_once '../inc/db.php';


$date_from = date('Y-m-d');
$date_to = date('Y-m-d');
$ar = mysqli_query($conn, "SELECT * FROM users");
$rows = $ar->fetch_all();
?>
<div class="container py-5">
    <h1 class="text-second">
        Users
    </h1>
</div>
<div class="container">
    <table class="table">
      <thead>
        <tr class="bg-second text-main">
          <th scope="col">ID</th>
          <th scope="col">Username</th>
          <th scope="col">First Name</th>
          <th scope="col">Last Name</th>
        </tr>
      </thead>
      <tbody>
        <?php
        foreach ($rows as $value) {
        ?>

        <tr>
          <td><?php echo $value['0']; ?></td>
          <td><?php echo $value['1']; ?></td>
          <?php 
            $id =$value['3'];
            $getUser = mysqli_query($conn, "SELECT * FROM registered where id=$id");
            $user = $getUser->fetch_assoc();
          ?>
          <td><?php echo $user['firstname']; ?></td>
          <td><?php echo $user['lastname']; ?></td>
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