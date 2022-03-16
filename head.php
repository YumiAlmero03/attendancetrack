<?php 
 $activePage = basename($_SERVER['PHP_SELF'], ".php");
require_once 'inc/head.php';
?>

<body class="bg-half">

<div class=" school-header  px-4" >
  <div class="col-sm-3">
      <img class="align-left" src="assets/logo.png" height="100px">
  </div>
  <div class="col-sm-6  ">
    <div class="text-center">
      <nav class="navbar navbar-expand-lg  text-second">
      <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
        <!-- left nav -->
        <ul class="navbar-nav ">
          <li class="nav-item">
            <a class="nav-link <?= ($activePage == 'home') || ($activePage == '') ? 'active':''; ?>" href="home.php">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item ">
            <a class="nav-link <?= ($activePage == 'about')  ? 'active':''; ?>" href="about.php">About Us</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= ($activePage == 'contact')  ? 'active':''; ?>" href="contact.php">Contact Us</a>
          </li>
        </ul>
        
      </div>
    </nav>
    </div>
  </div>
  <div class="col-sm-3  ">
    <div class="text-right">
      <nav class="navbar navbar-expand-lg  text-second">
          <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
            <!-- left nav -->
            <ul class="navbar-nav ">
              <li class="nav-item">
                <a class="nav-link " href="admin/login.php">Log In </a>
              </li>
            </ul>
            
          </div>
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