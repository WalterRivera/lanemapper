<?php
$uploaded = false;
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

$log = new log();

$log->setCompany($company);
$log->setUserFname($firstname);
$log->setUserLname($lastname);

$company = str_replace(' ', '_', $company);
$reportTitle = $_GET['rt'];
$reportLocation = $_GET['rl'];
$numberLanes = $_GET['nl'];
$laneSurface = $_GET['ls'];
$laneSurfaceYearInstallation = $_GET['lsyi'];
$headAreaReplace = $_GET['har'];
$pinDecks = $_GET['pd'];
$pinsetters = $_GET['ps'];
$scoreSystem = $_GET['ss'];
$laneSurfaceLevelers = $_GET['lsl'];
$underlaymentYear = $_GET['uly'];
$accessDatabase = true;




if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['files'])) {
        $errors = [];
        $path = 'uploads/';
        $extensions = ['jpg', 'jpeg', 'png', 'xml', 'XML'];

        $all_files = count($_FILES['files']['tmp_name']);

        for ($i = 0; $i < $all_files; $i++) {
            $file_name = $_FILES['files']['name'][$i];
            $file_tmp = $_FILES['files']['tmp_name'][$i];
            $file_type = $_FILES['files']['type'][$i];
            $file_size = $_FILES['files']['size'][$i];
            $file_ext = strtolower(end(explode('.', $_FILES['files']['name'][$i])));
            $file_name_toSave = $file_name;

            if (!in_array($file_ext, $extensions)) {
                $errors[] = 'Extension not allowed: ' . $file_name . ' ' . $file_type;
                $accessDatabase = false;
                $log->setInformation('User Try to Upload File With Wrong Extension. EXT= '.$file_ext);
                $log->setType('MANAGED_ERROR');
                $log->save();
                http_response_code(422);
                die();

            }

              if (!file_exists($path."/".$company)) {
                  mkdir($path."/".$company, 0777, true);
                  mkdir($path."/".$company."/files", 0777, true);
                  mkdir($path."/".$company."/reports", 0777, true);
                  mkdir($path."/".$company."/logos", 0777, true);
              }



              if($file_ext == 'xml' || $file_ext == 'XML'){
                $file = $path."/". $company."/files/".$file_name_toSave;
                $pathtosave = $path. $company."/files/";
                $fileNameToSave = $file_name_toSave;

              }else{
                $file = $path."/". $company."/logos/".$file_name_toSave;
                $logopathtosave = $path. $company."/logos/".$file_name_toSave;
              }


              if (empty($errors) && $all_files > 0) {
                if($file_ext == 'xml' || $file_ext == 'XML'){
                  deleteOldFiles($file_name,$company,$reportTitle);

                }
                  move_uploaded_file($file_tmp, $file);
              }

        }

          $db = new mysqli('127.0.0.1' , 'root' , 'KegelRoot' , 'lanemapper');
          mysqli_set_charset($db, "utf8");
            if (mysqli_connect_errno()){
              echo 'Error In Database Connection';
              exit;
            }

            $db->select_db('uploads');
            $uploaded_on = date("Y-m-d H:i:s");
            $query = "insert into uploads (`id`, `userid`, `company`, `filename`, `path`, `uploadedon`,  `logopath`, `report_title`, `report_location`, `number_lanes`, `lane_surface`, `lsyear_installation`, `ls_levelers` , `underlayment_year` , `head_replace`, `pin_decks`, `pinsetter`, `score_system`)
                      values
                      (NULL, '$id', '$company', '$fileNameToSave', '$pathtosave', '$uploaded_on' , '$logopathtosave' , '$reportTitle', '$reportLocation', '$numberLanes', '$laneSurface', '$laneSurfaceYearInstallation', '$laneSurfaceLevelers' ,'$underlaymentYear', '$headAreaReplace', '$pinDecks', '$pinsetters', '$scoreSystem')";
            if(mysqli_query($db,$query)){
              $uploaded = true;
              $log->setInformation('User Upload New File. File= '.$fileNameToSave);
              $log->setType('SUCCESS');
              $log->save();

            }else{
              printf("Errormessage: %s\n", mysqli_error($db));

            }

        if ($errors) print_r($errors);
  }
}

if ($uploaded != true){
  http_response_code(422);
}


function deleteOldFiles($filename , $company , $reportTitle){

  if (file_exists("uploads/Kegel_LLC/files/".$filename)) {
    $xml=simplexml_load_file("uploads/".$company."/files/".$filename) or die("Error: Cannot create object");
    $FormatDateForReportTitle = $xml->children()->Mappers[0]->Date;
    $FormatDateForReportTitle = substr($FormatDateForReportTitle, 0, strpos($FormatDateForReportTitle, "T"));
    $FormatDateForReportTitle = str_replace('-', '', $FormatDateForReportTitle);
    $FormatDateForReportTitle = strtotime($FormatDateForReportTitle);
    $FormatDateForReportTitle = date("Ynd",$FormatDateForReportTitle);
    $fileNameNoExt = substr($filename, 0, strpos($filename, "."));

    $fileToDelete = 'uploads/'.$company.'/reports/'.$FormatDateForReportTitle."_LaneMapGuide_" .$fileNameNoExt.".pdf";
    unlink($fileToDelete);
    $fileToDelete = 'uploads/'.$company.'/reports/'.$FormatDateForReportTitle."_LaneMapGuide_C_" .$fileNameNoExt.".pdf";
    unlink($fileToDelete);
    $fileToDelete = 'uploads/'.$company.'/reports/'.$FormatDateForReportTitle."_LaneMap_" .$fileNameNoExt.".pdf";
    unlink($fileToDelete);
    $fileToDelete = 'uploads/'.$company.'/reports/'.$FormatDateForReportTitle."_LaneMap_C_" .$fileNameNoExt.".pdf";
    unlink($fileToDelete);
    $name = strstr($filename, '.', true);
    $fileToDelete = 'uploads/'.$company.'/reports/'.$name."_USBCReportAllReadings.xlsx";
    unlink($fileToDelete);
    $fileToDelete = 'uploads/'.$company.'/reports/'.$name."_Wood.xlsx";
    unlink($fileToDelete);
    $fileToDelete = 'uploads/'.$company.'/reports/'.$name."_USBC Synthetic.xlsx";
    unlink($fileToDelete);
    $fileToDelete = 'uploads/'.$company.'/reports/'.$name."_USBC Multi.xlsx";
    unlink($fileToDelete);
    $fileToDelete = 'uploads/'.$company.'/reports/'.$name."_USBCReadings.xlsx";
    unlink($fileToDelete);
    $fileToDelete = 'uploads/'.$company.'/reports/'.$reportTitle."_CompareLaneMapReport.pdf";

    $db = new mysqli('127.0.0.1' , 'root' , 'KegelRoot' , 'lanemapper');
    mysqli_set_charset($db, "utf8");
      if (mysqli_connect_errno()){
        echo 'Error In Database Connection';
        exit;
      }
    $db->select_db('uploads');
    $query = "DELETE from uploads WHERE filename = '". $filename ."'";

    if(mysqli_query($db, $query)){

    }else{
      printf("Errormessage: %s\n", mysqli_error($db));
    }
    $db->close();
  }
}



?>
