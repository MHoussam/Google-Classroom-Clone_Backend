<?php
include('Config\db_connect.php');

header("Content-type: application/json; charset=utf-8");
header('Access-Control-Allow-Origin: http://127.0.0.1:5500');
header('Access-Control-Allow-Methods: POST');
header("Access-Control-Allow-Headers: Content-Type");

// $_POST = json_decode(file_get_contents('php://input'), true);

$student_id=$_POST['student_id'];
$class_name=$_POST['class_name'];
$class_id="";
$sql = $conn->prepare("select student_id from students where student_id=?");
$sql->bind_param("s", $student_id);
$sql->execute();
$sql->store_result();
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
if($sql->num_rows=="0"){
    $response=array('status'=>'0','error'=>'Student does not exist');
    echo json_encode($response);
    exit();
}

$sql = $conn->prepare("select class_id from classes where class_name=?");
$sql->bind_param("s",$class_name);
$sql->execute();
$sql->store_result();

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
if($sql->num_rows==0){
    
  $data=array("status"=>"0","error"=>"Class does not exist");
  echo json_encode($data);
  exit();
} else{
    $sql->bind_result($class_id);
    $sql->fetch();
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