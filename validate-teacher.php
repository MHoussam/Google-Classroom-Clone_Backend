<?php

include('Config\db_connect.php');

$id=$first_name=$last_name=$email=$password=$occupation="";
header("Content-type: application/json; charset=utf-8");
header('Access-Control-Allow-Origin: http://localhost:5500');
header('Access-Control-Allow-Methods: POST');
header("Access-Control-Allow-Headers: Content-Type");


// $_POST = json_decode(file_get_contents('php://input'), true);

$email=$_POST['email'];

$password=$_POST['password'];

$sql = $conn->prepare("select user_id,first_name,last_name,password from teachers where email=?");
$sql->bind_param("s",$email);
$sql->execute();
$sql->store_result();

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
if($sql->num_rows()==0){
  $data=array("status"=>"0","error"=>"Wrong credentials");
  echo json_encode($data);
  exit();
} else{
  $sql->bind_result($id,$first_name,$last_name,$hashed_password);
  $sql->fetch();
  if(password_verify($password,$hashed_password)){
    $data = array("status"=>"1","id"=>$id,"first_name"=>$first_name,"last_name"=>$last_name);
    echo json_encode($data);
    exit();
  } else{
    $data=array("status"=>"0","error"=>"Wrong credentials");
    echo json_encode($data);
    exit();
  }
 

}        

?>