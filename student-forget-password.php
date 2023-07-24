<?php
    include('Config\db_connect.php');
    use PHPMailer\PHPMailer\PHPMailer;
    require("PHPMailer\src\SMTP.php");
    require("PHPMailer\src\PHPMailer.php");

    // $_POST = json_decode(file_get_contents('php://input'), true);
    
    $email=$_POST['email'];
    $sql = $conn->prepare("select student_id from students where email=?");
    $sql->bind_param("s",$email);
    $sql->execute();
    $sql->store_result();
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    if($sql->num_rows=="0"){
        $response=array("status"=>"0","error"=>"Email does not exist");
        echo json_encode($response);
        exit();
    }
    $sql->bind_result($student_id);
    $sql->fetch();
    $reset_token = bin2hex(openssl_random_pseudo_bytes(16));
    $creation_date=date('h:i:s', time());
    $sql = $conn->prepare("INSERT INTO student_reset_temps (student_id,reset_token,creation_date) VALUES (?,?,?)");
    $sql->bind_param("iss",$student_id,$reset_token,$creation_date);
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
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    }else{
        echo 'Message has been sent';
    }

?> 