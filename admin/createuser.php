<?php 

require_once '../inc/session.php';
require_once '../inc/head.php';
require_once 'head.php';
require_once '../inc/db.php';

?>
<div class="bg-main-light">
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
<?php if ($_SESSION["level"] === 'admin') { ?>
<div class="container py-5">
    <h1 class="text-second">
        Create Admin
    </h1>
</div>
<div class="container pb-5">
	<form action="useracc.php" method="post" enctype="multipart/form-data">
	  <div class="form-row">
	    <div class="form-group col-md-6">
	      <label for="username">Username</label>
	      <input name="username" type="text" class="form-control" id="username" required>
	    </div>
	    <div class="form-group col-md-6">
	      <label for="name">Full Name</label>
	      <input name="name" type="text" class="form-control" id="name" required>
	    </div>
	  </div>
	  <div class="form-row">
	    <div class="form-group col-md-4">
	      <label for="pass">Password</label>
	      <input type="hidden" name="level" value="admin">
	      <input name="pass" type="password" class="form-control" id="pass" required>
	    </div>
	  </div>
	  <button type="submit" class="btn bg-second text-white">Create</button>
	</form>
</div>
<?php } ?>
<div class="container py-5">
    <h1 class="text-second">
        Create Staff
    </h1>
</div>
<div class="container pb-5">
	<form action="useracc.php" method="post" enctype="multipart/form-data">
	  <div class="form-group col-md-9">
                              <label for="username">Username</label>
                              <input name="username" type="text" class="form-control" id="username" required>
                            </div>
                            <div class="form-group col-md-9">
                              <label for="name">Full Name</label>
                              <input name="name" type="text" class="form-control" id="name" required>
                            </div>
                            <div class="form-group col-md-9">
                              <label for="email">Email</label>
                              <input name="email" type="text" class="form-control" id="email" required>
                            </div>
                          </div>
                          <div class="form-row">
                            <div class="form-group col-md-9">
                              <label for="pass">Password</label>
                              <input type="hidden" name="level" value="staff">
                              <input name="pass" type="password" class="form-control" id="pass" required>
                            </div>
                          </div>
	  <button type="submit" class="btn bg-second text-white">Create</button>
	</form>
</div>
</div>
<?php 
require_once '../inc/bottom.php';
?>
<script type="text/javascript">
	  function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#preview')
                        .attr('src', e.target.result)
                        .width(150)
                        .height(200);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

</script>