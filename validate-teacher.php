<?php

include('Config\db_connect.php');

header("Content-type: application/json; charset=utf-8");
header('Access-Control-Allow-Origin: http://127.0.0.1:5500');
header('Access-Control-Allow-Methods: POST');
header("Access-Control-Allow-Headers: Content-Type");


$_POST = json_decode(file_get_contents('php://input'), true);
$teacher_id=$first_name=$last_name=$email=$password=$token_value=$creation_date="";

$email=$_POST['email'];

$password=$_POST['password'];

$sql = $conn->prepare("select teacher_id,first_name,last_name,password from teachers where email=?");
$sql->bind_param("s",$email);
$sql->execute();
$sql->store_result();
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
if($sql->num_rows()==0){
  $response=array("status"=>"0","error"=>"Wrong credentials");
  echo json_encode($response);
  exit();
} else{
  $sql->bind_result($teacher_id,$first_name,$last_name,$hashed_password);
  $sql->fetch();
  if(password_verify($password,$hashed_password)){
    $creation_date = date("Y-m-d H:i:s");
    $token_value = bin2hex(openssl_random_pseudo_bytes(16));
    $sql = $conn->prepare("INSERT INTO teacher_tokens (teacher_id,token_value,creation_date) VALUES (?,?,?)");
    $sql->bind_param("iss",$teacher_id,$token_value,$creation_date);
    $sql->execute();
    if($sql->affected_rows=="0"){
        $response=array("status"=>"0","error"=>"Could not create token");
        echo json_encode($response);
        exit();
    } else{
      $response = array("status"=>"1","id"=>$teacher_id,"first_name"=>$first_name,"last_name"=>$last_name,"token_value"=>$token_value);
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