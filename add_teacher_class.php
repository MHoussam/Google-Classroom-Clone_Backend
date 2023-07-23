<?php
include('Config\db_connect.php');

// $_POST = json_decode(file_get_contents('php://input'), true);
$teacher_id=$_POST['teacher_id'];
$class_name=$_POST['class_name'];
$section=$_POST['section'];
$subject=$_POST['subject'];
$room=$_POST['room'];
$meet_link=$_POST['meet_link'];
$sql = $conn->prepare("insert into classes (teacher_id,class_name,section,subject,room,meet_link) values(?,?,?,?,?,?)");
    $sql->bind_param("ssssss", $teacher_id,$class_name,$section,$subject,$room,$meet_link);
    $sql->execute();
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    if($sql->affected_rows=="0"){
        $response=array('status'=>'0','error'=>'could not add class');
        echo json_encode($response);
        exit();
    }else{
        $response=array('status'=>'1','result'=>'Class added.');
        echo json_encode($response);
        exit();
    }

?>