$student_id=$_GET['student_id'];

$sql = $conn->prepare("select student_id from students where student_id=?");
$sql->bind_param("s", $student_id);
$sql->execute();
$sql->store_result();
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
if($sql->num_rows=="0"){
    $response=array('status'=>'0','error'=>'Student does not exist');
    echo json_encode($response);
    exit();
}