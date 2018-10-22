<html lang="en">

<?php require('headers.php'); ?>
<head>
  <link rel="stylesheet" href="css/logincss.css">
<head>

<body>



  <script language="javascript" type="text/javascript">
    function verifyCredentials(){
        var email = document.getElementById('email').value;
        var password = document.getElementById('password').value;
        ajaxRequest = new XMLHttpRequest();
        ajaxRequest.onreadystatechange = function(){
          if(ajaxRequest.readyState == 4){

            var id = ajaxRequest.responseText;
            if (id == 0 || id == "Error In Database Connection"){
              $("#loginError").show();
            }else{
              $("#loginError").hide();
              document.location = "dashboard.php";
            }

          }
        }


            if (email == "" || password == ""){
              $("#loginError").show();
            }else{
              var queryString = "?email=" + email + "&password=" + password ;
              ajaxRequest.open("GET", "checkcredentials.php" + queryString, true);
              ajaxRequest.send(null);
            }


    }
  </script>


  <div class="card text-center h-100">
    <div class="card-header" style="background-color: #f90; font-weight:bold;">
          <img src="images/black.png" class="rounded" alt="LaneMapper" style="width:30px; height:auto;">
          <br>
          KEGEL | Lane Mapper
    </div>
    <div class="card-body" style="background-color:#545454; color:white;">


        <div class="container">

          <div class="row" >
            <div class="col-md-4"></div>

            <div class="col-md-4">
              <section class="login-form">
                <form onsubmit="return false;"  role="login">
                  <img src="images/1.png" class="img-responsive" style="width:100px; height:auto;" alt="" />
                  <input type="email" id="email" name="email" placeholder="Email"  class="form-control input-lg"  />

                  <input type="password" class="form-control input-lg" id="password" placeholder="Password"  />


                  <div id="loginError" style="display:none; color:red; font-weight:bold;">
                    Username or Password is Incorrect.
                  </div>


                  <button onclick="verifyCredentials()"  class="btn btn-lg btn-primary btn-block" style="background-color: #f90; border-color:#f90; color:black; font-weight:bold;">Login</button>
                  <div>
                    <!-- <a href="#" style="color:#f90; font-weight:bold;">Reset Password</a> -->
                  </div>

                </form>


              </section>
              </div>

              <div class="col-md-4"></div>


          </div>



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
