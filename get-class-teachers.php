<?php

include('Config\db_connect.php');

header("Content-type: application/json; charset=utf-8");
header('Access-Control-Allow-Origin: http://127.0.0.1:5500');
header('Access-Control-Allow-Methods: GET');
header("Access-Control-Allow-Headers: Content-Type");

$_POST = json_decode(file_get_contents('php://input'), true);

$token_value=$_POST['token_value'];

include('authentication-validation.php');

if(isset($_GET['class_id'])){
    $class_id=$_GET['class_id'];
    $sql = $conn->prepare("select first_name,last_name from teachers where teacher_id IN (select teacher_id from class_teachers where class_id=?)");
    $sql->bind_param("i",$class_id);
    $sql->execute();
    $result=$sql->get_result();
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $arrayofrows = array();
    if($result->num_rows=="0"){
        $response=array("status"=>"0","error"=>"No teachers");
        echo json_encode($response);
        exit();
    } else {
        while( $row=$result->fetch_array(MYSQLI_ASSOC)){
            $arrayofrows[] = $row;
        }
        echo json_encode($arrayofrows);
        exit();
    }
} else {
    $response=array('status'=>0,'error'=>'Please provide class id');
    echo json_encode($response);
    exit();
}


?>