<?php 

require_once '../inc/session.php';
require_once '../inc/head.php';
require_once 'head.php';
require_once '../inc/db.php';

?>
<div class="container py-5">
    <h1 class="text-second">
        Register
    </h1>
</div>
<div class="container pb-5">
	<form action="reg.php" method="post" enctype="multipart/form-data">
	  <div class="float-left">
    		<img id="preview" src="../assets/pup.png" alt="your image" width="200px"/>
    		<br>
	  		<input type='file' onchange="readURL(this);" name="photo"/>
    		<br>
    		<small>Select 200px X 200px photo</small>
	  </div>
	  <div class="form-row">
	    <div class="form-group col-md-6">
	      <label for="inFN">First name</label>
	      <input name="fn" type="text" class="form-control" id="inFN" required>
	    </div>
	    <div class="form-group col-md-6">
	      <label for="inLN">Last name</label>
	      <input name="ln" type="text" class="form-control" id="inLN" required>
	    </div>
	  </div>
	  <div class="form-row">
	    <div class="form-group col-md-4">
	      <label for="inCourse">Course</label>
	      <select name="course" class="form-control" id="inCourse" required>
	      	  <option disabled selected>Select Course</option>
		      <option value="BSIT">BSIT</option>
		      <option value="BSPsych">BSPsych</option>
		    </select>
	    </div>
	    <div class="form-group col-md-4">
	      <label for="inYear">Year</label>
	      <input name="yr" type="text" class="form-control" id="inYear" required>
	    </div>
	    <div class="form-group col-md-4">
	      <label for="inSection">Section</label>
	      <input name="sec" type="text" class="form-control" id="inSection" required>
	    </div>
	  </div>
	  <div class="form-row">
	    <div class="form-group col-md-6">
	      <label for="inBday">Birthday</label>
	      <input name="bday" type="date" class="form-control" id="inBday" required>
	    </div>
	    <div class="form-group col-md-6">
	      <label for="inEmail">Email</label>
	      <input name="email" type="text" class="form-control" id="inEmail" required>
	    </div>
	  </div>
	  <div class="form-group">
	    <label for="inAdd">Address</label>
	    <input name="add" type="text" class="form-control" id="inAdd"  required>
	  </div>
	  <div class="form-row">
	    <div class="form-group col-md-6">
	      <label for="inPName">Parent’s Name</label>
	      <input name="pname" type="text" class="form-control" id="inPName" >
	    </div>
	    <div class="form-group col-md-6">
	      <label for="inPNum">Parent’s Contact Number</label>
	      <input name="pnum" type="text" class="form-control" id="inPNum" max="11" min="7">
	    </div>
	  </div>
	  <div class="form-row">
	    <div class="form-group col-md-6">
	        <label for="inType">
	        	Type
	        </label>
	        <select name="type" class="form-control" id="inType">
		      <option value="Student">Student</option>
		      <option value="Professor">Professor</option>
		      <option value="Staff">Staff</option>
		    </select>
	    </div>
	    <div class="form-group col-md-6">
	      <label for="inStudID">Student ID</label>
	      <input name="studid" type="text" class="form-control" id="inStudID" required>
	    </div>
	  </div>
	  <button type="submit" class="btn bg-second text-main">Register</button>
	</form>
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