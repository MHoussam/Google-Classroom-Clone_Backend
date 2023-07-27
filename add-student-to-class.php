<?php
include('Config\db_connect.php');

header("Content-type: application/json; charset=utf-8");
header('Access-Control-Allow-Origin: http://127.0.0.1:5500');
header('Access-Control-Allow-Methods: POST');
header("Access-Control-Allow-Headers: Content-Type");

$_POST = json_decode(file_get_contents('php://input'), true);

$token_value=$_POST['token_value'];

include('authentication-validation.php');

$email=$_POST['email'];
$class_id=$_POST['class_id'];
$student_id="";
$sql = $conn->prepare("select student_id from students where email=?");
$sql->bind_param("s", $email);
$sql->execute();
$sql->store_result();
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
if($sql->num_rows=="0"){
    $response=array('status'=>'0','error'=>'Student does not exist');
    echo json_encode($response);
    exit();
}
$sql->bind_result($student_id);
$sql->fetch();
$sql = $conn->prepare("select class_id from classes where class_id=?");
$sql->bind_param("i",$class_id);
$sql->execute();
$sql->store_result();

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
if($sql->num_rows==0){
    
  $response=array("status"=>"0","error"=>"Class does not exist");
  echo json_encode($response);
  exit();
} else{
    $sql = $conn->prepare("INSERT INTO class_students (student_id,class_id) VALUES (?,?)");
    $sql->bind_param("ss", $student_id,$class_id);
    $sql->execute();
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    if($sql->affected_rows=="0"){
        $response=array('status'=>'0','error'=>'could not add class');
        echo json_encode($response);
        exit();
    }else{
        $response=array('status'=>'1','result'=>'Class added to student');
        echo json_encode($response);
        exit();
    }
}

?>