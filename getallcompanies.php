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
$name = $_GET['name'];
$address = $_GET['address'];

if($admin != 1){
  header('Location: dashboard.php');
}

$db = new mysqli('127.0.0.1' , 'root' , 'KegelRoot' , 'lanemapper');
mysqli_set_charset($db, "utf8");
  if (mysqli_connect_errno()){
    echo 'Error In Database Connection';
    exit;
  }

  $db->select_db('companies');
  $query = "SELECT id,company FROM companies order by company ASC";
  $result = mysqli_query($db,$query) or die(mysqli_error());
  $num_rows = mysqli_num_rows($result);
    if($num_rows > 0){
      while($row = mysqli_fetch_assoc($result)){
      ?>
        <option value="<?php echo $row['id']; ?>"><?php echo $row['company']; ?></option>
      <?php
      
      }
    }
  $db->close();




?>
