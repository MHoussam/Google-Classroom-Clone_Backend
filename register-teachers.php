<?php

include('Config\db_connect.php');
$email=$last_name=$first_name=$password=$picture_path=$username="";
$response['status']="";
$errors=array('email'=>'','last_name'=>'','first_name'=>'','password'=>'','result'=>'');
// $_POST = json_decode(file_get_contents('php://input'), true);
$errors['result']='';


header("Content-type: application/json; charset=utf-8");
header('Access-Control-Allow-Origin: http://127.0.0.1:5500');
header('Access-Control-Allow-Methods: POST');
header("Access-Control-Allow-Headers: Content-Type");



$check_email = $conn->prepare('select user_id from teachers where email=?');
$check_email->bind_param('s', $_POST['email']);
$check_email->execute();
$check_email->store_result();
if ($check_email->num_rows() == 0) {
    $email=$_POST['email'];
} else {
    $response['status']="0";
    $response['error']='email already taken';
    echo json_encode($response);
    exit();
}
$check_username = $conn->prepare('select user_id from teachers where username=?');
$check_username->bind_param('s', $_POST['username']);
$check_username->execute();
$check_username->store_result();
if ($check_username->num_rows() == 0) {
    $username=$_POST['username'];
} else {
    $response['status']="0";
    $response['error']='username already taken';
    echo json_encode($response);
    exit();
}


if(empty($_POST['email'])){
    $errors['email']="An email is required";
} else{
    if(filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){
        $email=$_POST['email'];
    } else{
        $response['status']="0";
        $response['error']='Please enter a valid email';
        echo json_encode($response);
        exit();
    }
}

if(empty($_POST['first_name'])){
    $errors['first_name']="A first name is required";
} else{
    $first_name=$_POST['first_name'];
}

if(empty($_POST['last_name'])){
    $errors['last_name']="A last name is required";
} else{
    $last_name=$_POST['last_name'];
}

if(empty($_POST['password'])){
    $errors['password']="A password is required";
} else{
    $password=$_POST['password'];
}

if(!empty($email) && !empty($username) && !empty($first_name) && !empty($last_name) && !empty($password)){
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $sql = $conn->prepare("insert into teachers (first_name,last_name,username,email,password) values(?,?,?,?,?)");
    $sql->bind_param("sssssss", $first_name,$last_name,$username,$email,$hashed_password);
    $sql->execute();
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    if($sql->get_result()){
        $response['status']="0";
        $errors['result']='Could not register';
        echo json_encode($response);
        echo json_encode($errors);
        exit();
    }else{
        $response['status']="1";
        echo json_encode($response);
        exit();
    }
}else{
    $response['status']="0";
    $errors['result']='Please fill empty fields';
    echo json_encode($response);
    echo json_encode($errors);
    exit();
}
    

?>