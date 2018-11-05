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
$admin = $_SESSION['admin'];
$name = $_GET['company'];
$nameid = $_GET['id'];
$address = $_GET['address'];
$address2 = $_GET['address2'];
$country = $_GET['country'];
$state = $_GET['state'];
$city = $_GET['city'];
$postal = $_GET['postal'];

$log = new log();
$log->setCompany($company);
$log->setUserFname($firstname);
$log->setUserLname($lastname);

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
$query = "UPDATE companies set company='".$name."', address='".$address."', address_line_2='".$address2."',
Country='".$country."',state='".$state."',city='".$city."',postalcode='".$postal."' WHERE id = ".$nameid;
if(mysqli_query($db,$query)){
  echo 'ok';
  $log->setInformation('Admin UPDATE Account. Account= '.$name);
  $log->setType('ADMIN-UPDATE-ACCOUNT');
  $log->save();

}else{

  printf("Errormessage: %s\n", mysqli_error($db));
}
$db->close();


?>
