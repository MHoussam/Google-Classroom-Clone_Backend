<?php

include('Config\db_connect.php');

header("Content-type: application/json; charset=utf-8");
header('Access-Control-Allow-Origin: http://localhost:5500');
header('Access-Control-Allow-Methods: POST');
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Credentials: true");


// $_GET = json_decode(file_GET$_GET_contents('php://input'), true);

$student_id=$_GET['student_id'];
$class_name=$teacher_id=$teacher_name="";
$sql = $conn->prepare("select class_id from class_students where student_id=?");
$sql->bind_param("s",$student_id);
$sql->execute();
$result=$sql->get_result();
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$arrayofrows = array();

if(!$result){
  $response=array("status"=>"0","error"=>"No classes");
  echo json_encode($data);
  exit();
} else{

    while( $row=$result->fetch_array(MYSQLI_ASSOC)){
        $arrayofrows[] = $row;
    }

}
$arrayofClasses=array();
foreach($arrayofrows as $row){
    $sql = $conn->prepare("select class_name from classes where class_id=?");
    $sql->bind_param("s",$row['class_id']);
    $sql->execute();
    $sql->store_result();
    if($sql->num_rows()==0){
        $response=array("status"=>"0","error"=>"No class names");
        echo json_encode($data);
        exit();
    } else{
        $sql->bind_result($class_name);
        $sql->fetch();
        $row=array('class_id'=>$row['class_id'],'class_name'=>$class_name);
        $arrayofClasses[] = $row;
    }
}

echo json_encode($arrayofClasses);
//   $response=array('class_id'=>$class_id,'class_name'=>$class_name);
//   echo json_encode($response);
  

?>