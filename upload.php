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
          <a class="nav-link active" style="color:#f90; background-color:#36454f; font-weight:bold" href="upload.php" style="font-weight:bold; color:#36454f">Upload New</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" style="font-weight:bold; color:#36454f" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?php echo $company ?>
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" style="font-weight:bold;" href="#">My Account</a>
            <a class="dropdown-item" style="font-weight:bold;"href="#">Contact Us</a>
            <a class="dropdown-item" style="font-weight:bold;"href="logout.php">Log out</a>
          </div>
        </li>
      </ul>
    </nav>


    <div class="card-body" style="background-color:#36454f; color:white;">


      <div class="row" style="margin-top:10px;">

        <div class="col-md-4"></div>

        <div class="col-md-4">
            <img src="images/lanemapper.png" class="rounded" alt="LaneMapper" style="width:300px; height:auto;">
        </div>

        <div class="col-md-4"></div>

    </div>

      <div class="row" style="margin-top:30px;">



      <div class="col-md-4">
      </div>

      <div class="col-md-4">
        <form class="needs-validation" enctype='multipart/form-data' novalidate onsubmit="return false">

          <div class="form-group" >
            <label for="someinfo" style="float:left;">Upload Lane Mapper XML File</label>
            <div class="custom-file">
              <input type="file" class="custom-file-input" id="xmlfile" name="xmlfile" multiple required>
              <label class="custom-file-label" for="validatedCustomFile" >Choose file...</label>

              <div id="wrong-format" class="invalid-feedback" style="display:none; color:#f90; font-weight:bold;">
                Only XML Files Will be Accepted
              </div>

            </div>
          </div>



          <div class="form-group">
            <label for="someinfo" style="float:left;">Upload Logo</label>
            <div class="custom-file">
              <input type="file" class="custom-file-input" id="logofile" name="logofile" multiple>
              <label class="custom-file-label" for="validatedCustomFile" >Choose Logo...</label>

            </div>
          </div>

          <div class="form-group">
            <label for="someinfo" style="float:left;">Report Title</label>
            <input type="text" class="form-control"  id="reportTitle" aria-describedby="emailHelp" placeholder="Topography Report" required>
            <div class="invalid-feedback" style="color:#f90; font-weight:bold;">
              Report Title Required
            </div>
          </div>

          <div class="form-group">
            <label for="someinfo" style="float:left;">Report Date</label>
            <input type="text" class="form-control" id="reportDate" aria-describedby="emailHelp" placeholder="MM/DD/YYYY" required>
            <div class="invalid-feedback" style="color:#f90; font-weight:bold;">
              Report Date Required
            </div>
          </div>

          <div class="form-group">
            <label for="someinfo" style="float:left;">Report Location</label>
            <input type="text" class="form-control" id="reportLocation" aria-describedby="emailHelp" placeholder="Lake Wales, FL" required>
            <div class="invalid-feedback" style="color:#f90; font-weight:bold;">
              Location Required
            </div>
          </div>

          <div class="form-group">
            <label for="someinfo" style="float:left;">Number of Lanes</label>
            <input type="text" class="form-control" id="NumberLanes" aria-describedby="emailHelp" placeholder="32" required>
            <div class="invalid-feedback" style="color:#f90; font-weight:bold;">
              Number of Lanes Required
            </div>
          </div>

          <div class="form-group">
            <label for="someinfo" style="float:left;">Lane Surface</label>
            <input type="text" class="form-control" id="laneSurface" aria-describedby="emailHelp" placeholder="Wood" required>
            <div class="invalid-feedback" style="color:#f90; font-weight:bold;">
              Lane Surface Required
            </div>
          </div>

          <div class="form-group">
            <label for="someinfo" style="float:left;">Lane Surface Year of Installation</label>
            <input type="text" class="form-control" id="laneSurfaceYearInstallation" aria-describedby="emailHelp" placeholder="2000" required>
            <div class="invalid-feedback" style="color:#f90; font-weight:bold;">
              Year of Installation Required
            </div>
          </div>

          <div class="form-group">
            <label for="someinfo" style="float:left;">Lane Surface Levelers and Underlayment</label>
            <input type="text" class="form-control" id="laneSurfacelevelers" aria-describedby="emailHelp" placeholder="Wood" required>
            <div class="invalid-feedback" style="color:#f90; font-weight:bold;">
              Lane Surface Levelers and Underlayment Required
            </div>
          </div>

          <div class="form-group">
            <label for="someinfo" style="float:left;">Underlayment Year Installation</label>
            <input type="text" class="form-control" id="underlaymentYearInstallation" aria-describedby="emailHelp" placeholder="2000" required>
            <div class="invalid-feedback" style="color:#f90; font-weight:bold;">
              Underlayment Year Installation required
            </div>
          </div>

          <div class="form-group">
            <label for="someinfo" style="float:left;">Head Area Replace</label>

            <div class="input-group mb-4">
              <div class="input-group-prepend">
                <label class="input-group-text" style="background-color:#f90; color:black; font-weight:bold;" for="inputGroupSelect01">Options</label>
              </div>
              <select class="custom-select" id="inputGroupSelect01">

                <option value="1">True</option>
                <option selected value="2">False</option>
              </select>
          </div>

          <div class="form-group">
            <label for="someinfo" style="float:left;">Pin Decks</label>
            <input type="text" class="form-control" id="pinDecks" aria-describedby="emailHelp" placeholder="DBA" required>
            <div class="invalid-feedback" style="color:#f90; font-weight:bold;">
              Pin Decks Required
            </div>
          </div>

          <div class="form-group">
            <label for="someinfo" style="float:left;">Pinsetters</label>
            <input type="text" class="form-control" id="pinsetters" aria-describedby="emailHelp" placeholder="AMF" required>
            <div class="invalid-feedback" style="color:#f90; font-weight:bold;">
              Pinsetters Required
            </div>
          </div>

          <div class="form-group">
            <label for="someinfo" style="float:left;">Score System</label>
            <input type="text" class="form-control" id="scoreSystem" aria-describedby="emailHelp" placeholder="Qubica" required>
            <div class="invalid-feedback" style="color:#f90; font-weight:bold;">
              Score System Required
            </div>
          </div>


          <button class="btn btn-primary btn-lg btn-block" type="submit"  style="font-weight:bold; background-color: #f90; border-color: #f90; color:black; float:right;" >Next</button>
      </form>
      </div>
      </div>

      <div class="col-md-4">
      </div>

      </div>
      <div class="card-footer" style="background-color: #f90; font-weight:bold; margin-top:20px;">
        CALL CENTER: USA TOLL FREE: (800) 280 BOWL (2695)
        <br>
        Phone: +1 (863) 734 0200 | Fax: +1 (863) 734 0204
        <br>
        1951 Longleaf Blvd. Lake Wales, FL 33859 USA
        <br>
        <img src="images/black.png" class="rounded" alt="LaneMapper" style="width:90px; height:auto;">
      </div>

    </div>

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
  var reportDate = document.getElementById('reportDate').value;
  var reportLocation = document.getElementById('reportLocation').value;
  var NumberLanes = document.getElementById('NumberLanes').value;
  var laneSurface = document.getElementById('laneSurface').value;
  var laneSurfaceYearInstallation = document.getElementById('laneSurfaceYearInstallation').value;
  var lanesurfacelevelers = document.getElementById('laneSurfacelevelers').value;
  var Underlaymentyear = document.getElementById('underlaymentYearInstallation').value;
  var pinDecks = document.getElementById('pinDecks').value;
  var pinsetters = document.getElementById('pinsetters').value;
  var scoreSystem = document.getElementById('scoreSystem').value;


  var querystring = "?rt=" + reportTitle + "&rd=" + reportDate + "&rl=" + reportLocation + "&nl=" + NumberLanes +
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
      console.log(response);

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
