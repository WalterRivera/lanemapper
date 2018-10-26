<?php
$id = $_GET['id'];
$report= $_GET['option'];
$distances = $_GET['distances'];
$usbcoption = $_GET['usbcoption'];
$beforefile = $_GET['beforefile'];
$afterfile = $_GET['afterfile'];
$lanestocompare = $_GET['lanestocompare'];



$db = new mysqli('localhost' , 'root' , '' , 'lanemapper');
mysqli_set_charset($db, "utf8");
  if (mysqli_connect_errno()){
    echo 'Error In Database Connection';
    exit;
  }
$db->select_db('uploads');
$query = "SELECT * FROM uploads WHERE id='".$id."'";
$result = mysqli_query($db,$query) or die(mysqli_error());
$num_rows = mysqli_num_rows($result);
  if($num_rows > 0){
    $row = mysqli_fetch_assoc($result);
    $id = $row['id'];
    $company = $row['company'];
    $filename = $row['filename'];
    $path = $row['path'];
    $logopath = $row['logopath'];
    $reportTitle = $row['report_title'];
    $reportLocation = $row['report_location'];
    $numberLanes = $row['number_lanes'];
    $laneSurface = $row['lane_surface'];
    $laneSurfaceYearInstallation = $row['lsyear_installation'];
    $laneSurfaceLevelers = $row['ls_levelers'];
    $underlaymentYear = $row['underlayment_year'];
    $headPlace = $row['head_replace'];
    $pinDecks = $row['pin_decks'];
    $pinsetter = $row['pinsetter'];
    $scoreSystem = $row['score_system'];
    $company = $row['company'];
  }else{
    echo "Error";
  }
$db->close();

$xml=simplexml_load_file("uploads/Kegel_LLC/files/".$filename) or die("Error: Cannot create object");
$FormatDateForReportTitle = $xml->children()->Mappers[0]->Date;
$FormatDateForReportTitle = substr($FormatDateForReportTitle, 0, strpos($FormatDateForReportTitle, "T"));

$FormatDateForReportTitle = str_replace('-', '', $FormatDateForReportTitle);
$FormatDateForReportTitle = strtotime($FormatDateForReportTitle);
$FormatDateForReportTitle = date("Ynd",$FormatDateForReportTitle);
$fileNameNoExt = substr($filename, 0, strpos($filename, "."));
$company = str_replace(' ', '_', $company);
$reportPath = 'uploads/'. $company.'/reports/';

$args = '"'.$path.$filename.'"'; //path
$args = $args.' "'.$reportTitle.'"'; //report title
$args = $args.' "'.$logopath.'"'; // Logo Path
$args = $args.' "'.$reportLocation.'"'; // report location
$args = $args.' '.$numberLanes;
$args = $args.' '.$laneSurface;
$args = $args.' '.$laneSurfaceYearInstallation;
$args = $args.' '.$laneSurfaceLevelers;
$args = $args.' '.$underlaymentYear;
$args = $args.' '.$headPlace;
$args = $args.' '.$pinDecks;
$args = $args.' '.$pinsetter;
$args = $args.' '.$scoreSystem;



if($report == 'Lane Guide only Report'){
  //$args = $args. ' 14';
  $args = $args.' 1 0 0 0 0 '.$distances.' '.$usbcoption.' 0 0 0 0 0 0';
  $reportName = $FormatDateForReportTitle."_LaneMapGuide_" .$fileNameNoExt.".pdf";

}

if($report == 'Lane Guide Report with cover'){
  $args = $args.' 0 1 0 0 0 '.$distances.' '.$usbcoption.' 0 0 0 0 0 0';
  $reportName = $FormatDateForReportTitle."_LaneMapGuide_C_" .$fileNameNoExt.".pdf";
}

if($report == 'Lane map Only Report'){
  $args = $args.' 0 0 1 0 0 '.$distances.' '.$usbcoption.' 0 0 0 0 0 0';
  $reportName = $FormatDateForReportTitle."_LaneMap_" .$fileNameNoExt.".pdf";

}

if($report == 'Lane map With Cover Report'){
  $args = $args.' 0 0 0 1 0 '.$distances.' '.$usbcoption.' 0 0 0 0 0 0';
  $reportName = $FormatDateForReportTitle."_LaneMap_C_" .$fileNameNoExt.".pdf";
}

if($report == 'Export All Readings to excel'){
  $args = $args.' 0 0 0 0 1 '.$distances.' '.$usbcoption.' 0 0 0 0 0 0';
  $name = strstr($filename, '.', true);
  $reportName = $name."_USBCReportAllReadings.xlsx";
}

if($report == 'Reports for USBC (Wood)'){
//$args = $args.' 0 0 0 0 0 11,37,57 1 1 0 0 0 0 0';
$args = $args.' 0 0 0 0 0 "'.$distances.'" '.$usbcoption.' 0 0 0 0 0 0';
$name = strstr($filename, '.', true);
$reportName = $name."_Wood.xlsx";
}

if($report == 'Reports for USBC (Synthetic)'){
  $args = $args.' 0 0 0 0 0 '.$distances.' '.$usbcoption.' 0 0 0 0 0 0';
  $name = strstr($filename, '.', true);
  $reportName = $name."_USBC Synthetic.xlsx";
}

if($report == 'Reports for USBC (Multi)'){
  $args = $args.' 0 0 0 0 0 '.$distances.' '.$usbcoption.' 0 0 0 0 0 0';
  $name = strstr($filename, '.', true);
  $reportName = $name."_USBC Multi.xlsx";
}

if($report == 'Export All USBC readings for all lanes to excel'){
  $args = $args.' 0 0 0 0 0 '.$distances.' '.$usbcoption.' 1 0 0 0 0 0';
  $name = strstr($filename, '.', true);
  $reportName = $name."_USBCReadings.xlsx";
}

if($report == 'Before and After Comparison'){
  $beforefile = substr($beforefile, 1);
  $afterfile = substr($afterfile, 1);
  $beforepath = $path.$beforefile;
  $afterpath = $path.$afterfile;

  $args = $args.' 0 0 0 0 0 '.$distances.' '.$usbcoption.' 0 "'. $lanestocompare . '" "'.$beforepath.'" "'.$lanestocompare.'" "'.$afterpath.'" 1';
  $reportName = $reportTitle."_CompareLaneMapReport.pdf";
}


$args = $args.' "'.$company.'"';

$reportPath = $reportPath.$reportName;

$cmd = 'KegelLaneMapper.exe 0 '.$args;
//echo $cmd;

if (substr(php_uname(), 0, 7) == "Windows"){

    pclose(popen("start /B ". $cmd, "r"));

}
else {
    exec($cmd . " > /dev/null &");
}




unlink($reportPath);
$db = new mysqli('localhost' , 'root' , '' , 'lanemapper');
mysqli_set_charset($db, "utf8");
  if (mysqli_connect_errno()){
    echo 'Error In Database Connection';
    exit;
  }
$db->select_db('reports');
$query = "DELETE from reports WHERE path_report = '". $reportPath ."'";

if(mysqli_query($db, $query)){

}else{
  printf("Errormessage: %s\n", mysqli_error($db));
}
$db->close();






$db = new mysqli('localhost' , 'root' , '' , 'lanemapper');
mysqli_set_charset($db, "utf8");
  if (mysqli_connect_errno()){
    echo 'Error In Database Connection';
    exit;
  }

  $db->select_db('reports');
  $requested_on = date("Y-m-d H:i:s");
  $company = str_replace('_', ' ', $company);
  $query = "insert into reports (`id`, `file_id`, `company`, `path_report`, `status`, `report_name` , `requested_on`)
            values
            (NULL, '$id', '$company', '$reportPath', 'Processing', '$reportName' , '$requested_on')";
  if(mysqli_query($db,$query)){
    $uploaded = true;
  }else{
    printf("Errormessage: %s\n", mysqli_error($db));

  }



?>
