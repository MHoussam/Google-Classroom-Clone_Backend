<?php

include('Config\db_connect.php');

header("Content-type: application/json; charset=utf-8");
header('Access-Control-Allow-Origin: http://127.0.0.1:5500');
header('Access-Control-Allow-Methods: POST');
header("Access-Control-Allow-Headers: Content-Type");


$_POST = json_decode(file_get_contents('php://input'), true);

$student_id=$first_name=$last_name=$email=$password=$token_value=$creation_date="";
$email=$_POST['email'];
$password=$_POST['password'];

$sql = $conn->prepare("select student_id,first_name,last_name,password from students where email=?");
$sql->bind_param("s",$email);
$sql->execute();
$sql->store_result();

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
if($sql->num_rows()==0){
  $response=array("status"=>"0","error"=>"Wrong credentials");
  echo json_encode($response);
  exit();
} else{
  $sql->bind_result($student_id,$first_name,$last_name,$hashed_password);
  $sql->fetch();
  if(password_verify($password,$hashed_password)){
    $token_value = bin2hex(openssl_random_pseudo_bytes(16));
    $sql = $conn->prepare("INSERT INTO student_tokens (student_id,token_value) VALUES (?,?)");
    $sql->bind_param("is",$student_id,$token_value);
    $sql->execute();
    if($sql->affected_rows=="0"){
        $response=array("status"=>"0","error"=>"Could not create token");
        echo json_encode($response);
        exit();
    } else{
      $response = array("status"=>"1","id"=>$student_id,"first_name"=>$first_name,"last_name"=>$last_name,"token_value"=>$token_value);
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