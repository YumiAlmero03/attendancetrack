<?php 
require_once '../inc/head.php';
require_once '../inc/db.php';

session_start();
$username =  $_SESSION["username"];
 ?>


<body class="bg-main-light">
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
<div class=" school-header bg-white px-4" >
  <div class="col-sm-4">
      <img class="align-left" src="../assets/logo.png" height="100px">
  </div>
  <div class="col-sm-4  ">
    <div class="text-center">
      
    </div>
  </div>
  <div class="col-sm-4  ">
    <div class="text-right">
      
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
<div class="bg-half">
    <div class="container p-5 center-div bg-main form-main">
        <form action="log.php" method="post">
        <h2 class="text-center text-white">OTP</h2>
        <!-- <h3 class="text-center p-2" id="demo"></h3> -->
        <p class="text-center p-2">Check your OTP APP to get your code. </p>

            <div class="form-group">
                <label class="text-white p-2">OTP</label>
                <input type="text" name="code" class="form-control" value="">
            </div>    
            <div class="form-group text-center pt-3">
                <button type="submit" class="btn bg-second text-white " value="Login">Login</button> 
            </div>
        </form>
    </div>    
</div>

<script>
// Set the date we're counting down to
var countDownDate = new Date('<?php echo $countdown; ?>').getTime();

// Update the count down every 1 second
var x = setInterval(function() {

  // Get today's date and time
  var now = new Date().getTime();
    
  // Find the distance between now and the count down date
  var distance = countDownDate - now;
    
  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    
  // Output the result in an element with id="demo"
  document.getElementById("demo").innerHTML =  minutes + ":" + seconds;
    
  // If the count down is over, write some text 
  if (distance < 0) {
    clearInterval(x);
    document.getElementById("demo").innerHTML = "EXPIRED";
    // setTimeout(function(){ window.location.replace('../admin/login.php'); }, 3000);
  }
}, 1000);
</script>
