
<div class=" school-header bg-white " >
  <div class="mx-4 row container-fluid">
  <div class="col-sm-2">
      <img class="align-left" src="../assets/logo.png" height="100px">
  </div>
  <div class="col-sm-8  ">
    <nav class="navbar navbar-expand-lg  text-second">
      <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
        <!-- left nav -->
        <ul class="navbar-nav ">
          <?php if ($_SESSION["level"] === 'admin') { ?>
          <li class="nav-item">
            <a class="nav-link <?= ($activePage == 'index') || ($activePage == '') ? 'active':''; ?>" href="index.php">Dashboard</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= ($activePage == 'logs') || ($activePage == 'log') ? 'active':''; ?>" href="logs.php">Logs <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item ">
            <a class="nav-link <?= ($activePage == 'registered') || ($activePage == 'register') ? 'active':''; ?>" href="registered.php">Students</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= ($activePage == 'personel') || ($activePage == 'addpersonel') ? 'active':''; ?>" href="personel.php">Personnel </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= ($activePage == 'visitors')  ? 'active':''; ?>" href="visitors.php">Visitor</a>
          </li>
          <?php } else { ?>
            <li class="nav-item">
              <a class="nav-link <?= ($activePage == 'attendance') || ($activePage == 'attendance') ? 'active':''; ?>" href="attendance.php">Attendance </a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?= ($activePage == 'scan') || ($activePage == 'scan') ? 'active':''; ?>" href="scan.php">Scan QR </a>
            </li>
          <?php } ?>
          <!-- <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Dropdown
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="#">Action</a>
              <a class="dropdown-item" href="#">Another action</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="#">Something else here</a>
            </div>
          </li> -->
        </ul>
        
      </div>
    </nav>
  </div>
  <div class="col-sm-2  ">
    <nav class=" text-second">
    <!-- right nav -->
        <ul class="navbar-nav my-2 my-lg-0">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Welcome! <?php  echo $_SESSION["username"] ?>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="users.php">Edit</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="logout.php">Logout</a>
            </div>
          </li>
        </ul>
      </nav>
  </div>
  </div>
</div>

<nav class="navbar navbar-expand-lg navbar-dark bg-second text-second">
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <!-- left nav -->
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="index.php">  <span class="sr-only">(current)</span></a>
        </li>
      </ul>
    </div>
</nav>

<?php 
if (isset($_SESSION["error"])) {
  ?>
<div class="alert alert-danger" role="alert">
  <?php echo $_SESSION["error"]; ?>
</div>
<?php 
$_SESSION["error"] = null;
}
 ?>
<?php 
if (isset($_SESSION["info"])) {
  ?>
<div class="alert alert-success" role="alert">
  <?php echo $_SESSION["info"]; ?>
</div>
<?php 
$_SESSION["info"] = null;
}
 ?>