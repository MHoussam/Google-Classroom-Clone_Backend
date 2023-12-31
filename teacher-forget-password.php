<?php
    include('Config\db_connect.php');
    use PHPMailer\PHPMailer\PHPMailer;
    require("PHPMailer\src\SMTP.php");
    require("PHPMailer\src\PHPMailer.php");

        
    header("Content-type: application/json; charset=utf-8");
    header('Access-Control-Allow-Origin: http://127.0.0.1:5500');
    header('Access-Control-Allow-Methods: POST');
    header("Access-Control-Allow-Headers: Content-Type");

    $_POST = json_decode(file_get_contents('php://input'), true);

    $email=$_POST['email'];
    $teacher_id="";
    $sql = $conn->prepare("select teacher_id from teachers where email=?");
    $sql->bind_param("s",$email);
    $sql->execute();
    $sql->store_result();
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    if($sql->num_rows=="0"){
        $response=array("status"=>"0","error"=>"Email does not exist");
        echo json_encode($response);
        exit();
    }
    $sql->bind_result($teacher_id);
    $sql->fetch();
    $reset_token = bin2hex(openssl_random_pseudo_bytes(16));
    $creation_date=date('h:i:s', time());
    $sql = $conn->prepare("INSERT INTO teacher_reset_temps (teacher_id,reset_token,creation_date) VALUES (?,?,?)");
    $sql->bind_param("iss",$teacher_id,$reset_token,$creation_date);
    $sql->execute();
    if($sql->affected_rows=="0"){
        $response=array("status"=>"0","error"=>"Could not create token");
        echo json_encode($response);
        exit();
    } 

    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host = 'sandbox.smtp.mailtrap.io';
    $mail->SMTPAuth = true;
    $mail->Port = 2525;
    $mail->Username = '56ddaa55f02678';
    $mail->Password = 'e5259f71c3dcb4';
    $mail->setFrom('info@mailtrap.io', 'Mailtrap');
    $mail->addAddress($email);
    $mail->Subject = 'Password Recovery';
    $mail->Body = $reset_token;
    if(!$mail->send()){
        $response=array("status"=>"0","error"=> $mail->ErrorInfo);
        echo json_encode($response);
    }else{
        $response=array("status"=>"1","result"=>"Message has been sent");
        echo json_encode($response);;
    }

?> 