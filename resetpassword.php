<?php
session_start();

if(!isset($_SESSION['userid'])){
  header('Location: login.php');
}

require_once('classes/log.php');
require_once('sendmail.php');


$id = $_SESSION['userid'];
$email = $_SESSION['email'];
$firstname = $_SESSION['fname'];
$lastname = $_SESSION['lname'];
$company = $_SESSION['company'];
$admin = $_SESSION['admin'];
$userid = $_GET['userid'];
$useremail = $_GET['email'];
$newpassword = generateRandomString(20);
$newpasswordencrypted = password_hash($newpassword, PASSWORD_DEFAULT);
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
$query = "UPDATE users set require_new_password=1,password='".$newpasswordencrypted."' WHERE id =".$userid;
if(mysqli_query($db,$query)){
  if (sendpasswordreset($useremail,$newpassword)){
    echo 'ok';
    $log->setInformation('Admin Reset account password. user= '.$userid);
    $log->setType('ADMIN-RESTE-PASSWORD');
    $log->save();
  }
}else{

  printf("Errormessage: %s\n", mysqli_error($db));
}
$db->close();



function generateRandomString($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


?>
