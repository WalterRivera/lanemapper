<html lang="en">
<?php
session_start();

if(!isset($_SESSION['userid'])){
  header('Location: login.php');
}

$id = $_SESSION['userid'];
$email = $_SESSION['email'];
$firstname = $_SESSION['fname'];
$lastname = $_SESSION['lname'];
$company = $_SESSION['company'];

?>

<?php require('headers.php'); ?>
<head>
  <link rel="stylesheet" href="css/logincss.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">

<head>
<body>
  <div class="card text-center">
    <div class="card-header" style="background-color: #f90; font-weight:bold;">
          <img src="images/black.png" class="rounded" alt="LaneMapper" style="width:30px; height:auto;">
          <br>
          KEGEL | Lane Mapper
    </div>

    <nav class="navbar justify-content-center" style="background-color:#f90;">
      <ul class="nav nav-pills" style="color:black;">
        <li class="nav-item" >
          <a class="nav-link" href="dashboard.php" style="font-weight:bold; color:#36454f">Dashboard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link"  href="upload.php" style="font-weight:bold; color:#36454f">Upload New</a>
        </li>
        <li class="nav-item dropdown active">
          <a class="nav-link dropdown-toggle" style="color:#f90; background-color:#36454f; font-weight:bold" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?php echo $company ?>
          </a>
          <div class="dropdown-menu " aria-labelledby="navbarDropdown">
            <a class="dropdown-item" style="font-weight:bold;" href="myaccount.php">My Account</a>
            <a class="dropdown-item" style="font-weight:bold;"href="#">Contact Us</a>
            <a class="dropdown-item" style="font-weight:bold;"href="logout.php">Log out</a>
          </div>
        </li>
      </ul>
    </nav>


    <div class="card-body" style="background-color:#36454f; color:white;">

      <div class="row" >



      <div class="col-md-2">
      </div>

      <div class="col-md-8">
        <div class="container">
          <section  class="login-form">
            <form class="needs-validation" enctype='multipart/form-data' novalidate onsubmit="return false" role="login">
              <div class="row" >



              <div class="col-md-1">
              </div>

              <div class="col-md-5">
                <p style="font-weight:bold;">Options</p><br>
                <a href="#" style="color:#f90; font-weight:bold;">Change Account Information</a><br>
                <a href="#" style="color:#f90; font-weight:bold;">Change Password</a>

              </div>

              <div class="col-md-5" >
                <p style="font-weight:bold;">Account Information</p>
                <fieldset disabled>
                <div class="form-group">
                  <label for="someinfo" style="float:left;font-weight:bold;">Company</label>
                  <input type="text" class="form-control" id="Company" aria-describedby="emailHelp" placeholder="Company" value="<?php  echo $company; ?>">
                </div>

                <div class="form-group">
                  <label for="someinfo" style="float:left;font-weight:bold;">First Name</label>
                  <input type="text" class="form-control" id="First Name" aria-describedby="emailHelp" placeholder="First Name" value="<?php  echo $firstname; ?>">
                </div>

                <div class="form-group">
                  <label for="someinfo" style="float:left;font-weight:bold;">Last Name</label>
                  <input type="text" class="form-control" id="Last Name" aria-describedby="emailHelp" placeholder="Last Name" value="<?php  echo $lastname; ?>">
                </div>

                <div class="form-group">
                  <label for="someinfo" style="float:left;font-weight:bold;">Email</label>
                  <input type="text" class="form-control" id="Email" aria-describedby="emailHelp" placeholder="Email" value="<?php  echo $email; ?>">
                </div>
              </fieldset>

              <div class="col-md-1">
              </div>

            </div>

          </form>
        </section  class="login-form">
      </div class="container">


      </div>

      <div class="col-md-2">
      </div>

      </div>
    </div>

  <div class="card-footer" style="background-color: #f90; font-weight:bold; ">
    CALL CENTER: USA TOLL FREE: (800) 280 BOWL (2695)
    <br>
    Phone: +1 (863) 734 0200 | Fax: +1 (863) 734 0204
    <br>
    1951 Longleaf Blvd. Lake Wales, FL 33859 USA
    <br>
    <img src="images/black.png" class="rounded" alt="LaneMapper" style="width:90px; height:auto;">
  </div>

</body>

</html>



<script>



  $('#xmlfile').on('change',function(){
      //get the file name
      var fileName = $(this).val();
      //replace the "Choose a file" label
      $(this).next('.custom-file-label').html(fileName);
  })

  $('#logofile').on('change',function(){
      //get the file name
      var fileName = $(this).val();
      //replace the "Choose a file" label
      $(this).next('.custom-file-label').html(fileName);
  })


</script>

<script>
// Example starter JavaScript for disabling form submissions if there are invalid fields
(function() {
  'use strict';
  window.addEventListener('load', function() {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission

    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }else{
          upload();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();


function upload(){
  var headAreaReplace = "";
  $( "select option:selected" ).each(function() {
    headAreaReplace += $( this ).text();
  });

  var reportTitle = document.getElementById('reportTitle').value;

  var reportLocation = document.getElementById('reportLocation').value;
  var NumberLanes = document.getElementById('NumberLanes').value;
  var laneSurface = document.getElementById('laneSurface').value;
  var laneSurfaceYearInstallation = document.getElementById('laneSurfaceYearInstallation').value;
  var lanesurfacelevelers = document.getElementById('laneSurfacelevelers').value;
  var Underlaymentyear = document.getElementById('underlaymentYearInstallation').value;
  var pinDecks = document.getElementById('pinDecks').value;
  var pinsetters = document.getElementById('pinsetters').value;
  var scoreSystem = document.getElementById('scoreSystem').value;


  var querystring = "?rt=" + reportTitle + "&rl=" + reportLocation + "&nl=" + NumberLanes +
  "&ls=" + laneSurface + "&lsyi=" + laneSurfaceYearInstallation + "&har=" + headAreaReplace + "&pd=" + pinDecks +
  "&ps=" + pinsetters + "&ss=" + scoreSystem + "&lsl=" + lanesurfacelevelers + "&uly=" + Underlaymentyear;


   const url = 'process.php' + querystring;
  // const form = document.querySelector('input');
  //
   const files = document.querySelector('[type=file]').files;
  // const formData = new FormData();
  // alert(files.length);
  //
  // for (let i = 0; i < files.length; i++) {
  //     let file = files[i];
  //
  //
  //     formData.append('files[]', file);
  // }

  var file = $("#xmlfile").prop("files")[0];
  var logo = $("#logofile").prop("files")[0];
  var formData = new FormData();
  formData.append("files[]", file);
  formData.append("files[]", logo);


  fetch(url, {
      method: 'POST',
      body: formData
  }).then(response => {
    if (response.status === 422) {
      $("#wrong-format").show();

    }else{
      $("#wrong-format").hide();
      window.location.href = "dashboard.php";
    }
      //alert(response.status);

  });
}
</script>

<?php

    // $cmd = 'WindowsApplication1.exe -t Lanes:1-10 add sjasdw';
    //
    //
    // if (substr(php_uname(), 0, 7) == "Windows"){
    //     pclose(popen("start /B ". $cmd, "r"));
    //     echo "Program Executed on Windows Environment...";
    //     echo "<br>";
    // }
    // else {
    //     exec($cmd . " > /dev/null &");
    //     echo 'Program Executed on Linux Environment...\r\n';
    // }
    //
    // echo 'An Email Will Reach you shortly.'


    // error_reporting(E_ALL);
    //
    // /* Add redirection so we can get stderr. */
    // $handle = popen('C:\WindowsApplication1.exe 2>&1', 'r');
    // echo "'$handle'; " . gettype($handle) . "\n";
    // $read = fread($handle, 2096);
    // echo $read;
    // pclose($handle);
?>
