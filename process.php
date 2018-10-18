<?php
$uploaded = false;
session_start();

if(!isset($_SESSION['userid'])){
  header('Location: login.php');
}

$id = $_SESSION['userid'];
$email = $_SESSION['email'];
$firstname = $_SESSION['fname'];
$lastname = $_SESSION['lname'];
$company = $_SESSION['company'];
$company = str_replace(' ', '_', $company);
$reportTitle = $_GET['rt'];
$reportDate = $_GET['rd'];
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['files'])) {
        $errors = [];
        $path = 'uploads/';
        $extensions = ['jpg', 'jpeg', 'png', 'xml'];

        $all_files = count($_FILES['files']['tmp_name']);

        for ($i = 0; $i < $all_files; $i++) {
            $file_name = $_FILES['files']['name'][$i];
            $file_tmp = $_FILES['files']['tmp_name'][$i];
            $file_type = $_FILES['files']['type'][$i];
            $file_size = $_FILES['files']['size'][$i];
            $file_ext = strtolower(end(explode('.', $_FILES['files']['name'][$i])));
            $file_name_toSave = $file_name;
            if (!file_exists($path."/".$company)) {
                mkdir($path."/".$company, 0777, true);
                mkdir($path."/".$company."/files", 0777, true);
                mkdir($path."/".$company."/reports", 0777, true);
                mkdir($path."/".$company."/logos", 0777, true);
            }

            if($file_ext == 'xml'){
              $file = $path."/". $company."/files/".$file_name_toSave;
              $pathtosave = $path. $company."/files/";
              $fileNameToSave = $file_name_toSave;

            }else{
              $file = $path."/". $company."/logos/".$file_name_toSave;
              $logopathtosave = $path. $company."/logos/".$file_name_toSave;
            }

            if (!in_array($file_ext, $extensions)) {
                $errors[] = 'Extension not allowed: ' . $file_name . ' ' . $file_type;
            }


            if (empty($errors) && $all_files > 0) {
                move_uploaded_file($file_tmp, $file);
            }
        }

        $db = new mysqli('localhost' , 'root' , '' , 'lanemapper');
        mysqli_set_charset($db, "utf8");
          if (mysqli_connect_errno()){
            echo 'Error In Database Connection';
            exit;
          }

          $db->select_db('uploads');
          $query = "insert into uploads (`id`, `userid`, `company`, `filename`, `path`, `logopath`, `report_title`, `report_date`, `report_location`, `number_lanes`, `lane_surface`, `lsyear_installation`, `ls_levelers` , `underlayment_year` , `head_replace`, `pin_decks`, `pinsetter`, `score_system`)
                    values
                    (NULL, '$id', '$company', '$fileNameToSave', '$pathtosave', '$logopathtosave' , '$reportTitle', '$reportDate', '$reportLocation', '$numberLanes', '$laneSurface', '$laneSurfaceYearInstallation', '$laneSurfaceLevelers' ,'$underlaymentYear', '$headAreaReplace', '$pinDecks', '$pinsetters', '$scoreSystem')";
          if(mysqli_query($db,$query)){
            $uploaded = true;
          }else{
            printf("Errormessage: %s\n", mysqli_error($db));

          }

        if ($errors) print_r($errors);
  }
}

if ($uploaded != true){
  http_response_code(422);
}

?>
