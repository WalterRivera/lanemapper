<?php


$email = $_GET['email'];
$password = $_GET['password'];
$id = 0;

$db = new mysqli('localhost' , 'root' , '' , 'lanemapper');
mysqli_set_charset($db, "utf8");
  if (mysqli_connect_errno()){
    echo 'Error In Database Connection';
    exit;
  }
$db->select_db('users');
$query = "SELECT * FROM users WHERE email='".$email."' and password='".$password. "' and access=1  limit 1";
$result = mysqli_query($db,$query) or die(mysqli_error());
$num_rows = mysqli_num_rows($result);
  if($num_rows > 0){
    $row = mysqli_fetch_assoc($result);
    $id = $row['id'];
    $email = $row['email'];
    $firstname = $row['first_name'];
    $lastname = $row['last_name'];
    $company = $row['company'];
  }
$db->close();

  if($id > 0 && $id != "Error In Database Connection"){
    session_start();
    $_SESSION['userid'] = $id;
    $_SESSION['email'] = $email;
    $_SESSION['fname'] = $firstname;
    $_SESSION['lname'] = $lastname;
    $_SESSION['company'] = $company;
  }

  echo $id;

?>
