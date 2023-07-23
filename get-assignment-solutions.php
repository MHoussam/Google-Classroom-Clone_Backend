<?php

include('Config\db_connect.php');

header("Content-type: application/json; charset=utf-8");
header('Access-Control-Allow-Origin: http://localhost:5500');
header('Access-Control-Allow-Methods: POST');
header("Access-Control-Allow-Headers: Content-Type");



$student_id=$_GET['student_id'];
$assignment_id=$_GET['assignment_id'];
$solution="";
$sql = $conn->prepare("select solution from assignments_solution where student_id=? and assignment_id=?;");
$sql->bind_param("ss",$student_id,$assignment_id);
$sql->execute();
$result=$sql->get_result();
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$arrayofrows = array();

if($result->num_rows()==0){
  $response=array("status"=>"0","error"=>"No solutions");
  echo json_encode($data);
  exit();
} else{

    while( $row=$result->fetch_array(MYSQLI_ASSOC)){
        $arrayofrows[] = $row;
    }
    echo json_encode($arrayofrows);
}

  

?>