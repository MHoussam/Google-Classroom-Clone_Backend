<?php

include('Config\db_connect.php');

header("Content-type: application/json; charset=utf-8");
header('Access-Control-Allow-Origin: http://127.0.0.1:5500');
header('Access-Control-Allow-Methods: GET,POST');
header("Access-Control-Allow-Headers: Content-Type");

$_POST = json_decode(file_get_contents('php://input'), true);


$material_id=$_POST['material_id'];

$token_value=$_POST['token_value'];

include('authentication-validation.php');
$title=$description=$date_of_upload=$first_name=$last_name="";
$sql = $conn->prepare("select title,description,date_of_upload,first_name,last_name from materials m join teachers t on m.teacher_id=t.teacher_id where material_id=?;");
$sql->bind_param("i",$material_id);
$sql->execute();
$sql->store_result();
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if($sql->num_rows=="0"){
  $response=array("status"=>"0","error"=>"No material");
  echo json_encode($response);
  exit();
} else{
    $sql->bind_result($title,$description,$date_of_upload,$first_name,$last_name);
    $sql->fetch();
    $response=array("status"=>"1","title"=>$title,'description'=>$description,"date_of_upload"=>$date_of_upload,"first_name"=>$first_name,"last_name"=>$last_name);
    echo json_encode($response);
    exit();
}

  

?>