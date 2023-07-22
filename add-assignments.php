<?php
$class_name=$_POST['class_name'];
$title=$_POST['title'];
$class_id="";
$description=$_POST['description'];

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
    $sql = $conn->prepare("INSERT INTO assignments (class_id,title,description) VALUES (?,?,?)");
    $sql->bind_param("sss", $class_id,$title,$description);
    $sql->execute();
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    if($sql->get_result()){
        $response=array('status'=>'0','error'=>'Could not add assignment');
        echo json_encode($response);
        exit();
    }else{
        $response=array('status'=>'1','result'=>'Assignment added.');
        echo json_encode($response);
        exit();
    }
}

?>