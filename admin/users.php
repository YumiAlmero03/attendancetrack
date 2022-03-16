<?php 

require_once '../inc/session.php';
require_once '../inc/head.php';
require_once 'head.php';
require_once '../inc/db.php';
require_once '../inc/hash.php';

$userid= $_SESSION['id'];
$fetchuser = mysqli_query($conn, "SELECT * FROM users where id=$userid");
$user = $fetchuser->fetch_assoc();

$ar = mysqli_query($conn, "SELECT * FROM users");
$rows = $ar->fetch_all();
?>
<div>
  
  <div class="bg-main-light">
    <div class="container-fluid p-5">
        <ul class="nav nav-tabs page-title">
          <li ><a data-toggle="tab" href="#student" class="active">Your Account</a></li>
          <li><a data-toggle="tab" href="#visitor">Manage Account</a></li>
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
                <tr>
                  <td></td>
                  <td><button type="submit" class="btn btn-block bg-third text-white">Edit</button></td>
                </tr>
              </table>
              
            </form>
          </div>

          <div id="visitor" class="tab-pane fade">
            <div class="search pb-5">
                
                <!-- <div class="float-right"><a  class="btn bg-second text-white" data-toggle="modal" data-target="#reportModalAdd">Create User</a></div>

                <div class="modal fade" id="reportModalAdd" tabindex="-1" aria-labelledby="visitorModalLabelAdd" aria-hidden="true">
                  <div class="modal-dialog ">
                    <div class="modal-content bg-third p-5">
                      <div class="modal-header text-second text-center">
                        <h4 class="modal-title text-center pb-3" id="visitorModalLabelAdd">Create User</h4>
                      </div>
                      <div class="modal-body">
                        <form action="useracc.php" method="post" enctype="multipart/form-data">
                          <div class="form-row">
                            <div class="form-group col-md-12">
                              <label for="username">Username</label>
                              <input name="username" type="text" class="form-control" id="username" required>
                            </div>
                            <div class="form-group col-md-9">
                              <label for="name">Full Name</label>
                              <input name="name" type="text" class="form-control" id="name" required>
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


                <div class="float-right">
                  <a href="backup.php" class="btn bg-second text-white px-5" >Backup DB</a> 
                  <a  class="btn bg-second text-white px-5" data-toggle="modal" data-target="#reportModalAddAdmin">Create Admin</a> 
                  <a  class="btn bg-second text-white" data-toggle="modal" data-target="#reportModalAdd">Create Staff</a>
                  <a  class="btn bg-second text-white" data-toggle="modal" data-target="#reportModalClass">Create Class</a>
                  <a  class="btn bg-second text-white" data-toggle="modal" data-target="#reportModalFaculty">Create Faculty</a>
                </div>

                <div class="modal fade" id="reportModalAdd" tabindex="-1" aria-labelledby="visitorModalLabelAdd" aria-hidden="true">
                  <div class="modal-dialog ">
                    <div class="modal-content bg-third p-5">
                      <div class="modal-header text-second text-center">
                        <h3 class="modal-title text-center " id="visitorModalLabelAdd">Create User</h3>
                      </div>
                      <div class="modal-body">
                        <h3 class="modal-title pb-3" id="visitorModalLabelAdd">Access Level: Staff</h3>
                        <form action="userclass.php" method="post" enctype="multipart/form-data">
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
                            <div class="form-group col-md-9">
                              <label for="email">ID number</label>
                              <input name="meta[id_num]" type="text" class="form-control" id="email" required>
                            </div>
                            <div class="form-group col-md-9">
                              <label for="email">Department</label>
                              <input name="meta[department]" type="text" class="form-control" id="email" required>
                            </div>
                            <div class="form-group col-md-9">
                              <label for="email">Address</label>
                              <input name="meta[address]" type="text" class="form-control" id="email" required>
                            </div>
                            <div class="form-group col-md-9">
                              <label for="email">Contact number</label>
                              <input name="meta[contact_num]" type="text" class="form-control" id="email" required>
                            </div>
                            <div class="form-group col-md-9">
                              <label for="email">Birthdate</label>
                              <input name="meta[bday]" type="date" class="form-control" id="email" required>
                            </div>
                            <div class="form-group col-md-9">
                              <label for="email">Contact person in case of Emergency</label>
                              <input name="meta[emergency]" type="text" class="form-control" id="email" required>
                            </div>
                            <div class="form-group col-md-9">
                              <label for="email">Contact Number</label>
                              <input name="meta[emergency_num]" type="text" class="form-control" id="email" required>
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
                <div class="modal fade" id="reportModalClass" tabindex="-1" aria-labelledby="visitorModalLabelAdd" aria-hidden="true">
                  <div class="modal-dialog ">
                    <div class="modal-content bg-third p-5">
                      <div class="modal-header text-second text-center">
                        <h3 class="modal-title text-center " id="visitorModalLabelAdd">Create User</h3>
                      </div>
                      <div class="modal-body">
                        <h3 class="modal-title pb-3" id="visitorModalLabelAdd">Access Level: Class</h3>
                        <form action="userclass.php" method="post" enctype="multipart/form-data">
                          <div class="form-row">
                            <div class="form-group col-md-9">
                              <label for="username">Username</label>
                              <input name="username" type="text" class="form-control" id="username" required>
                            </div>
                            <div class="form-group col-md-9">
                              <label for="name">Class Representative (name)</label>
                              <input name="name" type="text" class="form-control" id="name" required>
                            </div>
                            <div class="form-group col-md-9">
                              <label for="email">Email</label>
                              <input name="email" class="form-control" id="email" value="studentmngmt@gmail.com" required>
                            </div>
                            <div class="form-group col-md-9">
                              <label for="email">Student Number</label>
                              <input name="meta[stud_num]" type="text" class="form-control" id="num" required>
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
                <div class="modal fade" id="reportModalFaculty" tabindex="-1" aria-labelledby="visitorModalLabelAdd" aria-hidden="true">
                  <div class="modal-dialog ">
                    <div class="modal-content bg-third p-5">
                      <div class="modal-header text-second text-center">
                        <h3 class="modal-title text-center " id="visitorModalLabelAdd">Create User</h3>
                      </div>
                      <div class="modal-body">
                        <h3 class="modal-title pb-3" id="visitorModalLabelAdd">Access Level: Faculty</h3>
                        <form action="userclass.php" method="post" enctype="multipart/form-data">
                          <div class="form-row">
                            <div class="form-group col-md-9">
                              <label for="username">Username</label>
                              <input name="username" type="text" class="form-control" id="username" required>
                            </div>
                            <div class="form-group col-md-9">
                              <label for="name">Name</label>
                              <input name="name" type="text" class="form-control" id="name" required>
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
                              <input name="meta[department]" type="text" class="form-control" id="num" required>
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
                <div class="modal fade" id="reportModalAddAdmin" tabindex="-1" aria-labelledby="visitorModalLabelAdd" aria-hidden="true">
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
                </div>

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

<?php 
require_once '../inc/bottom.php';
?>