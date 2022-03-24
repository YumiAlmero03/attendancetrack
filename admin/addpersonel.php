<?php 
require_once '../inc/session.php';
require_once '../inc/head.php';
require_once 'head.php';
require_once '../inc/db.php';

$photo = '../assets/pup.png';
$fn = '';
$ln = '';
$course = '';
$yr = '';
$sec = '';
$bday = '';
$email = '';
$add = '';
$pname = '';
$pnum = '';

if (isset($_GET['id'])) {
	$getReg = mysqli_query($conn, "SELECT * FROM `registered` where id=".$_GET['id']);
    $registered = $getReg->fetch_assoc();
    $photo = '../uploads/profile/'.$registered['photo'];
    $fn = $registered['firstname'];
    $ln = $registered['lastname'];
    $course = $registered['course'];
    $yr = $registered['year'];
    $sec = $registered['section'];
    $bday = $registered['bday'];
    $email = $registered['email'];
    $add = $registered['address'];
    $pname = $registered['pname'];
    $pnum = $registered['pcontact'];
}
?>
<div class="bg-main-light">
<div class="container py-5">
    <h1 class="text-second">
        <?php 	isset($_GET['id']) ? print('Edit profile') : print('Register') ?>
    </h1>
</div>
<div class="container pb-5">
	<form action="reg.php" method="post" enctype="multipart/form-data">
	  <div class="float-left text-center">
    		<img id="preview" src="<?php echo $photo ?>" alt="your image" width="190px"/>
    		<label class="btn bg-second text-white pt-2 btn-block m-0" for="photo">Choose File</label>
    		<?php 
	      	if (isset($_GET['id'])) {
	      	?>
	  		<input  type='file' onchange="readURL(this);" id="photo" name="photo" accept="image/*" />
	      	<?php
	      	} else {
	      	?> 
	  		<input  type='file' onchange="readURL(this);" id="photo" name="photo" accept="image/*" required />
	  		<?php
	      	}
	      ?>
	  </div>
	  <div class="form-row">
	    <div class="form-group col-md-6">
	      <label for="inFN">First name</label>
	      <input name="fn" type="text" class="form-control" id="inFN" required value="<?php echo $fn; ?>">
	    </div>
	    <div class="form-group col-md-6">
	      <label for="inLN">Last name</label>
	      <input name="ln" type="text" class="form-control" id="inLN" required value="<?php echo $ln; ?>">
	    </div>
	  </div>
	  <div class="form-row">
	    <div class="form-group col-md-12">
	      <label for="inCourse">Department</label>
	      <select name="course" class="form-control" id="inCourse" required value="">
	      	  <option disabled <?php isset($_GET['id']) ? '' :  print('selected')?>>Select Department</option>
				<option value="Faculty" <?php $course === 'Faculty' ? print('selected') : ''?>>Faculty</option>
				<option value="IT" <?php $course === 'IT' ? print('selected') : ''?>>IT</option>
				<option value="Registar" <?php $course === 'Registar' ? print('selected') : ''?>>Registar</option>
				<option value="Accounting" <?php $course === 'Accounting' ? print('selected') : ''?>>Accounting</option>
				<option value="Principal" <?php $course === 'Principal' ? print('selected') : ''?>>Principal</option>
				<option value="Guidance" <?php $course === 'Guidance' ? print('selected') : ''?>>Guidance</option>
		      	<option value="Library" <?php $course === 'Library' ? print('selected') : ''?>>Library</option>
		      	<option value="Canteen" <?php $course === 'Canteen' ? print('selected') : ''?>>Canteen</option>
		      	<option value="Clinic" <?php $course === 'Clinic' ? print('selected') : ''?>>Clinic</option>
		      	<option value="Maintenance" <?php $course === 'Maintenance' ? print('selected') : ''?>>Maintenance</option>
		    </select>
	      <input name="yr" type="hidden" class="form-control" id="inYear" required value=" ">
	      <input name="sec" type="hidden" class="form-control" id="inSection" required value=" ">

	    </div>
	    <!-- <div class="form-group col-md-4">
	      <label for="inYear">Year</label>
	      <input name="yr" type="text" class="form-control" id="inYear" required value="<?php echo $yr; ?>">
	    </div>
	    <div class="form-group col-md-4">
	      <label for="inSection">Section</label>
	      <input name="sec" type="text" class="form-control" id="inSection" required value="<?php echo $sec; ?>">
	    </div> -->
	  </div>
	  <div class="form-row">
	    <div class="form-group col-md-6">
	      <label for="inBday">Birthday</label>
	      <input name="bday" type="date" class="form-control" id="inBday" required value="<?php echo $bday; ?>">
	    </div>
	    <div class="form-group col-md-6">
	      <label for="inEmail">Email</label>
	      <input name="email" type="email" class="form-control" id="inEmail" required value="<?php echo $email; ?>">
	    </div>
	  </div>
	  <div class="form-group">
	    <label for="inAdd">Address</label>
	    <input name="add" type="text" class="form-control" id="inAdd"  required value="<?php echo $add; ?>">
	  </div>
	  <div class="form-row">
	    <div class="form-group col-md-6">
	      <label for="inPName">Contact person in case of emergency</label>
	      <input name="pname" type="text" class="form-control" id="inPName" required value="<?php echo $pname; ?>">
	    </div>
	    <div class="form-group col-md-6">
	      <label for="inPNum">Contact Number</label>
	      <input name="pnum" type="number" class="form-control" id="inPNum" minlength="11" maxlength="11" required value="<?php echo $pnum; ?>">
	    </div>
	  </div>
	  <div class="form-row">
	    <div class="form-group col-md-6">
	      <label for="inStudID">ID Number</label>
	      <input type="hidden" name="type" value="Staff">
	      <?php 
	      	if (isset($_GET['id'])) {
	      	?>
	      		<input type="hidden" name="reg_id" value="<?php echo $registered['id']; ?>">
	     		<input name="studid" type="disabled" class="form-control disabled" disabled id="inStudID" value="<?php echo $registered['qrcode']; ?>">
		    </div>
		  </div>
		  <button type="submit" name="update" class="btn bg-second text-white">Update</button>
	      	<?php
	      	} else {
	      	?> 
	     		<input name="studid" type="text" class="form-control" id="inStudID" required >
		    </div>
		  </div>
		  <button type="submit" name="register" class="btn bg-second text-white">Register</button>
	      	<?php
	      	}
	      ?>
	      <a href="registered.php" class="btn bg-second text-white">Cancel</a>
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