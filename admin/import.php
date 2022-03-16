<?php 
require_once '../inc/head.php';
require_once '../inc/db.php';

 ?>


<body class="bg-half">
<div class=" school-header  px-4" >
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

