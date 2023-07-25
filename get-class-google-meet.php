<?php

include('Config\db_connect.php');

header("Content-type: application/json; charset=utf-8");
header('Access-Control-Allow-Origin: http://127.0.0.1:5500');
header('Access-Control-Allow-Methods: POST');
header("Access-Control-Allow-Headers: Content-Type");

$class_id=$_GET['class_id'];
$_POST = json_decode(file_get_contents('php://input'), true);

$token_value=$_POST['token_value'];

include('authentication-validation.php');
$meet_link="";
$sql = $conn->prepare("select meet_link from classes where class_id=?");
$sql->bind_param("i",$class_id);
$sql->execute();
$sql->store_result();
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
if($sql->num_rows=="0"){
    $response=array("status"=>"0","error"=>"Class does not exist");
    echo json_encode($data);
    exit();
} else{
    $sql->bind_result($meet_link);
    $sql->fetch();
    $response=array("status"=>"1","meet_link"=>$meet_link);
    echo json_encode($response);
    exit();
}        

?>