<?php
$teacher_id=$_POST['teacher_id'];
$class_name=$_POST['class_name'];
$sql = $conn->prepare("insert into classes (teacher_id,class_name) values(?,?)");
    $sql->bind_param("ss", $teacher_id,$class_name);
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

?>