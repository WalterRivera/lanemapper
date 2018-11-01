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
$admin = $_SESSION['admin'];

if($admin != 1){
  header('Location: dashboard.php');
}

?>

<?php require('headers.php'); ?>

<script language="javascript" type="text/javascript">

  function showsearchresult(selection){
    ajaxRequest = new XMLHttpRequest();
    ajaxRequest.onreadystatechange = function(){
      if(ajaxRequest.readyState == 4){

        var status = ajaxRequest.responseText;
        var data = $.parseJSON(status);
        $("#searchcompany").text(data.company);
        $("#searchaddress").text(data.address);
        $("#searchadded").text(data.addedon);
        if(data.access == 1){
          $("#searchaccess").text("Yes");
        }else{
          $("#searchaccess").text("No");
        }

        $("#searchusers").text(data.users);
        $("#searchreports").text(data.reports);
        $("#searchuploads").text(data.uploads);

        $("#searchresult").show();

      }
    }

    var queryString = "?selection=" + selection.value;
    ajaxRequest.open("GET", "searchaccount.php" + queryString, true);
    ajaxRequest.send(null);
  }

  function removeaccount(enable){
    var option = '';
    $( "select option:selected" ).each(function() {
      option = $( this ).text();
    });

    if(option == '' || option == 'Choose...'){
      $("#removeaccounterror").text("Select an account to disable");
      $("#removeaccounterror").show();
      return;
    }

    ajaxRequest = new XMLHttpRequest();
    ajaxRequest.onreadystatechange = function(){
      if(ajaxRequest.readyState == 4){

        var status = ajaxRequest.responseText;
        //alert(status);
        if(status != 'ok'){
          $("#removeaccounterror").text("Could not disable account.");
          $("#removeaccounterror").show();
        }else{
          $("#removeaccountok").text("Account was disable Succesfully");
          $("#removeaccountok").show();
        }
        
      }
    }

    var queryString = "?name=" + option + "&enable=" + enable;
    ajaxRequest.open("GET", "removeaccount.php" + queryString, true);
    ajaxRequest.send(null);


  }

  function addnewaccount(){
    $("#addaccountok").hide();
    $("#addaccounterror").hide();
    var accountname = $("#addaccountname").val();
    var accountaddress = $("#addaccountaddress").val();

    if(accountname == '' || accountaddress == ''){
      $("#addaccounterror").text("No empty fields are allowed.");
      $("#addaccounterror").show();
      return;
    }

    ajaxRequest = new XMLHttpRequest();
    ajaxRequest.onreadystatechange = function(){
      if(ajaxRequest.readyState == 4){

        var status = ajaxRequest.responseText;
        //alert(status);
        if(status != 'ok'){
          $("#addaccounterror").text("Could not add account. Verify for duplicates.");
          $("#addaccounterror").show();
        }else{
          $("#addaccountok").text("Account was created Succesfully");
          $("#addaccountok").show();
          $("#addaccountname").val("");
          $("#addaccountaddress").val("");
        }
      }
    }

    var queryString = "?name=" + accountname + "&address=" + accountaddress;
    ajaxRequest.open("GET", "addnewaccount.php" + queryString, true);
    ajaxRequest.send(null);

  }


  function showform(option){
    $("#addaccount").hide();
    $("#addaccounterror").hide();


    $("#modifyaccount").hide();
    $("#removeaccount").hide();
    $("#searchaccount").hide();


    if(option == 'addaccount'){
      $("#addaccount").show();
    }

    if(option == 'modifyaccount'){
      $("#modifyaccount").show();
    }

    if(option == 'removeaccount'){
      $("#removeaccount").show();
    }

    if(option == 'searchaccount'){
      $("#searchaccount").show();
    }






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


    <div class="card-body" style="background-color:#36454f; color:white;">

      <div class="row" >



      <div class="col-md-1">
      </div>

      <div class="col-md-10">
        <div class="container">
          <section  class="login-form">
            <form class="needs-validation" enctype='multipart/form-data' novalidate onsubmit="return false" role="login">
              <div class="row"  >


              <div class="col-md-4">
                <div class="card">
                  <div class="card-header" style="color:#36454f; background-color:#f90; font-weight:bold">
                    Client Administration
                  </div>
                  <div class="card" >
                    <ul class="list-group list-group-flush">
                      <li class="list-group-item"><a href="#" onclick="showform('addaccount')" style="color:#36454f; font-weight:bold;">Add Account</a></li>
                      <li class="list-group-item"><a href="#" onclick="showform('modifyaccount')" style="color:#36454f; font-weight:bold;">Modify Account</a></li>
                      <li class="list-group-item"><a href="#" onclick="showform('removeaccount')" style="color:#36454f; font-weight:bold;">Disable Account</a></li>
                      <li class="list-group-item"><a href="#" onclick="showform('searchaccount')" style="color:#36454f; font-weight:bold;">Search Account</a></li>
                    </ul>
                  </div>
                  <div class="card-header" style="color:#36454f; background-color:#f90; font-weight:bold">
                    User Administration
                  </div>
                  <div class="card" >
                    <ul class="list-group list-group-flush">
                      <li class="list-group-item"><a href="#" onclick="" style="color:#36454f; font-weight:bold;">Add User</a></li>
                      <li class="list-group-item"><a href="#" onclick="" style="color:#36454f; font-weight:bold;">Modify User</a></li>
                      <li class="list-group-item"><a href="#" onclick="" style="color:#36454f; font-weight:bold;">Remove User</a></li>
                      <li class="list-group-item"><a href="#" onclick="" style="color:#36454f; font-weight:bold;">Search User</a></li>
                    </ul>
                  </div>
                </div>



              </div>



              <div class="col-md-8" >
                <div id="addaccount" style="display:none;">
                  <p style="font-weight:bold;">Add New Account</p>

                  <div class="form-group">
                    <label for="someinfo" style="float:left;font-weight:bold;">Account Name</label>
                    <input type="text" class="form-control" id="addaccountname" aria-describedby="emailHelp" >
                  </div>

                  <div class="form-group">
                    <label for="someinfo" style="float:left;font-weight:bold;">Address</label>
                    <input type="text" class="form-control" id="addaccountaddress" aria-describedby="emailHelp" >
                  </div>

                  <div class="form-group">
                      <button class="btn btn-primary btn-lg btn-block" onclick="addnewaccount()" type="submit" style="font-weight:bold; background-color: #f90; border-color: #f90; color:black; margin-top:10px;" >Add New Account</button>
                  </div>

                  <div class="form-group">
                    <label for="someinfo" id="addaccounterror" style="float:left;font-weight:bold; color:red; display:none;"></label>
                    <label for="someinfo" id="addaccountok" style="float:left;font-weight:bold; color:green; display:none;"></label>
                  </div>
                </div>

                <div id="modifyaccount" style="display:none;">
                  <p style="font-weight:bold;">Modify Account</p>

                  <div class="form-group">
                    <label for="someinfo" style="float:left;font-weight:bold;">Choose Account</label>
                    <select class="custom-select" id="inputGroupSelect01">
                      <option selected>Choose...</option>
                      <?php require('getallcompanies.php'); ?>
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="someinfo" style="float:left;font-weight:bold;">Account Name</label>
                    <input type="text" class="form-control" id="beforepass" aria-describedby="emailHelp" >
                  </div>

                  <div class="form-group">
                    <label for="someinfo" style="float:left;font-weight:bold;">Address</label>
                    <input type="text" class="form-control" id="beforepass" aria-describedby="emailHelp" >
                  </div>

                  <div class="form-group">
                      <button class="btn btn-primary btn-lg btn-block" onclick="" type="submit" style="font-weight:bold; background-color: #f90; border-color: #f90; color:black; margin-top:10px;" >Modify Account</button>
                  </div>

                  <div class="form-group">
                    <label for="someinfo" id="modifyaccounterror" style="float:left;font-weight:bold; color:red; display:none;"></label>
                    <label for="someinfo" id="modifyaccountok" style="float:left;font-weight:bold; color:green; display:none;"></label>
                  </div>
                </div>

                <div id="removeaccount" style="display:none;">
                  <p style="font-weight:bold;">Disable Account</p>

                  <div class="form-group">
                    <label for="someinfo" style="float:left;font-weight:bold;">Choose Account</label>
                    <select class="custom-select" id="inputGroupSelect01">
                      <option selected>Choose...</option>
                      <?php require('getallcompanies.php'); ?>
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="someinfo" style="float:left;font-weight:bold;">* Disabling account will disable access to all users from that company.</label>

                  </div>

                  <div class="form-group">
                      <button class="btn btn-primary btn-lg btn-block" onclick="removeaccount(0)" type="submit" style="font-weight:bold; background-color: #f90; border-color: #f90; color:black; margin-top:10px;" >Remove Account</button>
                  </div>

                  <div class="form-group">
                    <label for="someinfo" id="removeaccounterror" style="float:left;font-weight:bold; color:red; display:none;"></label>
                    <label for="someinfo" id="removeaccountok" style="float:left;font-weight:bold; color:green; display:none;"></label>
                  </div>
                </div>

                <div id="searchaccount" style="display:none;">
                  <p style="font-weight:bold;">Search Account</p>

                  <div class="form-group">
                    <label for="someinfo" style="float:left;font-weight:bold;">Choose Account</label>
                    <select class="custom-select" id="searchinput" onchange="showsearchresult(this)">
                      <option selected>Choose...</option>
                      <?php require('getallcompanies.php'); ?>
                    </select>


                    <div id="searchresult" class="card text-center" style="display:none;margin-top:20px; ">
                      <div class="card-header" style="color:#36454f; background-color:#f90; font-weight:bold;">
                        Account Details
                      </div>
                      <div class="card-body">

                        <div class="row">

                          <div class="col-md-12">
                            <div class="card bg-light mb-4" style="max-width: 100%;color:#36454f; font-weight:bold;">
                              <div class="card-header">Company</div>
                              <div class="card-body">
                                <h5 id="searchcompany" class="card-title"></h5>
                              </div>
                            </div>
                          </div>


                        </div>

                        <div class="row">

                          <div class="col-md-12">
                            <div class="card bg-light mb-4" style="max-width: 100%;color:#36454f; font-weight:bold;">
                              <div class="card-header">Address</div>
                              <div class="card-body">
                                <h5 id="searchaddress" class="card-title"></h5>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="row">

                          <div class="col-md-12">
                            <div class="card bg-light mb-4" style="max-width: 100%;color:#36454f; font-weight:bold;">
                              <div class="card-header">Created On</div>
                              <div class="card-body">
                                <h5 id="searchadded" class="card-title"></h5>
                              </div>
                            </div>
                          </div>


                        </div>

                        <div class="row">

                          <div class="col-md-8">
                            <div class="card bg-light mb-4" style="max-width: 100%;color:#36454f; font-weight:bold;">
                              <div class="card-header">Access</div>
                              <div class="card-body">
                                <h5 id="searchaccess" class="card-title"></h5>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <a href="#" onclick="removeaccount(1)" style="color:#36454f; font-weight:bold;">Enable Account</a><br>
                            <a href="#" onclick="removeaccount(0)" style="color:#36454f; font-weight:bold;">Disable Account</a>
                          </div>

                        </div>

                        <div class="row">

                          <div class="col-md-8">
                            <div class="card bg-light mb-4" style="max-width: 100%;color:#36454f; font-weight:bold;">
                              <div class="card-header">Users</div>
                              <div class="card-body">
                                <h5 id="searchusers" class="card-title"></h5>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <a href="#" onclick="" style="color:#36454f; font-weight:bold;">Add User</a><br>
                            <a href="#" onclick="" style="color:#36454f; font-weight:bold;">Disable User</a>
                          </div>

                        </div>

                        <div class="row">

                          <div class="col-md-8">
                            <div class="card bg-light mb-4" style="max-width: 100%;color:#36454f; font-weight:bold;">
                              <div class="card-header">Required Reports</div>
                              <div class="card-body">
                                <h5 id="searchreports" class="card-title"></h5>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <a href="#" onclick="" style="color:#36454f; font-weight:bold;">Upload Report</a><br>
                            <a href="#" onclick="" style="color:#36454f; font-weight:bold;">View Reports</a>
                          </div>

                        </div>

                        <div class="row">

                          <div class="col-md-8">
                            <div class="card bg-light mb-4" style="max-width: 100%;color:#36454f; font-weight:bold;">
                              <div class="card-header">Uploaded Files</div>
                              <div class="card-body">
                                <h5 id="searchuploads" class="card-title"></h5>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <a href="#" onclick="" style="color:#36454f; font-weight:bold;">Upload Files</a><br>
                            <a href="#" onclick="" style="color:#36454f; font-weight:bold;">View Files</a>
                          </div>

                        </div>


                      </div>

                  </div>

                  </div>
                </div>

              </div>
            </div>
          </form>
        </section  class="login-form">
      </div class="container">


      </div>

      <div class="col-md-1">
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
