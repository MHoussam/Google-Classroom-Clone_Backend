<?php
include('Config\db_connect.php');

header("Content-type: application/json; charset=utf-8");
header('Access-Control-Allow-Origin: http://127.0.0.1:5500');
header('Access-Control-Allow-Methods: POST');
header("Access-Control-Allow-Headers: Content-Type");

$_POST = json_decode(file_get_contents('php://input'), true);

$token_value=$_POST['token_value'];

include('teacher-authentication-validation.php');

$class_id=$_POST['class_id'];
$teacher_id=$_POST['teacher_id'];
$title=$_POST['title'];
$description=$_POST['description'];
$path=$_POST['path'];


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
            $creation_date = date("Y-m-d H:i:s");
            $sql = $conn->prepare("INSERT INTO materials (class_id,teacher_id,title,description,path) VALUES (?,?,?,?,?)");
            $sql->bind_param("iisss", $class_id,$teacher_id,$title,$description,$path);
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