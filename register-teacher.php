<?php

include('Config\db_connect.php');


header("Content-type: application/json; charset=utf-8");
header('Access-Control-Allow-Origin: http://127.0.0.1:5500');
header('Access-Control-Allow-Methods: POST');
header("Access-Control-Allow-Headers: Content-Type");

// $_POST = json_decode(file_get_contents('php://input'), true);


$email=$last_name=$first_name=$password=$picture_path="";
$response['status']="";
$errors=array('email'=>'','last_name'=>'','first_name'=>'','password'=>'','result'=>'');
$errors['result']='';


$check_email = $conn->prepare('select teacher_id from teachers where email=?');
$check_email->bind_param('s', $_POST['email']);
$check_email->execute();
$check_email->store_result();
if ($check_email->num_rows() == 0) {
    $email=$_POST['email'];
} else {
    $response=array('status'=>'0','error'=>'Email already taken');
    echo json_encode($response);
    exit();
}


if(!isset($_POST['email'])){
    $errors['email']="An email is required";
} else{
    if(filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){
        $email=$_POST['email'];
    } else{
        $response=array('status'=>'0','error'=>'Please enter a valid email');

        echo json_encode($response);
        exit();
    }
}

if(!isset($_POST['first_name'])){
    $errors['first_name']="A first name is required";
} else{
    $first_name=$_POST['first_name'];
}

if(!isset($_POST['last_name'])){
    $errors['last_name']="A last name is required";
} else{
    $last_name=$_POST['last_name'];
}

if(!isset($_POST['password'])){
    $errors['password']="A password is required";
} else{
    $password=$_POST['password'];
}
echo $email;
echo $first_name;
echo $last_name;
echo $password;

if(!empty($email) && !empty($first_name) && !empty($last_name) && !empty($password)){
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $sql = $conn->prepare("insert into teachers (first_name,last_name,email,password,picture_path) values(?,?,?,?,?)");
    $sql->bind_param("sssss", $first_name,$last_name,$email,$hashed_password,$picture_path);
    $sql->execute();
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    if($sql->affected_rows=="0"){
        $response=array('status'=>'0','error'=>'Could not register');
        echo json_encode($response);
        exit();
    }else{
        $response=array('status'=>'1','result'=>'Success');
        echo json_encode($response);
        exit();
    }
}else{
    $response=array('status'=>'0','result'=>'Please fill empty fields');
    echo json_encode($response);
    echo json_encode($errors);
    exit();
}
    

?>