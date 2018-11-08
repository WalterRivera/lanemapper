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
$access = $_GET['access'];
$userid = $_GET['userid'];

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
$db->select_db('users');
$query = "UPDATE users set access='".$access."' WHERE id = ".$userid;
if(mysqli_query($db,$query)){
  echo 'ok';
  $log->setInformation('Admin UPDATE access to user. user ID= '.$userid);
  $log->setType('ADMIN-UPDATE-ACCESS');
  $log->save();

}else{

  printf("Errormessage: %s\n", mysqli_error($db));
}
$db->close();


?>
