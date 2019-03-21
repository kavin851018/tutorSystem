<?php
session_start();
header('Content-type: application/json');
$db = 'booking';
require('../../../plugin/PHPMailer/PHPMailerAutoload.php');
include('../../connect_db.php');

$all    = explode('&',$_POST['leave']);
$leave  = $all[0];
$tutor  = $all[1];
$date   = $all[2];
$period = $all[3];

$submit = "INSERT INTO `tutor_leave`(`tutor`,`date`,`period`,`leave`) VALUES ('$tutor','$date','$period','$leave')";

if(mysql_query($submit, $conn)){
	//Send mail
	$mail = new PHPMailer;
	$mail->CharSet = "UTF-8";
	$mail->isSMTP();                    // Set mailer to use SMTP
	$mail->Host = $mail_h;  // Specify main and backup SMTP servers
	$mail->SMTPAuth = true;             // Enable SMTP authentication
	$mail->Username = $mail_u; // SMTP username
	$mail->Password = $mail_p;       // SMTP password

	$mail->From = $mail_u.'@'.$mail_h;
	$mail->FromName = '國立中山大學自學園';
	$mail->addAddress($manager_mail);   // Add a recipient

	$mail->isHTML(true); // Set email format to HTML

	$mail->Subject = '小老師請假審核';
	$mail->Body    = $tutor.'欲於'.$date.'申請'.$leave.'。<br>';
	$mail->Body   .= '請至<a href="http://zephyr.nsysu.edu.tw/splendid/clinic/record/status.php">小老師諮詢紀錄繳交狀態</a>核准請假。<br><br>';
	$mail->Body   .= 'Mail auto sent by Tutor Booking System';

	if(!$mail->send()){
		$response['status'] .= $mail->ErrorInfo;
	}
	//Send mail
	$response['status'] = 'success';
}
else
	$response['status'] = mysql_error();
mysql_close($conn);
echo json_encode($response);
?>