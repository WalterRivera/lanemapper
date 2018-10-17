<?php
$xml=simplexml_load_file("uploads/Kegel_LLC/files/Plum_1-24_O.xml") or die("Error: Cannot create object");
$StepQuantity = array();

for ($x=0; $x< $xml->children()->Readings->Count();$x++){
  $StepQuantity[$xml->children()->Readings[$x]->MapperID -1] = $StepQuantity[$xml->children()->Readings[$x]->MapperID -1] + 1;


}


$commonStep = array_count_values($StepQuantity);
arsort($commonStep);
echo 'Common Step = ' . key($commonStep) . '<br>';
echo "<pre>";
print_r($StepQuantity);
echo "</pre>";

?>
