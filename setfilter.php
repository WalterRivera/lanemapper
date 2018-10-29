<?php
$filter = $_GET['filter'];
session_start();
$_SESSION['filter'] = $filter;

include_once('classes/log.php');
$firstname = $_SESSION['fname'];
$lastname = $_SESSION['lname'];
$company = $_SESSION['company'];

$log = new log();
$log->setCompany($company);
$log->setUserFname($firstname);
$log->setUserLname($lastname);
$log->setInformation('User Filtered Requested Reports. Filter= '.$filter);
$log->setType('FILTER');
$log->save();

?>
