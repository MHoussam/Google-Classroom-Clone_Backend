<?php

include('Config\db_connect.php');

header("Content-type: application/json; charset=utf-8");
header('Access-Control-Allow-Origin: http://127.0.0.1:5500');
header('Access-Control-Allow-Methods: GET');
header("Access-Control-Allow-Headers: Content-Type");



$class_id=$_GET['class_id'];
$material_id=$title=$description=$path=$date_of_upload="";
$sql = $conn->prepare("select DISTINCT title,date_of_upload,first_name,last_name from materials m join teachers t on m.teacher_id=t.teacher_id where class_id=?;");
$sql->bind_param("s",$class_id);
$sql->execute();
$result=$sql->get_result();
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$arrayofrows = array();

if($result->num_rows=="0"){
  $response=array("status"=>"0","error"=>"No materials");
  echo json_encode($data);
  exit();
} else{

    while( $row=$result->fetch_array(MYSQLI_ASSOC)){
        $arrayofrows[] = $row;
    }
    echo json_encode($arrayofrows);
}

  

?>