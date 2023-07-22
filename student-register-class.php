<?php
$student_id=$_POST['student_id'];
$class_name=$_POST['class_name'];
$class_id="";

$sql = $conn->prepare("select class_id from classes where class_name=$class_name");
$sql->bind_param("s",$class_name);
$sql->execute();
$sql->store_result();

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
if($sql->num_rows()==0){
    
  $data=array("status"=>"0","error"=>"Class does not exist");
  echo json_encode($data);
  exit();
} else{
    $sql->bind_result($class_id);
    $sql->fetch();
    $sql = $conn->prepare("INSERT INTO class_students (student_id,class_id) VALUES (student_id,class_id)");
    $sql->bind_param("ss", $student_id,$class_id);
    $sql->execute();
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    if($sql->get_result()){
        $response=array('status'=>'0','error'=>'could not add class');
        echo json_encode($response);
        exit();
    }else{
        $response=array('status'=>'1','result'=>'Class added.');
        echo json_encode($response);
        exit();
    }
}

?>