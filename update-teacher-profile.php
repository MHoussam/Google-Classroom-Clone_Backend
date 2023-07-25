<?php

include('Config\db_connect.php');

header("Content-type: application/json; charset=utf-8");
header('Access-Control-Allow-Origin: http://127.0.0.1:5500');
header('Access-Control-Allow-Methods: POST');
header("Access-Control-Allow-Headers: Content-Type");

$_POST = json_decode(file_get_contents('php://input'), true);

if(isset($_POST['teacher_id']) && isset($_POST['first_name']) && isset($_POST['last_name'])){

    $teacher_id=$_POST['teacher_id'];
    $first_name=$_POST['first_name'];
    $last_name=$_POST['last_name'];

    $sql = $conn->prepare("UPDATE teachers SET first_name=?,last_name=? WHERE teacher_id=?");   
    $sql->bind_param("ssi",$first_name,$last_name,$teacher_id);
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