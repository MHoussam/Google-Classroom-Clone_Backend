<?php

include('Config\db_connect.php');

header("Content-type: application/json; charset=utf-8");
header('Access-Control-Allow-Origin: http://127.0.0.1:5500');
header('Access-Control-Allow-Methods: POST');
header("Access-Control-Allow-Headers: Content-Type");


$_POST = json_decode(file_get_contents('php://input'), true);

$email=$password=$new_password="";

$email=$_POST['email'];

$password=$_POST['password'];
$new_password=$_POST['new_password'];
$sql = $conn->prepare("select password from students where email=?");
$sql->bind_param("s",$email);
$sql->execute();
$sql->store_result();

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
if($sql->num_rows==0){
  $response=array("status"=>"0","error"=>"Wrong credentials");
  echo json_encode($response);
  exit();
} else{
  $sql->bind_result($hashed_password);
  $sql->fetch();
  if(password_verify($password,$hashed_password)){
    $new_hashed_pass = password_hash($new_password, PASSWORD_BCRYPT);
    $sql = $conn->prepare("UPDATE students SET password=? WHERE email=?");
    $sql->bind_param("ss",$new_hashed_pass,$email);
    $sql->execute();
    if($sql->affected_rows=="0"){
        $response=array('status'=>"0","result"=>"Could not change password");
        echo json_encode($response);
        exit();
    }else{
        $response=array('status'=>"1","result"=>"Password changed");
        echo json_encode($response);
        exit();
    }
  } else{
    $response=array("status"=>"0","error"=>"Wrong credentials");
    echo json_encode($response);
    exit();
  }
}        

?>