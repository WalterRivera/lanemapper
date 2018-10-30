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
$name = $_GET['name'];

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
$query = "UPDATE companies c INNER JOIN users u ON (c.company = u.company) SET c.access = 0,u.access = 0 WHERE c.company = '".$name."' and u.company ='".$name."'";
if(mysqli_query($db,$query)){
  echo 'ok';
  $log->setInformation('Admin Disable Account. Account= '.$name);
  $log->setType('ADMIN-DISABLE-ACCOUNT');
  $log->save();

}else{

  printf("Errormessage: %s\n", mysqli_error($db));
}
$db->close();




?>
