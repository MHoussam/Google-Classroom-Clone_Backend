<?
$teacher_id=$_GET['teacher_id'];
$sql = $conn->prepare("select teacher_id from teachers where teacher_id=?");
$sql->bind_param("s", $teacher_id);
$sql->execute();
$sql->store_result();
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
if($sql->num_rows=="0"){
    $response=array('status'=>'0','error'=>'Teacher does not exist');
    echo json_encode($response);
    exit();
}
?>