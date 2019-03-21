<?php
header('Content-type: application/json');
$db = 'booking';
include('../../connect_db.php');

$tutor_name = mysql_real_escape_string(trim($_POST['tutor_name']));
$date = explode('/', $_POST['date']);
$date = $date[2].'-'.$date[0].'-'.$date[1];
$start_time = $_POST['start_time'];
$end_time = $_POST['end_time'];
$late = ($_POST['late']!=0)?1:0;
$stu_absent = ($_POST['stu_absent']!=0)?1:0;
$stu_name = mysql_real_escape_string(trim($_POST['stu_name']));
$stu_id = mysql_real_escape_string(trim(strtoupper($_POST['stu_id'])));
$stu_dept = $_POST['stu_dept'];
$stu_year = $_POST['stu_year'];
$stu_phone = mysql_real_escape_string(trim($_POST['stu_phone']));
$stu_email = mysql_real_escape_string(trim($_POST['stu_email']));
$record = mysql_real_escape_string(trim(addslashes(nl2br($_POST['record']))));
$suggestion = mysql_real_escape_string(trim(addslashes(nl2br($_POST['suggestion']))));

if($stu_absent==1){
	$submit = "INSERT INTO `record`(`tutor_name`,`date`,`start_time`,`end_time`,`late`,`stu_absent`,`stu_id`) VALUES ('$tutor_name','$date','$start_time','$end_time','$late','$stu_absent','$stu_id')";
}
else{
	$submit = "INSERT INTO `record`(`tutor_name`,`date`,`start_time`,`end_time`,`late`,`stu_absent`,`stu_name`,`stu_id`,`stu_dept`,`stu_year`,`stu_phone`,`stu_email`,`record`,`suggestion`) VALUES ('$tutor_name','$date','$start_time','$end_time','$late','$stu_absent','$stu_name','$stu_id','$stu_dept','$stu_year','$stu_phone','$stu_email','$record','$suggestion')";
}

if(mysql_query($submit, $conn))
	$response['status'] = 'success';
else{
	$response['status'] = mysql_error();
	//mysql_query("INSERT INTO `record`(`tutor_name`,`date`,`start_time`,`end_time`,`stu_id`,`deleted`,`error_log`) VALUES ('$tutor_name','$date','$start_time','$end_time','$stu_id','1','".$response['status']."')",$conn);
}
echo json_encode($response);
mysql_close($conn);
?>