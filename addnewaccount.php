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
  $requested_on = date("Y-m-d H:i:s");

  $query = "insert into companies (`id`, `company`, `address`, `added_on`)
            values
            (NULL, '$name', '$address', '$requested_on')";
  if(mysqli_query($db,$query)){
    include_once('classes/log.php');
    $log = new log();
    $log->setCompany($company);
    $log->setUserFname($firstname);
    $log->setUserLname($lastname);
    $log->setInformation('Admin Add New Company. Company= '.$name);
    $log->setType('ADMIN-ADD-ACCOUNT');
    $log->save();
    echo "ok";
  }else{
    printf("Errormessage: %s\n", mysqli_error($db));

  }




?>
