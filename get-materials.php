<?php

include('Config\db_connect.php');

header("Content-type: application/json; charset=utf-8");
header('Access-Control-Allow-Origin: http://localhost:5500');
header('Access-Control-Allow-Methods: POST');
header("Access-Control-Allow-Headers: Content-Type");


// $_GET = json_decode(file_GET$_GET_contents('php://input'), true);

$class_id=$_GET['class_id'];
$material_id=$title=$description=$path=$date_of_upload="";
$sql = $conn->prepare("select title,description,path,date_of_upload from materials where class_id=?;");
$sql->bind_param("s",$class_id);
$sql->execute();
$result=$sql->get_result();
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$arrayofrows = array();

if($result->num_rows()=="0"){
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