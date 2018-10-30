<?php
require_once('classes/log.php');
$email = $_GET['email'];
$password = $_GET['password'];


$id = 0;

$db = new mysqli('127.0.0.1' , 'root' , 'KegelRoot' , 'lanemapper');
mysqli_set_charset($db, "utf8");
  if (mysqli_connect_errno()){
    echo 'Error In Database Connection';
    exit;
  }
$db->select_db('users');
$query = "SELECT * FROM users WHERE email='".$email."' and access=1  limit 1";
$result = mysqli_query($db,$query) or die(mysqli_error());
$num_rows = mysqli_num_rows($result);
  if($num_rows > 0){
    $row = mysqli_fetch_assoc($result);
    $id = $row['id'];
    $admin = $row['is_admin'];
    $email = $row['email'];
    $firstname = $row['first_name'];
    $lastname = $row['last_name'];
    $company = $row['company'];
    $truepassword =$row['password'];
  }
$db->close();

  if($id > 0 && $id != "Error In Database Connection" && password_verify($password, $truepassword) == true){
    session_start();
    $_SESSION['userid'] = $id;
    $_SESSION['email'] = $email;
    $_SESSION['fname'] = $firstname;
    $_SESSION['lname'] = $lastname;
    $_SESSION['company'] = $company;
    $_SESSION['admin'] = $admin;

    $log = new log();
    $log->setCompany($company);
    $log->setUserFname($firstname);
    $log->setUserLname($lastname);
    $log->setInformation('User login Successfully.');
    $log->setType('LOGIN');
    $log->save();
  }else{
    $id = 0;
    $log = new log();
    $log->setCompany('');
    $log->setUserFname('');
    $log->setUserLname('');
    $log->setInformation('User Failed Authentication Proccess. Email used = '.$email .' Password used = '.$password);
    $log->setType('LOGIN-FAILED');
    $log->save();

  }

  echo $id;

?>
