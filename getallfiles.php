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
$name = $_GET['company'];


if($admin != 1){
  header('Location: dashboard.php');
}

?>
<label for="someinfo" style="float:left;font-weight:bold;">Select file to link report</label>
<select class="custom-select" id="filesinput"  >
<option selected>Choose...</option>

<?php

$db = new mysqli('127.0.0.1' , 'root' , 'KegelRoot' , 'lanemapper');
mysqli_set_charset($db, "utf8");
  if (mysqli_connect_errno()){
    echo 'Error In Database Connection';
    exit;
  }

  $db->select_db('uploads');
  $query = "SELECT id,filename FROM uploads WHERE company=REPLACE((SELECT company FROM companies WHERE id= ".$name."),' ','_') order by id DESC";
  $result = mysqli_query($db,$query) or die(mysqli_error());
  $num_rows = mysqli_num_rows($result);
    if($num_rows > 0){
      while($row = mysqli_fetch_assoc($result)){
      ?>
        <option value="<?php echo $row['id']; ?>"><?php echo $row['filename']; ?></option>
      <?php

      }
    }
  $db->close();


  ?>


</select>
