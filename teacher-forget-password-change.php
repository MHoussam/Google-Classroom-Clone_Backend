<?php
    include('Config\db_connect.php');

    
    header("Content-type: application/json; charset=utf-8");
    header('Access-Control-Allow-Origin: http://localhost:5500');
    header('Access-Control-Allow-Methods: POST');
    header("Access-Control-Allow-Headers: Content-Type");

    // $_POST = json_decode(file_get_contents('php://input'), true);

    $email=$_POST['email'];
    $reset_token=$_POST['reset_token'];
    $new_password=$_POST['new_password'];
    $teacher_id="";
    $sql = $conn->prepare("select teacher_id from teachers where email=?");
    $sql->bind_param("s",$email);
    $sql->execute();
    $sql->store_result();
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    if($sql->num_rows=="0"){
        $response=array("status"=>"0","error"=>"Teacher does not exist");
        echo json_encode($response);
        exit();
    }
    $sql->bind_result($teacher_id);
    $sql->fetch();

    $sql = $conn->prepare("select reset_token,creation_date from teacher_reset_temps where teacher_id=?");
    $sql->bind_param("s",$teacher_id);
    $sql->execute();
    $result=$sql->get_result();
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    if($result->num_rows=="0"){
        $response=array("status"=>"0","error"=>"Email does not have token");
        echo json_encode($response);
        exit();
    } else {
        $stored_token='';
        $creation_date='';
        while( $row=$result->fetch_array(MYSQLI_ASSOC)){
            $stored_token = $row['reset_token'];
            $creation_date= $row['creation_date'];
        }
        if($stored_token==$reset_token){
            $new_hashed_pass = password_hash($new_password, PASSWORD_BCRYPT);
            $sql = $conn->prepare("UPDATE teachers SET password=? WHERE email=?");
            $sql->bind_param("ss",$new_hashed_pass,$email);
            $sql->execute();
            if($sql->affected_rows=="0"){
                $response=array('status'=>"0","result"=>"Could not change password");
                echo json_encode($response);
                exit();
            }else{
                $response=array('status'=>"1","result"=>"Password changed");
                echo json_encode($response);
                exit();
            }
        } else{
            $response=array('status'=>"0","error"=>"wrong token");
            echo json_encode($response);
            exit();
        }
    }

?>