
<div class=" school-header bg-white p-4" >
  <div class="col-sm-4">
      <img class="align-left" src="assets/logo.png" height="100px">
  </div>
  <div class="col-sm-4  ">
    <div class="text-center">
      <h3>Attendance Monitoring System</h3>
    </div>
  </div>
  <div class="col-sm-4  ">
    <div class="text-right">
      <h3 class="text-second"> <?php echo date('F j, Y, l'); ?> </h3>
      <h3><div id="MyClockDisplay" class="clock" onload="showTime()"></div></h3>
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