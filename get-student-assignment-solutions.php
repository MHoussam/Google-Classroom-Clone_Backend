<?php

include('Config\db_connect.php');

header("Content-type: application/json; charset=utf-8");
header('Access-Control-Allow-Origin: http://127.0.0.1:5500');
header('Access-Control-Allow-Methods: GET');
header("Access-Control-Allow-Headers: Content-Type");

$_POST = json_decode(file_get_contents('php://input'), true);

$token_value=$_POST['token_value'];

include('authentication-validation.php');

$student_id=$_GET['student_id'];
$assignment_id=$_GET['assignment_id'];
$solution="";

$sql = $conn->prepare("select assignments_solution_id,solution from assignments_solution where student_id=? and assignment_id=?;");
$sql->bind_param("ii",$student_id,$assignment_id);
$sql->execute();
$result=$sql->get_result();
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$arrayofrows = array();

if($result->num_rows==0){
  $response=array("status"=>"0","error"=>"No solutions");
  echo json_encode($response);
  exit();
} else{

    while( $row=$result->fetch_array(MYSQLI_ASSOC)){
        $arrayofrows[] = $row;
    }
    echo json_encode($arrayofrows);
}

  

?>