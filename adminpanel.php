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


  function uploadreport(){
    var company = $("#searchinput option:selected").text();
    var fileid = $("#filesinput").val();

    if(fileid == '' || fileid == 'Choose...'){
      alert('Select a file to associate with the report.')
      return;
    }

    var querystring = "?company=" + company + "&fileid=" + fileid;


     const url = 'adminuploadreport.php' + querystring;

     const files = document.querySelector('[type=file]').files;


    var file = $("#pdffile").prop("files")[0];

    var formData = new FormData();
    formData.append("files[]", file);



    fetch(url, {
        method: 'POST',
        body: formData
    }).then(response => {
      if (response.status === 422) {
        $("#correct-format").hide();
        $("#wrong-format").show();

      }else{
        $("#wrong-format").hide();
        $("#correct-format").show();

      }
        //alert(response.status);

    });
  }


  function changeuseraccess(access,userid){
    ajaxRequest = new XMLHttpRequest();
    ajaxRequest.onreadystatechange = function(){
      if(ajaxRequest.readyState == 4){

        var status = ajaxRequest.responseText;
        //alert(status);
        if(status != 'ok'){

        }else{
          var company = $("#searchinput").val();
          $("#modaldisableuserbody").load("showusertodisable.php?company="+ company);
        }
      }
    }

    var queryString = "?access=" + access + "&userid=" + userid ;
    ajaxRequest.open("GET", "changeuseraccess.php" + queryString, true);
    ajaxRequest.send(null);
  }

  $(window).on('shown.bs.modal', function() {

      var company = $("#searchinput").val();
      $("#modaldisableuserbody").load("showusertodisable.php?company="+ company);

      $("#modaluploadreportbody").load("getallfiles.php?company="+ company);

      $("#modalviewreportsbody").load("showreports.php?company="+ company);

      $("#modalviewfilebody").load("showfiles.php?company="+ company);

  });

  function adduser(){
    $("#addusererror").hide();
    $("#addusersuccess").hide();
    var company = $("#searchinput").val();
    var fname = $("#adduserfname").val();
    var lname = $("#adduserlname").val();
    var email = $("#adduseremail").val();
    var password = $("#adduserpassword").val();
    var password2 = $("#adduserpassword2").val();
    var accountadmin = $("#adduseraccountadmin").is(":checked");
    var lanemapperadmin = $("#addusermapperadmin").is(":checked");

    if(company == '' || fname == '' || lname == '' || email == '' || password == '' || password2 == ''){
      $("#addusererror").show();
      $("#addusererrorinfo").text("All inputs must have information.");
      return;
    }

    if(password != password2){
      $("#addusererror").show();
      $("#addusererrorinfo").text("Passwords does not match.");
      return;
    }

    ajaxRequest = new XMLHttpRequest();
    ajaxRequest.onreadystatechange = function(){
      if(ajaxRequest.readyState == 4){

        var status = ajaxRequest.responseText;
        //alert(status);
        if(status != 'ok'){
          $("#addusererror").show();
          $("#addusererrorinfo").text("Cannot add user. Verify that email is not duplicated.");
        }else{
          $("#addusersuccess").show();
          $("#addusersuccessinfo").text("User Added Succesfully.");
          $("#searchinput").val("");
          $("#adduserfname").val("");
          $("#adduserlname").val("");
          $("#adduseremail").val("");
          $("#adduserpassword").val("");
          $("#adduserpassword2").val("");
          $("#adduseraccountadmin").prop('checked', false);
          $("#addusermapperadmin").prop('checked', false);
        }
      }
    }

    var queryString = "?company=" + company + "&fname=" + fname + "&lname=" + lname + "&email=" + email
    + "&password=" + password + "&mapperadmin=" + lanemapperadmin + "&accountadmin=" + accountadmin;
    ajaxRequest.open("GET", "adduser.php" + queryString, true);
    ajaxRequest.send(null);


  }



  function showmode(){
    input = jQuery('<button id="editbtn" class="btn btn-primary btn-lg btn-block" style="margin-top:35px;float:left;" onclick="editmode()"> <i class="fa fa-pencil"></i></button>');
    jQuery('#editbuttonarea').append(input);
    jQuery('#savebtn').remove();

    var company = jQuery("#searcheditcompany").val();
    $("#searchcompany").text(company);
    jQuery('#searcheditcompany').remove();

    var address = jQuery("#searcheditaddress").val();
    $("#searchaddress").text(address);
    jQuery('#searcheditaddress').remove();

    var address2 = jQuery("#searcheditaddress2").val();
    $("#searchaddress2").text(address2);
    jQuery('#searcheditaddress2').remove();

    var country = jQuery("#searcheditcountry").val();
    $("#searchcountry").text(country);
    jQuery('#searcheditcountry').remove();

    var state = jQuery("#searcheditstate").val();
    $("#searchstate").text(state);
    jQuery('#searcheditstate').remove();

    var city = jQuery("#searcheditcity").val();
    $("#searchcity").text(city);
    jQuery('#searcheditcity').remove();

    var postal = jQuery("#searcheditpostal").val();
    $("#searchpostal").text(postal);
    jQuery('#searcheditpostal').remove();

    var oldcompany = $("#searchinput").val();

    if(company == '' || address == '' || country == '' || state == '' || city == '' || postal == '' ){

      alert("Error, Information is missing");
      return;
    }

    ajaxRequest = new XMLHttpRequest();
    ajaxRequest.onreadystatechange = function(){
      if(ajaxRequest.readyState == 4){

        var status = ajaxRequest.responseText;
        //alert(status);
        if(status != 'ok'){
          alert('Error, Update could not be performed');
        }else{

        }
      }
    }

    var queryString = "?company=" + company + "&address=" + address + "&address2=" + address2 +
    "&country=" + country + "&state=" + state + "&city=" + city + "&postal=" + postal + "&id=" + oldcompany;
    ajaxRequest.open("GET", "updateaccount.php" + queryString, true);
    ajaxRequest.send(null);

  }

  function editmode(){
    var company = $("#searchinput").val();
    if(company == '' || company == 'Choose...'){
      return;
    }
    input = jQuery('<button id="savebtn" class="btn btn-success btn-lg btn-block" style="margin-top:35px;float:left;" onclick="showmode()"> <i class="fa fa-check-circle"></i></button>');
    jQuery('#editbuttonarea').append(input);
    jQuery('#editbtn').remove();

    var company = $("#searchcompany").text();
    input = jQuery('<input type="text" class="form-control" id="searcheditcompany" aria-describedby="emailHelp" value="' + company + '" >');
    $("#searchcompany").text("");
    jQuery('#searchcompany').append(input);

    var address = $("#searchaddress").text();
    input = jQuery('<input type="text" class="form-control" id="searcheditaddress" aria-describedby="emailHelp" value="' + address + '" >');
    $("#searchaddress").text("");
    jQuery('#searchaddress').append(input);

    var address2 = $("#searchaddress2").text();
    input = jQuery('<input type="text" class="form-control" id="searcheditaddress2" aria-describedby="emailHelp" value="' + address2 + '" >');
    $("#searchaddress2").text("");
    jQuery('#searchaddress2').append(input);

    var country = $("#searchcountry").text();
    input = jQuery('<input type="text" class="form-control" id="searcheditcountry" aria-describedby="emailHelp" value="' + country + '" >');
    $("#searchcountry").text("");
    jQuery('#searchcountry').append(input);

    var state = $("#searchstate").text();
    input = jQuery('<input type="text" class="form-control" id="searcheditstate" aria-describedby="emailHelp" value="' + state + '" >');
    $("#searchstate").text("");
    jQuery('#searchstate').append(input);

    var city = $("#searchcity").text();
    input = jQuery('<input type="text" class="form-control" id="searcheditcity" aria-describedby="emailHelp" value="' + city + '" >');
    $("#searchcity").text("");
    jQuery('#searchcity').append(input);

    var postal = $("#searchpostal").text();
    input = jQuery('<input type="text" class="form-control" id="searcheditpostal" aria-describedby="emailHelp" value="' + postal + '" >');
    $("#searchpostal").text("");
    jQuery('#searchpostal').append(input);

  }

  function showsearchresult(selection){
    ajaxRequest = new XMLHttpRequest();
    ajaxRequest.onreadystatechange = function(){
      if(ajaxRequest.readyState == 4){

        var status = ajaxRequest.responseText;
        var data = $.parseJSON(status);
        $("#searchcompany").text(data.company);
        $("#searchaddress").text(data.address);
        $("#searchadded").text(data.addedon);
        $("#searchaddress2").text(data.address2);
        $("#searchcountry").text(data.country);
        $("#searchstate").text(data.state);
        $("#searchcity").text(data.city);
        $("#searchpostal").text(data.postal);
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


        }else{

          if(enable == 0){
            $("#searchaccess").text("No");
          }else{
            $("#searchaccess").text("Yes");
          }


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
    var accountaddress2 = $("#addaccountaddress2").val();
    var country = $("#countryselect").val();
    var state = $("#addaccountstate").val();
    var city = $("#addaccountcity").val();
    var postal = $("#addaccountpostal").val();


    if(accountname == '' || accountaddress == '' || country == 'Please Select a Country' || state == '' || city == '' || postal == ''){
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

    var queryString = "?name=" + accountname + "&address=" + accountaddress + "&address2=" + accountaddress2 +
    "&country=" + country + "&state=" + state + "&city=" + city + "&postal=" + postal;
    ajaxRequest.open("GET", "addnewaccount.php" + queryString, true);
    ajaxRequest.send(null);

  }


  function showform(option){
    $("#addaccount").hide();
    $("#addaccounterror").hide();



    $("#searchaccount").hide();


    if(option == 'addaccount'){
      $("#addaccount").show();
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

  <div class="modal fade" id="uploadreport" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" onload="adduserload()">
    <div class="modal-dialog modal-lg modal-dialog-centered " role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Disable Users</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <div id="modaluploadreportbody" class="form-group">


          </div>

          <div class="form-group" >

            <label for="someinfo" style="float:left; font-weight:bold; ">Upload PDF or Excel Reports</label>
            <div class="custom-file">
              <input type="file" class="custom-file-input" id="pdffile" name="pdffile" multiple required>
              <label class="custom-file-label" for="validatedCustomFile" >Choose file...</label>

              <div id="wrong-format" class="invalid-feedback" style="display:none; color:red; font-weight:bold;">
                Only PDF or Excel Files Will be Accepted
              </div>

              <div id="correct-format" class="invalid-feedback" style="display:none; color:green; font-weight:bold;">
                File uploaded
              </div>

            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger " data-dismiss="modal"><i class="fa fa-user-times"></i> Cancel</button>
          <button type="button" class="btn btn-success btn-block " onclick="uploadreport()" ><i class="fa fa-file-pdf-o"></i> Upload Files</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="viewfilesmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" onload="adduserload()">
    <div class="modal-dialog modal-lg modal-dialog-centered " role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">View uploaded Files</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div id="modalviewfilebody" class="modal-body">


        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger btn-block" data-dismiss="modal"><i class="fa fa-user-times"></i> Cancel</button>

        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="viewreportsmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" onload="adduserload()">
    <div class="modal-dialog modal-lg modal-dialog-centered " role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">View Reports</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div id="modalviewreportsbody" class="modal-body">


        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger btn-block" data-dismiss="modal"><i class="fa fa-user-times"></i> Cancel</button>

        </div>
      </div>
    </div>
  </div>



  <div class="modal fade" id="disableusermodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" onload="adduserload()">
    <div class="modal-dialog modal-lg modal-dialog-centered " role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Disable Users</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div id="modaldisableuserbody" class="modal-body">


        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger btn-block" data-dismiss="modal"><i class="fa fa-user-times"></i> Cancel</button>

        </div>
      </div>
    </div>
  </div>

    <!-- Modal Add User to company -->
  <div class="modal fade" id="addusermodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" onload="adduserload()">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Add User</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <div class="form-group">
            <label for="someinfo" style="float:left;font-weight:bold;">First Name</label>
            <input type="text" class="form-control" id="adduserfname" aria-describedby="emailHelp" >
          </div>

          <div class="form-group">
            <label for="someinfo" style="float:left;font-weight:bold;">Last Name</label>
            <input type="text" class="form-control" id="adduserlname" aria-describedby="emailHelp" >
          </div>

          <div class="form-group">
            <label for="someinfo" style="float:left;font-weight:bold;">Email</label>
            <input type="text" class="form-control" id="adduseremail" aria-describedby="emailHelp" >
          </div>

          <div class="form-group">
            <label for="someinfo" style="float:left;font-weight:bold;">Password</label>
            <input type="password" class="form-control" id="adduserpassword" aria-describedby="emailHelp" >
          </div>

          <div class="form-group">
            <label for="someinfo" style="float:left;font-weight:bold;">Confirm Password</label>
            <input type="password" class="form-control" id="adduserpassword2" aria-describedby="emailHelp" >
          </div>

          <div class="form-group" id="addusererror" style="display:none;">
            <label id="addusererrorinfo" for="someinfo" style="color:red;float:left;font-weight:bold;"></label><br>
          </div>

          <div class="form-group" id="addusersuccess" style="display:none;">
            <label id="addusersuccessinfo" for="someinfo" style="color:green;float:left;font-weight:bold;"></label><br>
          </div>

          <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="adduseraccountadmin">
            <label class="custom-control-label" for="adduseraccountadmin">Account Admin</label>
          </div>

          <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="addusermapperadmin">
            <label class="custom-control-label" for="addusermapperadmin">LaneMapper Admin</label>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-user-times"></i> Cancel</button>
          <button type="button" class="btn btn-success btn-block" onclick="adduser()"><i class="fa fa-user-plus"></i> Add Users</button>
        </div>
      </div>
    </div>
  </div>

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


                      <li class="list-group-item"><a href="#" onclick="showform('searchaccount')" style="color:#36454f; font-weight:bold;">Search Account</a></li>
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
                    <label for="someinfo" style="float:left;font-weight:bold;">Address Line 1</label>
                    <input type="text" class="form-control" id="addaccountaddress" aria-describedby="emailHelp" >
                  </div>

                  <div class="form-group">
                    <label for="someinfo" style="float:left;font-weight:bold;">Address Line 2</label>
                    <input type="text" class="form-control" id="addaccountaddress2" aria-describedby="emailHelp" >
                  </div>

                  <div class="form-group">
                    <label for="someinfo" style="float:left;font-weight:bold;">Country</label>
                    <select class="custom-select" id="countryselect">
                      <option selected>Please Select a Country</option>
                      <?php require('getallcountries.php'); ?>
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="someinfo" style="float:left;font-weight:bold;">State / Province / Region</label>
                    <input type="text" class="form-control" id="addaccountstate" aria-describedby="emailHelp" >
                  </div>

                  <div class="form-group">
                    <label for="someinfo" style="float:left;font-weight:bold;">City / Town</label>
                    <input type="text" class="form-control" id="addaccountcity" aria-describedby="emailHelp" >
                  </div>

                  <div class="form-group">
                    <label for="someinfo" style="float:left;font-weight:bold;">Zip / Postal Code</label>
                    <input type="text" class="form-control" id="addaccountpostal" aria-describedby="emailHelp" >
                  </div>


                  <div class="form-group">
                      <button class="btn btn-primary btn-lg btn-block" onclick="addnewaccount()" type="submit" style="font-weight:bold; background-color: #f90; border-color: #f90; color:black; margin-top:10px;" >Add New Account</button>
                  </div>

                  <div class="form-group">
                    <label for="someinfo" id="addaccounterror" style="float:left;font-weight:bold; color:red; display:none;"></label>
                    <label for="someinfo" id="addaccountok" style="float:left;font-weight:bold; color:green; display:none;"></label>
                  </div>
                </div>

                <div id="searchaccount" style="display:none;">
                  <p style="font-weight:bold;">Search Account</p>

                  <div class="form-group">


                    <div class="row">

                      <div class="col-md-8">
                        <label for="someinfo" style="float:left;font-weight:bold;">Choose Account</label>
                        <select class="custom-select" id="searchinput" onchange="showsearchresult(this)" >
                          <option selected>Choose...</option>
                          <?php require('getallcompanies.php'); ?>
                        </select>
                      </div>
                      <div id="editbuttonarea" class="col-md-4">
                        <button id="editbtn" class='btn btn-primary btn-lg btn-block ' style="margin-top:33px;float:left;" onclick="editmode()">
                           <i class="fa fa-pencil"></i>
                        </button>
                      </div>
                    </div>


                    <div id="searchresult" class="card text-center" style="display:none;margin-top:20px; ">
                      <div class="card-header" style="color:#36454f; background-color:#f90; font-weight:bold;">
                        Account Details
                      </div>
                      <div class="card-body">

                        <div class="row">

                          <div class="col-md-12">
                            <div class="card bg-light mb-4" style="max-width: 100%;color:#36454f; font-weight:bold;">
                              <div class="card-header">Company

                              </div>
                              <div class="card-body">
                                <h5 id="searchcompany" class="card-title"></h5>
                              </div>
                            </div>
                          </div>


                        </div>

                        <div class="row">

                          <div class="col-md-6">
                            <div class="card bg-light mb-4" style="max-width: 100%;color:#36454f; font-weight:bold;">
                              <div class="card-header">Address Line 1</div>
                              <div class="card-body">
                                <h5 id="searchaddress" class="card-title"></h5>
                              </div>
                            </div>
                          </div>

                          <div class="col-md-6">
                            <div class="card bg-light mb-4" style="max-width: 100%;color:#36454f; font-weight:bold;">
                              <div class="card-header">Address Line 2</div>
                              <div class="card-body">
                                <h5 id="searchaddress2" class="card-title"></h5>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="row">

                          <div class="col-md-6">
                            <div class="card bg-light mb-4" style="max-width: 100%;color:#36454f; font-weight:bold;">
                              <div class="card-header">Country</div>
                              <div class="card-body">
                                <h5 id="searchcountry" class="card-title"></h5>
                              </div>
                            </div>
                          </div>

                          <div class="col-md-6">
                            <div class="card bg-light mb-4" style="max-width: 100%;color:#36454f; font-weight:bold;">
                              <div class="card-header">State / Region</div>
                              <div class="card-body">
                                <h5 id="searchstate" class="card-title"></h5>
                              </div>
                            </div>
                          </div>

                          <div class="col-md-6">
                            <div class="card bg-light mb-4" style="max-width: 100%;color:#36454f; font-weight:bold;">
                              <div class="card-header">City</div>
                              <div class="card-body">
                                <h5 id="searchcity" class="card-title"></h5>
                              </div>
                            </div>
                          </div>

                          <div class="col-md-6">
                            <div class="card bg-light mb-4" style="max-width: 100%;color:#36454f; font-weight:bold;">
                              <div class="card-header">Postal Code</div>
                              <div class="card-body">
                                <h5 id="searchpostal" class="card-title"></h5>
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
                            <button id="editbtn" class='btn btn-dark  btn-block '  onclick="removeaccount(1)">
                               <i class="fa fa-plus"></i> Enable Account
                            </button>
                            <button id="editbtn" class='btn btn-dark  btn-block '  onclick="removeaccount(0)">
                               <i class="fa fa-minus"></i> Disable Account
                            </button>

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
                            <button id="adduser" class='btn btn-dark  btn-block '  data-toggle="modal" data-target="#addusermodal">
                               <i class="fa fa-user-plus"></i> Add User
                            </button>
                            <button id="disableuser" class='btn btn-dark  btn-block '  data-toggle="modal" data-target="#disableusermodal">
                               <i class="fa fa-user"></i> Enable/Disable User
                            </button>
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
                            <button id="adduser" class='btn btn-dark  btn-block '  data-toggle="modal" data-target="#uploadreport">
                               <i class="fa fa-upload"></i> Upload Report
                            </button>
                            <button id="disableuser" class='btn btn-dark  btn-block ' data-toggle="modal" data-target="#viewreportsmodal">
                               <i class="fa fa-file-pdf-o"></i> View Reports
                            </button>
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
                            <button id="disableuser" class='btn btn-dark  btn-block '  data-toggle="modal" data-target="#viewfilesmodal">
                               <i class="fa fa-files-o"></i> View Files
                            </button>
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
</div>

</body>

<script>

  $('#pdffile').on('change',function(){
      //get the file name
      var fileName = $(this).val();
      //replace the "Choose a file" label
      $(this).next('.custom-file-label').html(fileName);
  })



</script>
