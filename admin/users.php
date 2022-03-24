<?php 
require_once '../inc/db.php';
require_once '../inc/session.php';

require_once '../inc/head.php';
require_once 'head.php';
require_once '../inc/hash.php';


$userid= $_SESSION['id'];
$fetchuser = mysqli_query($conn, "SELECT * FROM users where id=$userid");
$user = $fetchuser->fetch_assoc();

$fetchmeta = mysqli_query($conn, "SELECT id, `key`, value FROM meta where user_id=$userid");
$meta = $fetchmeta->fetch_all();
if ($meta) {
    $getMeta = [];
    foreach ($meta as $value) {
        $key = $value[1];
        $getMeta[$key]=[
            'id' => $value[0],       
            'value' => $value[2]
       ];
    }
}
$photo = '../assets/pup.png';
$ar = mysqli_query($conn, "SELECT * FROM users");
$rows = $ar->fetch_all();
?>
<div>
  
  <div class="bg-main-light">
    <div class="container-fluid p-5">
        <ul class="nav nav-tabs page-title">
          <li ><a data-toggle="tab" href="#student" class="active">Your Account</a></li>
          <?php if ($_SESSION["level"] === 'admin') { ?>
          <li><a data-toggle="tab" href="#visitor">Manage Account</a></li>
          <?php } ?>
        </ul>
    </div>
    <div class="container-fluid px-5">

        <div class="tab-content">
          <div id="student" class="tab-pane fade in active show">
            <form action="useredit.php" class="form-main" method="post" enctype="multipart/form-data">
              <table class="table table-borderless">
                <tr>
                  <td><label for="name">Full name: </label></td>
                  <td>
                    <input name="name" type="text" class="form-control" id="name" value="<?php  echo $user['name']; ?>" required>
                    <input name="id" type="hidden" class="form-control" id="id" value="<?php  echo $user['id']; ?>" required>
                  </td>
                </tr>
                <tr>
                  <td><label for="username">Username:</label></td>
                  <td><input name="username" type="text" class="form-control" id="username" value="<?php  echo $user['username']; ?>" required></td>
                </tr>
                <tr>
                  <td><label for="email">Email:</label></td>
                  <td><input name="email" type="text" class="form-control" id="email" value="<?php  echo $user['email']; ?>" required></td>
                </tr>
                <tr>
                  <td><label for="password">Password</label></td>
                  <td><input name="pass" type="password" class="form-control" id="password" value="<?php  echo decrypt_word($user['password']); ?>" required></td>
                </tr>
                <?php if ($_SESSION["level"] === 'class') { 
                    $course = $getMeta['course']['value'];
                ?>
                  <tr>
                    <td><label for="stud_num">Student Number</label></td>
                    <td><input name="meta[<?php  echo $getMeta['stud_num']['id']; ?>]" type="text" class="form-control" id="stud_num" value="<?php  echo $getMeta['stud_num']['value']; ?>" required></td>
                  </tr>
                  <tr>
                    <td><label for="inCourse">Course</label></td>
                    <td>
                      <select name="meta[<?php  echo $getMeta['course']['id']; ?>]" class="form-control" id="inCourse" required value="">
                          <option disabled <?php isset($_GET['id']) ? '' :  print('selected')?>>Select Course</option>
                          <option value="BSA" <?php $course === 'BSA' ? print('selected') : ''?>>BS Accountancy</option>
                          <option value="BSBAFM" <?php $course === 'BSBAFM' ? print('selected') : ''?>>BSBA Financial Management</option>
                          <option value="BSEDUC" <?php $course === 'BSEDUC' ? print('selected') : ''?>>BS English</option>
                          <option value="BSENTREP" <?php $course === 'BSENTREP' ? print('selected') : ''?>>BS Entrepreneurship</option>
                          <option value="BSHM" <?php $course === 'BSHM' ? print('selected') : ''?>>BS Hospitality Management</option>
                          <option value="BSIT" <?php $course === 'BSIT' ? print('selected') : ''?>>BS Information Technology</option>
                          <option value="BSPSYCH" <?php $course === 'BSPSYCH' ? print('selected') : ''?>>BS Psychology</option>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td><label for="year">Year</label></td>
                    <td><input name="meta[<?php  echo $getMeta['yr']['id']; ?>]" type="text" class="form-control" id="year" value="<?php  echo $getMeta['yr']['value']; ?>" required></td>
                  </tr>
                  <tr>
                    <td><label for="section">Section</label></td>
                    <td><input name="meta[<?php  echo $getMeta['sec']['id']; ?>]" type="text" class="form-control" id="section" value="<?php  echo $getMeta['sec']['value']; ?>" required></td>
                  </tr>
                <?php } ?>
                <tr>
                  <td></td>
                  <td><button type="submit" class="btn btn-block bg-third text-white">Edit</button></td>
                </tr>
              </table>
              
            </form>
          </div>

          <div id="visitor" class="tab-pane fade">
            <div class="search pb-5">
                <div class="float-left">
                  <!-- <a  class="btn bg-second text-white px-5" data-toggle="modal" data-target="#reportModalAddAdmin">Create Admin</a>  -->
                  <a  class="btn bg-second text-white" data-toggle="modal" data-target="#reportModalAdd">Create Staff</a>
                  <a  class="btn bg-second text-white" data-toggle="modal" data-target="#reportModalClass">Create Class</a>
                  <!-- <a  class="btn bg-second text-white" data-toggle="modal" data-target="#reportModalFaculty">Create Faculty</a> -->
                </div>


                <div class="float-right">
                  <a href="backup.php" class="btn bg-second text-white px-5" >Backup DB</a> 
                </div>

                <div class="modal fade" id="reportModalAdd" tabindex="-1" aria-labelledby="visitorModalLabelAdd" aria-hidden="true">
                  <div class="modal-dialog ">
                    <div class="modal-content bg-third p-5">
                      <div class="modal-header text-second text-center">
                        <h3 class="modal-title text-center " id="visitorModalLabelAdd">Create User</h3>
                      </div>
                      <div class="modal-body">
                        <h3 class="modal-title pb-3" id="visitorModalLabelAdd">Access Level: Staff</h3>
                        <form action="useracc.php" method="post" enctype="multipart/form-data">
                          <div class="form-row">
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
                  </div>
                </div>
                
                <!-- <div class="modal fade" id="reportModalFaculty" tabindex="-1" aria-labelledby="visitorModalLabelAdd" aria-hidden="true">
                  <div class="modal-dialog ">
                    <div class="modal-content bg-third p-5">
                      <div class="modal-header text-second text-center">
                        <h3 class="modal-title text-center " id="visitorModalLabelAdd">Create User</h3>
                      </div>
                      <div class="modal-body">
                        <h3 class="modal-title pb-3" id="visitorModalLabelAdd">Access Level: Faculty</h3>
                        <form action="userclass.php" method="post" enctype="multipart/form-data">
                          <div class="form-row">
                            <div class="float-left text-center">
                                <img id="previewClass" src="<?php echo $photo ?>" alt="your image" width="190px"/>
                                <label class="btn bg-second text-white pt-2 btn-block m-0" for="photo">Choose File</label>
                                <?php 
                                  if (isset($_GET['id'])) {
                                  ?>
                                <input  type='file' onchange="readURLClass(this);" id="photo" name="photo" accept="image/*" />
                                  <?php
                                  } else {
                                  ?> 
                                <input  type='file' onchange="readURLClass(this);" id="photo" name="photo" accept="image/*" required />
                                <?php
                                  }
                                ?>
                            </div>
                            <div class="form-group col-md-9">
                              <label for="username">Username</label>
                              <input name="username" type="text" class="form-control" id="username" required>
                            </div>
                            <div class="form-group col-md-9">
                              <label for="username">Name</label>
                            </div>
                            <div class="form-group col-md-4">
                              <label for="name">First Name</label>
                              <input name="fn" type="text" class="form-control" id="fn" required>
                            </div>
                            <div class="form-group col-md-5">
                              <label for="name">Last Name</label>
                              <input name="ln" type="text" class="form-control" id="ln" required>
                            </div>
                            <div class="form-group col-md-9">
                              <label for="email">Email</label>
                              <input name="email" class="form-control" id="email" value="studentmngmt@gmail.com" required>
                            </div>
                            <div class="form-group col-md-9">
                              <label for="email">ID number</label>
                              <input name="meta[id_num]" type="text" class="form-control" id="num" required>
                            </div>
                            <div class="form-group col-md-9">
                              <label for="email">Department</label>
                              <select name="meta[department]" class="form-control" id="inCourse" required value="">
                                    <option disabled >Select Course</option>
                                    <option value="BSA" >BS Accountancy</option>
                                    <option value="BSBAFM" >BSBA Financial Management</option>
                                    <option value="BSEDUC" >BS English</option>
                                    <option value="BSENTREP" >BS Entrepreneurship</option>
                                    <option value="BSHM" >BS Hospitality Management</option>
                                    <option value="BSIT" >BS Information Technology</option>
                                    <option value="BSPSYCH" >BS Psychology</option>
                              </select>
                            </div>
                            <div class="form-group col-md-9">
                              <label for="email">Address</label>
                              <input name="meta[address]" type="text" class="form-control" id="num" required>
                            </div>
                            <div class="form-group col-md-9">
                              <label for="email">Contact number</label>
                              <input name="meta[contact_num]" type="text" class="form-control" id="num" required>
                            </div>
                            <div class="form-group col-md-9">
                              <label for="email">Birthdate</label>
                              <input name="meta[bday]" type="date" class="form-control" id="num" required>
                            </div>
                            <div class="form-group col-md-9">
                              <label for="email">Contact person in case of Emergency</label>
                              <input name="meta[emergency]" type="text" class="form-control" id="num" required>
                            </div>
                            <div class="form-group col-md-9">
                              <label for="email">Contact Number</label>
                              <input name="meta[emergency_num]" type="text" class="form-control" id="num" required>
                            </div>
                          </div> 
                          <div class="form-row">
                            <div class="form-group col-md-9">
                              <label for="pass">Password</label>
                              <input type="hidden" name="level" value="faculty">
                              <input name="pass" type="password" class="form-control" id="pass" required>
                            </div>
                          </div>
                          <button type="submit" class="btn bg-second text-white">Create</button>
                        </form>
                        
                      </div>
                    </div>
                  </div>
                </div> -->
                <div class="modal fade" id="reportModalClass" tabindex="-1" aria-labelledby="visitorModalLabelAdd" aria-hidden="true">
                  <div class="modal-dialog ">
                    <div class="modal-content bg-third p-5">
                      <div class="modal-header text-second text-center">
                        <h3 class="modal-title text-center " id="visitorModalLabelAdd">Create User</h3>
                      </div>
                      <div class="modal-body">
                        <h3 class="modal-title pb-3" id="visitorModalLabelAdd">Access Level: Class Representative</h3>
                        <form action="userclass.php" method="post" enctype="multipart/form-data">
                          <div class="form-row">
                            <div class="float-left text-center">
                                <img id="previewClass" src="<?php echo $photo ?>" alt="your image" width="190px"/>
                                <label class="btn bg-second text-white pt-2 btn-block m-0" for="photo">Choose File</label>
                                <?php 
                                  if (isset($_GET['id'])) {
                                  ?>
                                <input  type='file' onchange="readURLClass(this);" id="photo" name="photo" accept="image/*" />
                                  <?php
                                  } else {
                                  ?> 
                                <input  type='file' onchange="readURLClass(this);" id="photo" name="photo" accept="image/*" required />
                                <?php
                                  }
                                ?>
                            </div>
                            <div class="form-group col-md-9">
                              <label for="username">Username</label>
                              <input name="username" type="text" class="form-control" id="username" required>
                            </div>
                            <div class="form-group col-md-9">
                              <label for="username">Class Representative (name)</label>
                            </div>
                            <div class="form-group col-md-4">
                              <label for="name">First Name</label>
                              <input name="fn" type="text" class="form-control" id="fn" required>
                            </div>
                            <div class="form-group col-md-5">
                              <label for="name">Last Name</label>
                              <input name="ln" type="text" class="form-control" id="ln" required>
                            </div>
                            <div class="form-group col-md-9">
                              <label for="email">Email</label>
                              <input name="email" class="form-control" id="email" value="studentmngmt@gmail.com" required>
                            </div>
                            <div class="form-group col-md-9">
                              <label for="email">Course</label>
                              <select name="meta[course]" class="form-control" id="inCourse" required value="">
                                    <option disabled >Select Course</option>
                                    <option value="BSA" >BS Accountancy</option>
                                    <option value="BSBAFM" >BSBA Financial Management</option>
                                    <option value="BSEDUC" >BS English</option>
                                    <option value="BSENTREP" >BS Entrepreneurship</option>
                                    <option value="BSHM" >BS Hospitality Management</option>
                                    <option value="BSIT" >BS Information Technology</option>
                                    <option value="BSPSYCH" >BS Psychology</option>
                              </select>
                            </div>
                            <div class="form-group col-md-9">
                              <label for="email">Year</label>
                              <input name="meta[yr]" type="text" class="form-control" id="num" required>
                            </div>
                            <div class="form-group col-md-9">
                              <label for="email">Section</label>
                              <input name="meta[sec]" type="text" class="form-control" id="num" required>
                            </div>
                            <div class="form-group col-md-9">
                              <label for="email">Student Number</label>
                              <input name="meta[stud_num]" type="text" class="form-control" id="num" required>
                            </div>
                            <div class="form-group col-md-9">
                              <label for="email">Birthday</label>
                              <input name="meta[bday]" type="date" class="form-control" id="num" required>
                            </div>
                            <div class="form-group col-md-9">
                              <label for="email">Address</label>
                              <input name="meta[address]" type="text" class="form-control" id="num" required>
                            </div>
                            <div class="form-group col-md-9">
                              <label for="email">Contact person in case of Emergency</label>
                              <input name="meta[emergency]" type="text" class="form-control" id="num" required>
                            </div>
                            <div class="form-group col-md-9">
                              <label for="email">Contact Number</label>
                              <input name="meta[emergency_num]" type="text" class="form-control" id="num" required>
                            </div>

                          </div> 
                          <div class="form-row">
                            <div class="form-group col-md-9">
                              <label for="pass">Password</label>
                              <input type="hidden" name="level" value="class">
                              <input name="pass" type="password" class="form-control" id="pass" required>
                            </div>
                          </div>
                          <button type="submit" class="btn bg-second text-white">Create</button>
                        </form>
                        
                      </div>
                    </div>
                  </div>
                </div>
                <!-- <div class="modal fade" id="reportModalAddAdmin" tabindex="-1" aria-labelledby="visitorModalLabelAdd" aria-hidden="true">
                  <div class="modal-dialog ">
                    <div class="modal-content bg-third p-5">
                      <div class="modal-header text-second text-center">
                        <h3 class="modal-title text-center " id="visitorModalLabelAdd">Create User</h3>
                      </div>
                      <div class="modal-body">
                        <h3 class="modal-title pb-3" id="visitorModalLabelAdd">Access Level: Admin</h3>
                        <form action="useracc.php" method="post" enctype="multipart/form-data">
                          <div class="form-row">
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
                              <input type="hidden" name="level" value="admin">
                              <input name="pass" type="password" class="form-control" id="pass" required>
                            </div>
                          </div>
                          <button type="submit" class="btn bg-second text-white">Create</button>
                        </form>
                        
                      </div>
                    </div>
                  </div>
                </div> -->

            </div>
            <table class="table">
              <thead>
                <tr class="bg-main text-white">
                  <th scope="col">ID</th>
                  <th scope="col">Username</th>
                  <th scope="col">Full Name</th>
                  <th scope="col">User Level</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                foreach ($rows as $id => $value) {
                ?>
                <tr>
                  <td><?php echo $id +1; ?></td>
                  <td><?php echo $value['1']; ?></td>
                  <td><?php echo $value['5']; ?></td>
                  <td><?php echo ucfirst($value['4']); ?></td>
                  <td>
                    <a  class="btn bg-third text-white" data-toggle="modal" data-target="#reportModal<?php echo $value['0']; ?>">Edit</a>
                    <div class="modal fade" id="reportModal<?php echo $value['0']; ?>" tabindex="-1" aria-labelledby="visitorModalLabel<?php echo $value['0']; ?>" aria-hidden="true">
                      <div class="modal-dialog ">
                        <div class="modal-content bg-third p-5">
                          <div class="modal-header text-second text-center">
                            <h4 class="modal-title text-center pb-3" id="visitorModalLabel<?php echo $value['0']; ?>">Edit Profile</h4>
                          </div>
                          <div class="modal-body">
                        <h3 class="modal-title pb-3" id="visitorModalLabelAdd">Access Level: <?php echo ucfirst($value['4']); ?></h3>
                            <form action="useredit.php" method="post" enctype="multipart/form-data">
                              <div class="form-row">
                                <div class="form-group col-md-12">
                                  <label for="username">Username</label>
                                  <input name="username" type="text" class="form-control" id="username" value="<?php echo $value['1']; ?>" required>
                                  <input name="id" type="hidden" class="form-control" id="id" value="<?php echo $value['0']; ?>" required>
                                </div>
                                <div class="form-group col-md-12">
                                  <label for="name">Full Name</label>
                                  <input name="name" type="text" class="form-control" id="name" value="<?php echo $value['5']; ?>" required>
                                </div>
                                <div class="form-group col-md-12">
                                  <label for="email">Email</label>
                                  <input name="email" type="text" class="form-control" id="email" value="<?php echo $value['6']; ?>" required>
                                </div>
                                <div class="form-group col-md-12">
                                  <label for="pass">Password</label>
                                  <input name="pass" type="password" class="form-control" id="pass" value="<?php echo decrypt_word($value['2']); ?>" required>
                                </div>
                              </div>
                              <button type="submit" class="btn bg-second text-white">Edit</button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- <a  class="btn bg-third text-white" data-toggle="modal" data-target="#passModal<?php echo $value['0']; ?>">Change Password</a>
                    <div class="modal fade" id="passModal<?php echo $value['0']; ?>" tabindex="-1" aria-labelledby="passModalLabel<?php echo $value['0']; ?>" aria-hidden="true">
                      <div class="modal-dialog ">
                        <div class="modal-content bg-third p-5">
                          <div class="modal-header text-second text-center">
                            <h4 class="modal-title text-center pb-3" id="passModalLabel<?php echo $value['0']; ?>">Change Password</h4>
                          </div>
                          <div class="modal-body">
                            <form action="changepass.php" method="post" enctype="multipart/form-data">
                              <div class="form-row">
                                <div class="form-group col-md-12">
                                  <label for="username">Password</label>
                                  <input name="username" type="text" class="form-control" id="password" required>
                                </div>
                                <div class="form-group col-md-12">
                                  <label for="name">Confirm Password</label>
                                  <input name="name" type="text" class="form-control" id="confirm" required>
                                </div>
                              </div>
                              <button type="submit" class="btn bg-second text-white">Change</button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div> -->
                  </td>
                </tr>

                <?php 
                }
                ?>
              </tbody>
            </table>

          </div>

        </div>
        
    </div>
  </div>
</div>


<!-- <script type="text/javascript">
  function readURLClass(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#previewClass')
                    .attr('src', e.target.result)
                    .width(150)
                    .height(200);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script> -->
<script type="text/javascript">
    function readURLClass(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#previewClass')
                    .attr('src', e.target.result)
                    .width(150)
                    .height(200);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

</script>
<?php 
require_once '../inc/bottom.php';
?>