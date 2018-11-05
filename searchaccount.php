<?php
session_start();
header( "Content-type: application/json" );

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
$companyid = $_GET['selection'];

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
$query = "SELECT *, (SELECT Count(*) FROM reports WHERE company = companies.company) as Treports, (SELECT Count(*) FROM uploads WHERE company = REPLACE(companies.company, ' ', '_')) as Tuploads, (SELECT Count(*) FROM users WHERE company = companies.company) as Tusers FROM companies WHERE companies.id =".$companyid;
$result = mysqli_query($db,$query) or die(mysqli_error());
$num_rows = mysqli_num_rows($result);
    $row = mysqli_fetch_assoc($result);
    $showcompany = $row['company'];
    $showaddress = $row['address'];
    $showaddress2 = $row['address_line_2'];
    $showcountry = $row['Country'];
    $showstate = $row['state'];
    $showcity = $row['city'];
    $showpostal = $row['postalcode'];
    $showadded = $row['added_on'];
    $showaccess = $row['access'];
    $showtreports = $row['Treports'];
    $showTuploads = $row['Tuploads'];
    $showTusers = $row['Tusers'];
$db->close();

$jsonAnswer = array('company' => $showcompany,
'address' => $showaddress,
'addedon' => $showadded,
'access' => $showaccess,
'reports' => $showtreports,
'uploads' => $showTuploads,
'users' => $showTusers,
'address2' => $showaddress2,
'country' => $showcountry,
'state' => $showstate,
'city' => $showcity,
'postal' => $showpostal
);
echo json_encode($jsonAnswer);

?>
