<?php
session_start();

if(!isset($_SESSION['userid'])){
  header('Location: login.php');
}
require_once('classes/log.php');
session_start();
$firstname = $_SESSION['fname'];
$lastname = $_SESSION['lname'];
$company = $_SESSION['company'];
$filedownloaded = $_GET['download'];

$log = new log();
$log->setCompany($company);
$log->setUserFname($firstname);
$log->setUserLname($lastname);
$log->setInformation('User Downloaded a Report. Report= '.$filedownloaded);
$log->setType('REQUEST');
$log->save();
?>
