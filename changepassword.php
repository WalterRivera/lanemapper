<?php
session_start();

require_once('classes/log.php');
$email = $_SESSION['email'];
$oldpassword = $_GET['old'];
$newpassword = $_GET['new'];
$company = $_SESSION['company'];
$firstname = $_SESSION['fname'];
$lastname = $_SESSION['lname'];

$log = new log();
$log->setCompany($company);
$log->setUserFname($firstname);
$log->setUserLname($lastname);


$db = new mysqli('localhost' , 'root' , '' , 'lanemapper');
mysqli_set_charset($db, "utf8");
  if (mysqli_connect_errno()){
    echo 'Error In Database Connection';
    exit;
  }
$db->select_db('users');
$query = "SELECT password FROM users WHERE email='".$email."' and access=1  limit 1";
$result = mysqli_query($db,$query) or die(mysqli_error());
$num_rows = mysqli_num_rows($result);
  if($num_rows > 0){
    $row = mysqli_fetch_assoc($result);
    $truepassword =$row['password'];
  }
$db->close();


if(password_verify($oldpassword, $truepassword)){
  $db = new mysqli('localhost' , 'root' , '' , 'lanemapper');
  mysqli_set_charset($db, "utf8");
    if (mysqli_connect_errno()){
      echo 'Error In Database Connection';
      exit;
    }
  $db->select_db('users');
  $newpassword = password_hash($newpassword, PASSWORD_DEFAULT);
  $query = "UPDATE users SET password='".$newpassword."' WHERE email='". $email ."'";
  if(mysqli_query($db,$query)){
    if(mysqli_affected_rows($db)>0){
      echo 'ok';
      $log->setInformation('User Change Password Succesfully.');
      $log->setType('PASSWORD-CHANGE-SUCCESFULLY');
      $log->save();
    }else{
      echo 'e';
      $log->setInformation('User Try to Change Password Unsuccesfully.');
      $log->setType('PASSWORD-CHANGE-UNSUCCESFULLY');
      $log->save();
    }
  }else {

    printf("Errormessage: %s\n", mysqli_error($db));
  }
  $db->close();
}else{
  echo 'e';
  $log->setInformation('User Try to Change Password Unsuccesfully.');
  $log->setType('PASSWORD-CHANGE-UNSUCCESFULLY');
  $log->save();
}












?>
