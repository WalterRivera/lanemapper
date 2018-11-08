<?php

session_start();
echo "string";
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
$fileid = $_GET['fileid'];
$nameNoSpaces = str_replace(' ', '_', $name);
$log = new log();
$log->setCompany($company);
$log->setUserFname($firstname);
$log->setUserLname($lastname);

if($admin != 1){
  header('Location: dashboard.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['files'])) {
        $errors = [];
        $path = 'uploads/';
        $extensions = ['pdf', 'PDF' ,'application/pdf' , 'xlsx' , 'xls'];

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

            if (!file_exists($path."/".$nameNoSpaces)) {
                mkdir($path."/".$nameNoSpaces, 0777, true);
                mkdir($path."/".$nameNoSpaces."/files", 0777, true);
                mkdir($path."/".$nameNoSpaces."/reports", 0777, true);
                mkdir($path."/".$nameNoSpaces."/logos", 0777, true);
            }




              $file = $path."/". $nameNoSpaces."/reports/".$file_name_toSave;
              $pathtosave = $path. $nameNoSpaces."/reports/".$file_name_toSave;
              $fileNameToSave = $file_name_toSave;




            if (empty($errors) && $all_files > 0) {
                if(move_uploaded_file($file_tmp, $file)){
                  deleteOldFiles($file_name_toSave,$name);
                  $db = new mysqli('127.0.0.1' , 'root' , 'KegelRoot' , 'lanemapper');
                  mysqli_set_charset($db, "utf8");
                    if (mysqli_connect_errno()){
                      echo 'Error In Database Connection';
                      exit;
                    }

                    $db->select_db('reports');
                    $uploaded_on = date("Y-m-d H:i:s");
                    $query = "insert into reports (`id`, `file_id`, `company`, `path_report`, `status`, `report_name`,  `requested_on`)
                              values
                              (NULL,'$fileid', '$name', '$pathtosave', 'Ready', '$file_name_toSave' ,'$uploaded_on')";
                    if(mysqli_query($db,$query)){
                      $uploaded = true;
                      $log->setInformation('ADMIN upload New REPORT. File= '.$fileNameToSave. ' Company='.$name );
                      $log->setType('REPORT-UPLOADED');
                      $log->save();

                    }else{
                      printf("Errormessage: %s\n", mysqli_error($db));

                    }
                    $db->close();



                }else{
                  http_response_code(422);
                }
            }

          }
      }else{
        http_response_code(422);
      }
    }

function deleteOldFiles($filename , $company ){

  $db = new mysqli('127.0.0.1' , 'root' , 'KegelRoot' , 'lanemapper');
  mysqli_set_charset($db, "utf8");
    if (mysqli_connect_errno()){
      echo 'Error In Database Connection';
      exit;
    }
  $db->select_db('reports');
  $query = "DELETE from reports WHERE report_name = '". $filename ."' AND company= '".$company."'";

  if(mysqli_query($db, $query)){

  }else{
    printf("Errormessage: %s\n", mysqli_error($db));
  }
  $db->close();



}


?>
