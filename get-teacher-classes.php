<?php

include('Config\db_connect.php');

header("Content-type: application/json; charset=utf-8");
header('Access-Control-Allow-Origin: http://localhost:5500');
header('Access-Control-Allow-Methods: POST');
header("Access-Control-Allow-Headers: Content-Type");



$teacher_id=$_GET['teacher_id'];
$sql = $conn->prepare("select teacher_id from teachers where teacher_id=?");
$sql->bind_param("s", $teacher_id);
$sql->execute();
$sql->store_result();
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
if($sql->num_rows=="0"){
    $response=array('status'=>'0','error'=>'Teacher does not exist');
    echo json_encode($response);
    exit();
}

$sql = $conn->prepare("select class_id,class_name,section,subject,room,meet_link from classes where class_id IN (select class_id from class_teachers where teacher_id=?);");
$sql->bind_param("s",$teacher_id);
$sql->execute();
$result=$sql->get_result();
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
if($result->num_rows=="0"){
  $response=array("status"=>"0","error"=>"No classes");
  echo json_encode($data);
  exit();
} else{
  $arrayofrows = array();

    while( $row=$result->fetch_array(MYSQLI_ASSOC)){
        $arrayofrows[] = $row;
    }
    echo json_encode($arrayofrows);
}        

?>