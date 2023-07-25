<?php

include('Config\db_connect.php');

header("Content-type: application/json; charset=utf-8");
header('Access-Control-Allow-Origin: http://127.0.0.1:5500');
header('Access-Control-Allow-Methods: GET');
header("Access-Control-Allow-Headers: Content-Type");



$material_id=$_GET['material_id'];
$_POST = json_decode(file_get_contents('php://input'), true);

$token_value=$_POST['token_value'];

include('student-authentication-validation.php');
$title=$description=$path=$date_of_upload="";
$sql = $conn->prepare("select title,description,path,date_of_upload from materials where material_id=?;");
$sql->bind_param("i",$material_id);
$sql->execute();
$sql->store_result();
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if($sql->num_rows=="0"){
  $response=array("status"=>"0","error"=>"No material");
  echo json_encode($response);
  exit();
} else{
    $sql->bind_result($title,$description,$path,$date_of_upload);
    $sql->fetch();
    $response=array("status"=>"1","title"=>$title,'description'=>$description,"path"=>$path,"date_of_upload"=>$date_of_upload);
    echo json_encode($response);
    exit();
}

  

?>