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
$userid = $_GET['userid'];
$account = $_GET['account'];
$mapper = $_GET['mapper'];

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
$query = "UPDATE users set is_account_admin=".$account.", is_admin = ".$mapper." WHERE id = ".$userid;
if(mysqli_query($db,$query)){
  echo 'ok';
  $log->setInformation('Admin UPDATE ADMIN PRIVILEGES to user. user ID= '.$userid);
  $log->setType('ADMIN-UPDATE-ADMIN-PRIV');
  $log->save();

}else{

  printf("Errormessage: %s\n", mysqli_error($db));
}
$db->close();


?>
