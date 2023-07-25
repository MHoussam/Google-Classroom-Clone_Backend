<?php

include('Config\db_connect.php');

header("Content-type: application/json; charset=utf-8");
header('Access-Control-Allow-Origin: http://127.0.0.1:5500');
header('Access-Control-Allow-Methods: GET');
header("Access-Control-Allow-Headers: Content-Type");


$teacher_id=$_GET['teacher_id'];
$_POST = json_decode(file_get_contents('php://input'), true);

$token_value=$_POST['token_value'];

include('authentication-validation.php');

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