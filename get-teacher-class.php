<?php

include('Config\db_connect.php');

header("Content-type: application/json; charset=utf-8");
header('Access-Control-Allow-Origin: http://localhost:5500');
header('Access-Control-Allow-Methods: POST');
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Credentials: true");


// $_GET = json_decode(file_get_contents('php://input'), true);

$teacher_id=$_GET['teacher_id'];
$class_name=$class_id="";

$sql = $conn->prepare("select class_id,class_name from classes where teacher_id=?");
$sql->bind_param("s",$teacher_id);
$sql->execute();
$sql->store_result();
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
if($sql->num_rows()==0){
  $response=array("status"=>"0","error"=>"No classes");
  echo json_encode($data);
  exit();
} else{
  $sql->bind_result($class_id,$class_name);
  $sql->fetch();
  $response=array('class_id'=>$class_id,'class_name'=>$class_name);
  echo json_encode($response);
}        

?>