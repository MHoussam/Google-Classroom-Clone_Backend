<?php

if(isset($_POST['token_value'])){
    $token_value=$_POST['token_value'];
    $sql = $conn->prepare("select token_id from student_tokens where token_value=?");
    $sql->bind_param("s",$token_value);
    $sql->execute();
    $sql->store_result();
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    if($sql->num_rows=="0"){
        $token_value=$_POST['token_value'];
        $sql = $conn->prepare("select token_id from teacher_tokens where token_value=?");
        $sql->bind_param("s",$token_value);
        $sql->execute();
        $sql->store_result();
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        if($sql->num_rows=="0"){
            $response=array("status"=>"0","error"=>"Authentication required");
            echo json_encode($response);
            exit();
        }   
    }
} else {
    $response=array("status"=>"0","error"=>"Authentication required");
    echo json_encode($response);
    exit();   
}
?>