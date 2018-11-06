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
$fname = $_GET['fname'];
$lname = $_GET['lname'];
$email = $_GET['email'];
$password = $_GET['password'];
$lanemapperadmin = $_GET['mapperadmin'];
$accountadmin = $_GET['accountadmin'];

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
  $password = password_hash($password, PASSWORD_DEFAULT);
  $query = "insert into users (`id`, `company`, `email`, `first_name`, `last_name`, `access`,  `password`, `is_admin`, `is_account_admin`)
            values
            (NULL, (SELECT company FROM companies WHERE id=".$name."), '$email', '$fname', '$lname', (SELECT access FROM companies WHERE id=".$name." ) , '$password' , $lanemapperadmin, $accountadmin)";
  if(mysqli_query($db,$query)){

    $log->setInformation('ADMIN ADD NEW USER');
    $log->setType('SUCCESS');
    $log->save();
    echo 'ok';

  }else{
    printf("Errormessage: %s\n", mysqli_error($db));

  }
  $db->close();

?>
