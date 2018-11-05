<?php
session_start();

if(!isset($_SESSION['userid'])){
  header('Location: login.php');
}
require_once('classes/log.php');

$id = $_SESSION['userid'];
$email = $_SESSION['email'];
$firstname = $_SESSION['fname'];
$lastname = $_SESSION['lname'];
$company = $_SESSION['company'];
$companyNoSpaces = str_replace(' ', '_', $company);
$filter = $_SESSION['filter'];
$admin = $_SESSION['admin'];

//somechange
//verify Report status
$reportpath = 'uploads/'.$companyNoSpaces.'/reports';



?>

<html lang="en">

<?php require('headers.php'); ?>
<head>
  <link rel="stylesheet" href="css/logincss.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">

<head>

<body>


  <script language="javascript" type="text/javascript">


    function reportdownload(filename){

      ajaxRequest = new XMLHttpRequest();
      ajaxRequest.onreadystatechange = function(){
        if(ajaxRequest.readyState == 4){

          var status = ajaxRequest.responseText;
          //alert(status);
        }
      }

      var queryString = "?download=" + filename;
      ajaxRequest.open("GET", "reportdownload.php" + queryString, true);
      ajaxRequest.send(null);
    }


    function triggerLaneMapper(){
        var distances = "0";
        var option = "";
        var usbcoption = "0";
        var id = document.getElementById("exampleModalLabel").innerHTML;


        $( "select option:selected" ).each(function() {
          option += $( this ).text();
        });

        ajaxRequest = new XMLHttpRequest();
        ajaxRequest.onreadystatechange = function(){
          if(ajaxRequest.readyState == 4){

            var status = ajaxRequest.responseText;
            //alert(status);
             location.reload();

          }
        }


            if (option == "Choose..."){
              alert("Please Select a Report");
            }else{
              if(option == "Reports for USBC (Wood)"){

                 distances = document.getElementById('distances3').value;
                 usbcoption = 1;
                 if(/^(([^A-Za-z]\d+,)+([^A-Za-z]\d+,)+([^A-Za-z]\d))*$/.test(distances) == false || distances == '' || distances[distances.length-1] == ','){
                   alert("Please Enter 3 distances divided by commas. Ex. 12,25,46");
                   return;
                 }

              }

              if(option == "Reports for USBC (Synthetic)"){
                 distances = document.getElementById('distances5').value;
                 usbcoption = 2;
                 if(/^(([^A-Za-z]\d+,)+([^A-Za-z]\d+,)+([^A-Za-z]\d+,)+([^A-Za-z]\d+,)+([^A-Za-z]\d))*$/.test(distances) == false || distances == '' || distances[distances.length-1] == ','){
                   alert("Please Enter 5 distances divided by commas. Ex. 12,25,38,46,57");
                   return;
                 }
              }

              if(option == "Reports for USBC (Multi)"){
                 distances = document.getElementById('distances5').value;
                 usbcoption = 3;
                 if(/^(([^A-Za-z]\d+,)+([^A-Za-z]\d+,)+([^A-Za-z]\d+,)+([^A-Za-z]\d+,)+([^A-Za-z]\d))*$/.test(distances) == false || distances == '' || distances[distances.length-1] == ','){
                   alert("Please Enter 5 distances divided by commas. Ex. 12,25,38,46,57");
                   return;
                 }
              }

              if(option == "Before and After Comparison"){
                var beforefile = "";
                var afterfile = "";
                var lanestocompare = "";
                lanestocompare = document.getElementById('lanestocompare').value;
                if(/^([^A-Za-z]\d*)$|(^(?!.*,,)(([^A-Za-z]\d*,)+([^A-Za-z]\d*)+)$)/.test(lanestocompare) == false || lanestocompare == '0' || lanestocompare == '' || lanestocompare[lanestocompare.length - 1] == ','){
                  alert("Please enter lanes to compare divided by comas if more than 1 lane. Ex. 1,7,8,10");
                  return;
                }


                $('.custom-control-input:checkbox:checked').each(function(){
                  if(this.id[0] == 'b'){
                    beforefile = this.id;
                  }
                  if(this.id[0] == 'a'){
                    afterfile = this.id;
                  }
                })
                if(beforefile == '' || afterfile == ''){
                  alert('Please Select Before File AND After File');
                  return;
                }

                if (lanestocompare == ''){
                  alert('Please Select Lanes to Compare');
                  return;
                }

              }
              var queryString = "?distances=" + distances + "&option=" + option + "&id=" + id + "&usbcoption=" + usbcoption + "&beforefile=" + beforefile + "&afterfile=" + afterfile + "&lanestocompare=" + lanestocompare;
              ajaxRequest.open("GET", "trigger.php" + queryString, true);
              ajaxRequest.send(null);
            }



    }

    function filterdashboard(filename){
      ajaxRequest = new XMLHttpRequest();
      ajaxRequest.onreadystatechange = function(){
        if(ajaxRequest.readyState == 4){

          var status = ajaxRequest.responseText;
          //alert(status);
           $('#MainContent').load('dashboard.php #MainContent');

        }
      }

      var queryString = "?filter=" + filename;
      ajaxRequest.open("GET", "setfilter.php" + queryString, true);
      ajaxRequest.send(null);
    }

    function removefilter(){
      ajaxRequest = new XMLHttpRequest();
      ajaxRequest.onreadystatechange = function(){
        if(ajaxRequest.readyState == 4){

          var status = ajaxRequest.responseText;
          //alert(status);
           $('#MainContent').load('dashboard.php #MainContent');

        }
      }

      var queryString = "?filter=";
      ajaxRequest.open("GET", "setfilter.php" + queryString, true);
      ajaxRequest.send(null);
    }

    $(document).ready(
     function() {
     setInterval(function() {

      $('#MainContent').load('dashboard.php #MainContent');
     }, 5000);  //Delay here = 5 seconds
    });

  </script>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 style="display:none" class="modal-title" id="exampleModalLabel">File ID</h5>
          <h5>Select Report</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <label class="input-group-text" style="background-color:#f90; color:black; font-weight:bold;" for="inputGroupSelect01">Options</label>
              </div>
              <select class="custom-select" id="inputGroupSelect01">
                <option selected>Choose...</option>
                <option value="1">Lane Guide only Report</option>
                <option value="2">Lane Guide Report with cover</option>
                <option value="3">Lane map Only Report</option>
                <option value="4">Lane map With Cover Report</option>
                <option value="5">Export All Readings to excel</option>
                <option value="6">Reports for USBC (Wood)</option>
                <option value="7">Reports for USBC (Synthetic)</option>
                <option value="8">Reports for USBC (Multi)</option>
                <option value="9">Export All USBC readings for all lanes to excel</option>
                <option value="10">Before and After Comparison</option>
              </select>
            </div>

            <div class="input-group mb-3" id="woodoptions" style="display:none">
              <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-sm">Choose 3 Distances</span>
              </div>
              <input id="distances3" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="15,30,50" value="">
            </div>

            <div class="input-group mb-3" id="syntheticoptions" style="display:none">
              <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-sm">Choose 5 Distances</span>
              </div>
              <input id="distances5" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="15,20,31,42,55" value="">
            </div>

            <div id="beforefile" style="margin-top:20px;">
              <p style="font-weight:bold; color:#36454f;">Before File</P>
                <?php
                $db = new mysqli('127.0.0.1' , 'root' , 'KegelRoot' , 'lanemapper');
                mysqli_set_charset($db, "utf8");
                  if (mysqli_connect_errno()){
                    echo 'Error In Database Connection';
                    exit;
                  }
                $db->select_db('uploads');
                $query = "SELECT id,filename FROM uploads WHERE company='".$companyNoSpaces."' order by id desc";
                $result = mysqli_query($db,$query) or die(mysqli_error());
                $num_rows = mysqli_num_rows($result);
                  if($num_rows > 0){
                    while($row = mysqli_fetch_assoc($result)){

                      $id = $row['id'];
                      $filename = $row['filename'];
                      ?>
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="<?php echo 'b'. $filename; ?>">
                        <label class="custom-control-label" for="<?php echo 'b'. $filename; ?>"><?php echo $filename; ?></label>
                      </div>

                      <?php

                    }
                  }
                $db->close();
                ?>
            </div>



            <div id="afterfile" style="margin-top:20px;">
              <p style="font-weight:bold; color:#36454f;">After File</P>
                <?php
                $db = new mysqli('127.0.0.1' , 'root' , 'KegelRoot' , 'lanemapper');
                mysqli_set_charset($db, "utf8");
                  if (mysqli_connect_errno()){
                    echo 'Error In Database Connection';
                    exit;
                  }
                $db->select_db('uploads');
                $query = "SELECT id,filename FROM uploads WHERE company='".$companyNoSpaces."' order by id desc";
                $result = mysqli_query($db,$query) or die(mysqli_error());
                $num_rows = mysqli_num_rows($result);
                  if($num_rows > 0){
                    while($row = mysqli_fetch_assoc($result)){

                      $id = $row['id'];
                      $filename = $row['filename'];
                      ?>
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="<?php echo 'a'.$filename; ?>">
                        <label class="custom-control-label" for="<?php echo 'a'.$filename; ?>"><?php echo $filename; ?></label>
                      </div>

                      <?php

                    }
                  }
                $db->close();
                ?>
            </div>

            <div class="input-group mb-3" id="lanescomparison" style="display:none; margin-top:20px;">


              <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-sm">Choose Lanes To Compare</span>
              </div>
              <input id="lanestocompare" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="15,20,30,38,49" value="">

            </div>



          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" style="background-color:#36454f;" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" style="background-color:#36454f; color:#f90; border-color:#36454f; font-weight:bold;" onclick="triggerLaneMapper()">Request Report</button>
        </div>
      </div>
    </div>
  </div>

  <div class="card text-center h-100">
    <div class="card-header" style="background-color: #f90; font-weight:bold;">
          <img src="images/black.png" class="rounded" alt="LaneMapper" style="width:30px; height:auto;">
          <br>
          KEGEL | Lane Mapper
    </div>

          <nav class="navbar justify-content-center" style="background-color:#f90; ">

            <ul class="nav nav-pills" style="color:black;">
              <li class="nav-item" >
                <a class="nav-link active" href="dashboard.php" style="color:#f90; background-color:#36454f; font-weight:bold">Dashboard</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="upload.php" style="font-weight:bold; color:#36454f">Upload New</a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" style="font-weight:bold; color:#36454f" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <?php echo $company; ?>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <?php
                    if($admin == 1){
                      ?>
                  <a class="dropdown-item" style="font-weight:bold;"href="adminpanel.php">Administrator Dashboard</a>
                      <?php
                    }
                  ?>
                  <a class="dropdown-item" style="font-weight:bold;"href="myaccount.php">My Account</a>
                  <a class="dropdown-item" style="font-weight:bold;"href="#">Contact Us</a>
                  <a class="dropdown-item" style="font-weight:bold;"href="logout.php">Log out</a>
                </div>
              </li>

            </ul>
          </nav>
    

    <div class="card-body" style=" background-color:#36454f; color:white;">
      <div class="container">
        <section  class="login-form">
          <form  onsubmit="return false;"  role="login">
            <p style="font-weight:bold;">Uploaded Files</p>
            <div id="MainContent">
            <table  class="table table-sm ">

              <thead >
                <tr>
                  <th scope="col">File ID</th>
                  <th scope="col">Filename</th>
                  <th scope="col">Uploaded On</th>
                  <th scope="col"></th>
                </tr>
              </thead>
              <tbody>
                <?php
                  $db = new mysqli('127.0.0.1' , 'root' , 'KegelRoot' , 'lanemapper');
                  mysqli_set_charset($db, "utf8");
                    if (mysqli_connect_errno()){
                      echo 'Error In Database Connection';
                      exit;
                    }
                  $db->select_db('users');
                  $query = "SELECT id,filename,uploadedon FROM uploads WHERE company='".$companyNoSpaces."' order by id desc";
                  $result = mysqli_query($db,$query) or die(mysqli_error());
                  $num_rows = mysqli_num_rows($result);
                    if($num_rows > 0){
                      while($row = mysqli_fetch_assoc($result)){

                        $id = $row['id'];
                        $filename = $row['filename'];
                        $uploadedon = $row['uploadedon'];
                        $phpdate = strtotime( $uploadedon );
                        ?>
                        <tr>
                          <th style="width: 10%" scope="row"><?php echo $id; ?></th>
                          <td style="width: 40%"><a href="#" onclick="filterdashboard('<?php echo $id;?>')" style="color:#f90; font-weight:bold;"><?php echo $filename; ?></a></td>
                          <td style="width: 25%"><?php echo date("F j, Y @ g:i A",$phpdate); ?></td>
                          <td ><a href="#" style="color:#f90; font-weight:bold;" data-toggle="modal" data-target="#exampleModal" data-whatever="<?php echo $id ?>" >Request Report</a></td>
                        </tr>
                        <?php
                      }
                    }
                  $db->close();
                ?>
                  </tbody>
                </table>


                <?php
                  foreach(glob($reportpath.'/*.*') as $file) {

                    $db = new mysqli('127.0.0.1' , 'root' , 'KegelRoot' , 'lanemapper');
                    mysqli_set_charset($db, "utf8");
                      if (mysqli_connect_errno()){
                        echo 'Error In Database Connection';
                        exit;
                      }
                    $db->select_db('reports');
                    $query = "UPDATE reports SET status='Ready' WHERE path_report='". $file ."'";
                    if(mysqli_query($db,$query)){
                      //Query Executed Properly...
                    }else {

                      printf("Errormessage: %s\n", mysqli_error($db));
                    }
                    $db->close();
                  }

                  if($filter != ""){
                    ?>
                    <p style="margin-top:100px; font-weight:bold;">Requested Reports (Filter by File ID: <?php echo $filter; ?> | <a href="#" onclick="removefilter()" style="color:#f90;font-weight:bold;">Remove Filter</a> )</p>

                    <?php

                  }else{
                    ?>
                    <p style="margin-top:100px; font-weight:bold;">Requested Reports</p>
                    <?php
                  }
                 ?>


                <table class="table table-sm">
                  <thead>
                    <tr>
                      <th scope="col">File ID</th>
                      <th scope="col">Report Name</th>
                      <th scope="col">Requested On</th>
                      <th scope="col">Status</th>
                      <th scope="col"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php

                      if($filter == ""){
                        $query = "SELECT * FROM reports WHERE company='".$company."' order by id desc";
                      }else{
                        $query = "SELECT * FROM reports WHERE company='".$company."' AND file_id=".$filter." order by id desc";
                      }

                      $db = new mysqli('127.0.0.1' , 'root' , 'KegelRoot' , 'lanemapper');
                      mysqli_set_charset($db, "utf8");
                        if (mysqli_connect_errno()){
                          echo 'Error In Database Connection';
                          exit;
                        }
                      $db->select_db('reports');

                      $result = mysqli_query($db,$query) or die(mysqli_error());
                      $num_rows = mysqli_num_rows($result);
                        if($num_rows > 0){
                          while($row = mysqli_fetch_assoc($result)){
                            $id = $row['id'];
                            $filename = $row['report_name'];
                            $status = $row['status'];
                            $pathtofile = $row['path_report'];
                            $requestedOn = $row['requested_on'];
                            $phpdate = strtotime( $requestedOn );
                            ?>
                            <tr>
                              <th style="width: 10%" scope="row"><?php echo $id; ?></th>
                              <td style="width: 40%"><?php echo $filename; ?></td>
                              <td style="width: 25%"><?php echo date("F j, Y @ g:i A",$phpdate);?></td>
                              <td style=" font-weight: bold;<?php if($status == 'Processing'){ echo 'color:red;';}else{ echo 'color:green;';} ?>"><?php echo $status; ?></td>
                              <?php if($status != 'Processing'){?>
                              <td ><a href="<?php echo $pathtofile ?>" onclick="reportdownload('<?php echo $filename; ?>')" style="color:#f90;font-weight:bold;">Download Report</a></td>
                              <?php }?>
                            </tr>
                            <?php
                          }
                        }
                      $db->close();
                    ?>
                      </tbody>
                    </table>
                  </div>
              </form>


            </section>

      </div>
    </div>
      <div class="card-footer" style="background-color: #f90; font-weight:bold; text-align:center;">
        CALL CENTER: USA TOLL FREE: (800) 280 BOWL (2695)
        <br>
        Phone: +1 (863) 734 0200 | Fax: +1 (863) 734 0204
        <br>
        1951 Longleaf Blvd. Lake Wales, FL 33859 USA
        <br>
        <img src="images/black.png" class="rounded" alt="LaneMapper" style="width:90px; height:auto;">
      </div>
    </div>





</body>

</html>



<script>
$('#exampleModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var recipient = button.data('whatever') // Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this)
  modal.find('.modal-title').text(recipient)

})
</script>

<script>
$('.custom-control-input').on('change', function() {
   if($('.custom-control-input:checked').length > 2) {
       this.checked = false;
   }
});

$(function() {
    $('#distances3').on('keypress', function(e) {
        if (e.which == 32)
            return false;
    });
});

$(function() {
    $('#distances5').on('keypress', function(e) {
        if (e.which == 32)
            return false;
    });
});
</script>

<script>
$( "select" )
  .change(function() {
    var str = "";
    $( "select option:selected" ).each(function() {
      str += $( this ).text();
    });
    $("#syntheticoptions").hide();
    $("#woodoptions").hide();
    $("#lanescomparison").hide();
    $("#beforefile").hide();
    $("#afterfile").hide();
    $("#selectedfile1").hide();
    $("#selectedfile2").hide();

    if(str == 'Reports for USBC (Wood)'){
      $("#woodoptions").show();
    }

    if(str == 'Reports for USBC (Synthetic)' || str == 'Reports for USBC (Multi)'){
      $("#syntheticoptions").show();
    }

    if(str == 'Before and After Comparison'){
      $("#beforefile").show();
      $("#afterfile").show();
      $("#lanescomparison").show();
      $("#selectedfile1").show();
      $("#selectedfile2").show();
    }


    //dosomething

  })
  .trigger( "change" );
</script>





<?php




    // error_reporting(E_ALL);
    //
    // /* Add redirection so we can get stderr. */
    // $handle = popen('C:\WindowsApplication1.exe 2>&1', 'r');
    // echo "'$handle'; " . gettype($handle) . "\n";
    // $read = fread($handle, 2096);
    // echo $read;
    // pclose($handle);
?>
