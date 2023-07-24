<?php
include('Config\db_connect.php');

// $_POST = json_decode(file_get_contents('php://input'), true);

$student_id=$_POST['student_id'];
$assignment_id=$_POST['assignment_id'];
$solution=$_POST['solution'];

$sql = $conn->prepare("select student_id from students where student_id=?");
$sql->bind_param("i", $student_id);
$sql->execute();
$sql->store_result();
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
if($sql->num_rows=="0"){
    $response=array('status'=>'0','error'=>'Student does not exist');
    echo json_encode($response);
    exit();
}

$sql = $conn->prepare("select class_id from class_students where student_id=? and class_id IN (select class_id from assignments where assignment_id=?)");
$sql->bind_param("ii", $student_id,$assignment_id);
$sql->execute();
$sql->store_result();
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
if($sql->num_rows==0){
  $data=array("status"=>"0","error"=>"Student is not in this class or assignment does not exist");
  echo json_encode($data);
  exit();
} else{
    $sql->bind_result($class_id);
    $sql->fetch();
    $sql = $conn->prepare("INSERT INTO assignments_solution (student_id,assignment_id,solution) VALUES (?,?,?)");
    $sql->bind_param("iis", $student_id,$assignment_id,$solution);
    $sql->execute();
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    if($sql->affected_rows=="0"){
        $response=array('status'=>'0','error'=>'Could not add solution');
        echo json_encode($response);
        exit();
    }else{
        $response=array('status'=>'1','result'=>'Solution added.');
        echo json_encode($response);
        exit();
    }
}

?>