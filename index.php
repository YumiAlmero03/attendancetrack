<?php
require 'inc/head.php';
require_once 'header.php';

// get pass
require_once 'inc/db.php'; 
$search_login = "SELECT passnum FROM visitor join login on login.reg_id=visitor.id where logout is null";
$logs = mysqli_query($conn,$search_login);
$login = $logs->fetch_all();

$subjects = "SELECT code FROM subj where active= 1";
$subj = mysqli_query($conn,$subjects);
$class = $subj->fetch_all();

$passnumchoice = range(1, 10);
$remove = [];
foreach ($passnumchoice as $key => $value) {

  foreach ($login as $log => $data) {
  // var_dump($data[0] != strval($value));
  // var_dump(strval($value));
  // var_dump(($data[0]));

    if ($data[0] === strval($value)) {
      $remove[] = $value;
    }
  }
}
$remain = array_diff($passnumchoice, $remove);
?>
</head>
<body>
  
<?php require_once 'header.php'; ?> 
<div class="bg-main-light">
    <div class="container p-5 ">
        <div class=" px-5">
            <div class=" px-5">
                <div class=" p-5">
                    <h2  class="text-center pb-5">Scan Qr to Login</h2 > 
                    <!-- </br> -->
                    <select class="form-control" id="subject"> 
                      <option disabled selected>Select Subject</option>
                      <?php 
                        foreach ($class as $value) {
                          echo "<option value='".$value[0]."'>".$value[0]."</option>";
                        }
                       ?>
                      
                    </select>               
                </div>
                <div class="p-3 bg-third">
                    <video id="preview" width="100%"></video>        
                </div>
                <div class="py-5">
                    <button class="btn bg-main text-white btn-block" data-toggle="modal" data-target="#visitorModal">Visitor</button>
                </div>
            </div>
        </div>
    </div>
    
</div>

<div class="modal fade" id="visitorModal" tabindex="-1" aria-labelledby="visitorModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content p-5 bg-third">
      <div class=" text-center text-second">
        <h3 class="modal-title " id="visitorModalLabel">Visitor Login</h3>
      </div>
        <form action="visit.php" method="post" target="_blank">
          <div class="modal-body">
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="visitorName">Name:</label>
                <input type="text" name="name" class="form-control" id="visitorName" required>
              </div>
              <div class="form-group col-md-6">
                <label for="visitorPurpose">Purpose:</label>
                <input type="text" name="purpose" class="form-control" id="visitorPurpose" required>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-12">
                <label for="visitorAdd">Address:</label>
                <input type="text" name="address" class="form-control" id="visitorAdd" required>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-4">
                <label for="visitorEmail">Contact Number:</label>
                <input type="number" name="email" class="form-control" id="visitorEmail" required>
              </div>
              <div class="form-group col-md-4">
                <label for="visitorEmail">Pass Number:</label>
                <input type="number" readonly name="passnum" class="form-control" id="visitorEmail" value="<?php echo current($remain); ?>" required>
              </div>
              <div class="form-group col-md-4">
                <label for="visitorEmail">Type:</label>
                <select name="ptype" id="cars" required class="form-control">
                  <option disabled>Select</option>
                  <option value="Parent">Parent</option>
                  <option value="Visitor">Visitor</option>
                  <option value="Alumni">Alumni</option>
                </select>
              </div>
            </div>
          </div>
          <div class="">
            <div class="row">
                <div class="col-sm-12 text-center">
                    <button type="submit" class="btn bg-second text-white" onclick="setTimeout(function(){ location.reload(); }, 3000);" >Submit</button>
                    <br>
                    <br>
                    <br>
                    <a data-toggle="modal" class="btn bg-main text-white" data-dismiss="modal" data-target="#visitorExitModal">Visitor Exit Log</a>
                </div>
            </div>
          </div>
        </form>
    </div>
  </div>
</div>
<div class="modal fade" id="visitorExitModal" tabindex="-1" aria-labelledby="visitorExitModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content p-5 bg-third">
      <div class=" text-center text-second">
        <h3 class="modal-title " id="visitorExitModalLabel">Exit Visitor Log</h3>
      </div>
        <div>
            <form action="exit.php" method="post" target="_blank">
                <div class="modal-body">
                  <div class="form-group">
                    <input type="number" name="passnum" class="form-control" placeholder="Enter Pass Number" required>
                    <input type="submit" name="submit" class="form-control"  >
                  </div>
              </div>
            </form>
        </div>
    </div>
  </div>
</div>
<?php require 'inc/bottom.php' ?>

<script type="text/javascript" src="/script/scan.min.js"></script>
<script type="text/javascript">
    var scanner = new Instascan.Scanner({ video: document.getElementById('preview'), scanPeriod: 5, mirror: false });

    scanner.addListener('scan',function(content){
         subject = document.getElementById("subject").value;

         window.open('scan.php?code='+content+'&subj='+subject, '_blank');
    });
    Instascan.Camera.getCameras().then(function (cameras){
        console.log(cameras);
        if(cameras[0]){
            scanner.start(cameras[0]);
            
        }else{
            location.reload();

        }
    }).catch(function(e){
        console.error(e);
        alert(e);
    });
</script>
</body>
</html>