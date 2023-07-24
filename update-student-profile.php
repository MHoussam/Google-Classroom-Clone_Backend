<?php

include('Config\db_connect.php');

header("Content-type: application/json; charset=utf-8");
header('Access-Control-Allow-Origin: http://localhost:5500');
header('Access-Control-Allow-Methods: POST');
header("Access-Control-Allow-Headers: Content-Type");

if(isset($_POST['student_id']) && isset($_POST['first_name']) && isset($_POST['last_name'])){

    $student_id=$_POST['student_id'];
    $first_name=$_POST['first_name'];
    $last_name=$_POST['last_name'];

    $sql = $conn->prepare("UPDATE students SET first_name=?,last_name=? WHERE student_id=?");   
    $sql->bind_param("ssi",$first_name,$last_name,$student_id);
    $sql->execute();
    $sql->store_result();
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    if($sql->affected_rows=="0"){
        $response=array('status'=>"0","error"=>"Could not update profile info");
        echo json_encode($response);
        exit();
    }else{
        $response=array('status'=>"1","result"=>"Profile info updated");
        echo json_encode($response);
        exit();
    }
} 

?>