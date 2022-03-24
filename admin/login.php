<?php 
// Initialize the session
session_start();
 
require_once '../inc/head.php';
require_once '../inc/db.php';
require_once '../inc/hash.php';
require_once '../inc/mail.php';

// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: /admin/index.php");
    exit;
}


// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = ($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = ($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, username, password, level, email, name FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password, $level, $email, $name);
                    if(mysqli_stmt_fetch($stmt)){
                        if(check_pass($password, $hashed_password)){
                            // Password is correct, so start a new session
                            // session_start();
                            
                            // Store data in session variables
                            $_SESSION["id"] = $id;
                            $_SESSION["level"] = $level;
                            $_SESSION["username"] = $username;   
                            // $code = createRandomPassword();
                            // $text = 'Your OTP for Student Management And Attendance Monitoring System: '.$code;
                            // mailSend($email,$name,'[OTP] Student Management And Attendance Monitoring System',$text);
                            // $otp = mysqli_query($conn, "INSERT INTO `otp` (`username`, `code`) VALUES ('$username', '$code')");
                            // Redirect user to otp page
                            header("location: ../admin/otp.php");
                        } else{
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else{
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid username or password.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($conn);
}
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
<div class="p-5 m-5">
    <div class="container p-5  bg-main form-main">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <h2 class="text-center text-white">Welcome!</h2>
        <p class="text-center p-2">Please fill in your credentials to login.</p>

        <?php 
        if(!empty($login_err)){
            echo '<p class="text-error text-center">*' . $login_err . '</p>';
        } elseif(!empty($username_err)){
            echo '<p class="text-error text-center">*' . $username_err . '</p>';            
        }  elseif(!empty($password_err)){
            echo '<p class="text-error text-center">*' . $password_err . '</p>';            
        }         
        ?>
            <div class="form-group">
                <label class="text-white p-2">Username</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
            </div>    
            <div class="form-group">
                <label class="text-white p-2">Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <!-- <p class="">Please fill in your credentials to login.</p> -->
            </div>
            <div class="form-group text-center pt-3">
                <button type="submit" class="btn bg-second text-white " value="Login">Login</button> 
            </div>
        </form>
    </div>    
</div>