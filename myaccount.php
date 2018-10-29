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

<script language="javascript" type="text/javascript">

  function submitchangepassword(){
    var beforepass = $("#beforepass").val();
    var newpass = $("#newpass").val();
    var newpass2 = $("#newpass2").val();
    $("#passerror").text("");
    $("#passok").text("");
    $("#passerror").hide();
    $("#passok").hide();

    if(newpass == '' || newpass2 == '' || beforepass == ''){
      $("#passerror").text("Need to Fill all Passwords Information");
      $("#passerror").show();
      return;
    }

    if(newpass != newpass2){
      $("#passerror").text("New Password Does Not Match Confirmation Password");
      $("#passerror").show();
      return;
    }

    ajaxRequest = new XMLHttpRequest();
    ajaxRequest.onreadystatechange = function(){
      if(ajaxRequest.readyState == 4){

        var status = ajaxRequest.responseText;
        //alert(status);
        if(status != 'ok'){
          $("#passerror").text("Wrong old Password.");
          $("#passerror").show();
        }else{
          $("#passok").text("Password Changed Succesfully.");
          $("#passok").show();
        }
      }
    }

    var queryString = "?old=" + beforepass + "&new=" + newpass;
    ajaxRequest.open("GET", "changepassword.php" + queryString, true);
    ajaxRequest.send(null);
  }

  function showchangepassword(){
    $("#changepass").show();
  }


</script>

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
                <a href="#" onclick="showchangepassword()" style="color:#f90; font-weight:bold;">Change Password</a>

                <div id="changepass" style="margin-top:50px; display:none;">
                  <div class="form-group">
                    <label for="someinfo" style="float:left;font-weight:bold;">Old Password</label>
                    <input type="password" class="form-control" id="beforepass" aria-describedby="emailHelp" >
                  </div>

                  <div class="form-group">
                    <label for="someinfo" style="float:left;font-weight:bold;">New Password</label>
                    <input type="password" class="form-control" id="newpass" aria-describedby="emailHelp" >
                  </div>

                  <div class="form-group">
                    <label for="someinfo" style="float:left;font-weight:bold;">New Password Confirmation</label>
                    <input type="password" class="form-control" id="newpass2" aria-describedby="emailHelp" >
                  </div>

                  <div class="form-group">
                    <label for="someinfo" id="passerror" style="float:left;font-weight:bold; color:red; display:none;"></label>
                    <label for="someinfo" id="passok" style="float:left;font-weight:bold; color:green; display:none;"></label>
                  </div>

                  <div class="form-group">
                      <button class="btn btn-primary btn-lg btn-block" onclick="submitchangepassword()" type="submit" style="font-weight:bold; background-color: #f90; border-color: #f90; color:black; margin-top:10px;" >Change Password</button>
                  </div>

                </div>


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

              </div>

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
