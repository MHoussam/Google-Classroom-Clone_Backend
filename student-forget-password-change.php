<?php
    include('Config\db_connect.php');

    // $_POST = json_decode(file_get_contents('php://input'), true);
    $email=$_POST['email'];
    $reset_token=$_POST['reset_token'];
    $new_password=$_POST['new_password'];
    $student_id="";
    $sql = $conn->prepare("select student_id from students where email=?");
    $sql->bind_param("s",$email);
    $sql->execute();
    $sql->store_result();
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    if($sql->num_rows=="0"){
        $response=array("status"=>"0","error"=>"Student does not exist");
        echo json_encode($response);
        exit();
    }
    $sql->bind_result($student_id);
    $sql->fetch();
    $sql = $conn->prepare("select reset_token,creation_date from student_reset_temps where student_id=?");
    $sql->bind_param("s",$student_id);
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
            $sql = $conn->prepare("UPDATE students SET password=? WHERE email=?");
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
        } else {
            $response=array('status'=>"0","error"=>"wrong token");
            echo json_encode($response);
            exit();
        }
    }

?>