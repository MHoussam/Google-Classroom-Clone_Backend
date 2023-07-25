<?php
include('Config\db_connect.php');

header("Content-type: application/json; charset=utf-8");
header('Access-Control-Allow-Origin: http://127.0.0.1:5500');
header('Access-Control-Allow-Methods: POST');
header("Access-Control-Allow-Headers: Content-Type");

$_POST = json_decode(file_get_contents('php://input'), true);

$class_id=$_POST['class_id'];
$teacher_id=$_POST['teacher_id'];
$title=$_POST['title'];
$description=$_POST['description'];
$due_date=$_POST['due_date'];
$due_time=$_POST['due_time'];


$sql = $conn->prepare("select class_id from class_teachers where teacher_id=? and class_id=?");
$sql->bind_param("ii",$teacher_id,$class_id);
$sql->execute();
$result=$sql->get_result();

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
if($result->num_rows==0){
  $response=array("status"=>"0","error"=>"Teacher does not have any classes");
  echo json_encode($response);
  exit();
} else{
    $arrayofrows = array();

    while( $row=$result->fetch_array(MYSQLI_ASSOC)){
        if($row['class_id']==$class_id){
            $date_of_upload=date("Y-m-d");
            $sql = $conn->prepare("INSERT INTO assignments (class_id,teacher_id,title,description,due_date,due_time,date_of_upload) VALUES (?,?,?,?,?,?,?)");
            $sql->bind_param("iisssss", $class_id,$teacher_id,$title,$description,$due_date,$due_time,$date_of_upload);
            $sql->execute();
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            if($sql->affected_rows=="0"){
                $response=array('status'=>'0','error'=>'Could not add assignment');
                echo json_encode($response);
                exit();
            }else{
                $response=array('status'=>'1','result'=>'Assignment added.');
                echo json_encode($response);
                exit();
            }
        }
    }
    $response=array('status'=>'0','error'=>'Teacher does not teach in this class');
    echo json_encode($response);
    exit();
  
}

?>