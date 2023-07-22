<?php

include('Config\db_connect.php');

$username=$password=$new_password="";
header("Content-type: application/json; charset=utf-8");
header('Access-Control-Allow-Origin: http://localhost:5500');
header('Access-Control-Allow-Methods: POST');
header("Access-Control-Allow-Headers: Content-Type");


// $_POST = json_decode(file_get_contents('php://input'), true);

$username=$_POST['username'];

$password=$_POST['password'];
$new_password=$_POST['new_password'];

$sql = $conn->prepare("select password from users where username=?");
$sql->bind_param("s",$username);
$sql->execute();
$sql->store_result();

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
if($sql->num_rows()==0){
  $data=array("status"=>"0","error"=>"Wrong credentials");
  echo json_encode($data);
  exit();
} else{
  $sql->bind_result($hashed_password);
  $sql->fetch();
  if(password_verify($password,$hashed_password)){
    $new_hashed_pass = password_hash($new_password, PASSWORD_BCRYPT);
    $sql = $conn->prepare("UPDATE users SET password=? WHERE username=?");
    $sql->bind_param("ss",$new_hashed_pass,$username);
    $sql->execute();
    if($sql->get_result()){
        $response=array('status'=>"0","result"=>"Could not change password");
        echo json_encode($response);
        exit();
    }else{
        $response=array('status'=>"1","result"=>"Password changed");
        echo json_encode($response);
        exit();
    }
  } else{
    $data=array("status"=>"0","error"=>"Wrong credentials");
    echo json_encode($data);
    exit();
  }
 

}        

?>