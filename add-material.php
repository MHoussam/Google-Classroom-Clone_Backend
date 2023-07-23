<?php
include('Config\db_connect.php');

// $_POST = json_decode(file_get_contents('php://input'), true);


$class_id=$_POST['class_id'];
$teacher_id=$_POST['teacher_id'];
$title=$_POST['title'];
$description=$_POST['description'];
$path=$_POST['path'];


$sql = $conn->prepare("select class_id from classes where teacher_id=?");
$sql->bind_param("s",$teacher_id);
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
            $sql = $conn->prepare("INSERT INTO materials (class_id,title,description,path,date_of_upload) VALUES (?,?,?,?,?)");
            $sql->bind_param("sssss", $class_id,$title,$description,$path,date("Y/m/d"));
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
    }
    $response=array('status'=>'0','error'=>'Teacher does not teach in this class');
    echo json_encode($response);
    exit();
  
}

?>