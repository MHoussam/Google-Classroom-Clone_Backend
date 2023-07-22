<?php

$student_id=$_POST['student_id'];
$class_name=$_POST['class_name'];
$assignment_id=$_POST['assignment_id'];
$solution=$_POST['solution'];

$sql = $conn->prepare("select assignment_id from assignments where assignment_id=$assignment_id");
$sql->bind_param("s",$assignment_id);
$sql->execute();
$sql->store_result();

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
if($sql->num_rows()==0){
    
  $data=array("status"=>"0","error"=>"Assignment does not exist");
  echo json_encode($data);
  exit();
} else{
    $sql->bind_result($class_id);
    $sql->fetch();
    $sql = $conn->prepare("INSERT INTO assignments_solution (student_id,assignment_id,solution) VALUES (?,?,?)");
    $sql->bind_param("sss", $student_id,$assignment_id,$solution);
    $sql->execute();
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    if($sql->get_result()){
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