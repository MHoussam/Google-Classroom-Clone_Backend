<?php

include('Config\db_connect.php');

header("Content-type: application/json; charset=utf-8");
header('Access-Control-Allow-Origin: http://127.0.0.1:5500');
header('Access-Control-Allow-Methods: GET');
header("Access-Control-Allow-Headers: Content-Type");



$assignment_id=$_GET['assignment_id'];
$_POST = json_decode(file_get_contents('php://input'), true);

$token_value=$_POST['token_value'];

include('student-authentication-validation.php');

$title=$description=$path=$due_date=$due_time=$date_of_upload="";
$sql = $conn->prepare("select assignment_id,title,description,due_date,due_time,date_of_upload from assignments where assignment_id=?;");
$sql->bind_param("i",$assignment_id);
$sql->execute();
$sql->store_result();
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if($sql->num_rows=="0"){
  $response=array("status"=>"0","error"=>"No assignments");
  echo json_encode($response);
  exit();
} else{
    $sql->bind_result($assignment_id,$title,$description,$due_date,$due_time,$date_of_upload);
    $response=array("status"=>"1","assignment_id"=>$assignment_id,"title"=>$title,"description"=>$description,"due_date"=>$due_date,"due_time"=>$due_time,"date_of_upload"=>$date_of_upload);
    echo json_encode($response);
    exit();
}

  

?>