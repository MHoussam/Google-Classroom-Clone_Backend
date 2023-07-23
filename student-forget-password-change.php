<?php
    include('Config\db_connect.php');

    // $_POST = json_decode(file_get_contents('php://input'), true);
    $email=$_POST['email'];
    $reset_token=$_POST['reset_token'];
    $new_password=$_POST['new_password'];
    $sql = $conn->prepare("select reset_token,exp_date from password_reset_temps where email=?");
    $sql->bind_param("s",$email);
    $sql->execute();
    $result=$sql->get_result();
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    if($result->num_rows=="0"){
        $response=array("status"=>"0","error"=>"Email does not have token");
        echo json_encode($response);
        exit();
    } else {
        $stored_token='';
        $exp_date='';
        while( $row=$result->fetch_array(MYSQLI_ASSOC)){
            $stored_token = $row['reset_token'];
            $exp_date= $row['exp_date'];
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
        }
    }

?>