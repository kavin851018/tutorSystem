<?php
header('Content-type: application/json');
$db = 'booking';
require('../../../plugin/PHPMailer/PHPMailerAutoload.php');
require('../../connect_db.php');

$leave = $_POST['leave'];
$rno = $_POST['rno'];
$tutor = $_POST['tutor'];
$date = $_POST['date'];
$period = $_POST['period'];
$leave_result = ($leave==1)?'通過':'不通過';
$tutor_email = mysql_fetch_assoc(mysql_query("SELECT `email` FROM `tutor` WHERE `name`='$tutor'"));
$stu_email = mysql_fetch_assoc(mysql_query("SELECT `email` FROM `appointment` WHERE `date`='$date' AND `period`='$period' AND `tutor`='$tutor'"));

$leave_sql = "UPDATE `tutor_leave` SET `approve`='$leave' WHERE `rno`='$rno'";
if(mysql_query($leave_sql, $conn)){
	//Send mail to tutor
	$mail = new PHPMailer;
	$mail->CharSet = "UTF-8";
	$mail->isSMTP();                    // Set mailer to use SMTP
	$mail->Host = $mail_h;  // Specify main and backup SMTP servers
	$mail->SMTPAuth = true;             // Enable SMTP authentication
	$mail->Username = $mail_u; // SMTP username
	$mail->Password = $mail_p;       // SMTP password

	$mail->From = $mail_u.'@'.$mail_h;
	$mail->FromName = '國立中山大學自學園';
	$mail->addAddress($tutor_email['email']);   // Add a recipient

	$mail->isHTML(true); // Set email format to HTML

	$mail->Subject = '小老師請假審核結果';
	$mail->Body    = '您申請於'.$date.'的假期'.$leave_result.'。';
	$mail->Body   .= '<br><br><br><br>';
	$mail->Body   .= '國立中山大學自學園<br>Mail sent automatically by Tutor Booking System';

	if(!$mail->send()){
		$response['status'] .= $mail->ErrorInfo;
	}
	
	if($leave == 1 && $stu_email['email']){ //Tutor leave approved & has student appointment
		//Send mail to student
		$mail = new PHPMailer;
		$mail->CharSet = "UTF-8";
		$mail->isSMTP();                    // Set mailer to use SMTP
		$mail->Host = $mail_h;  // Specify main and backup SMTP servers
		$mail->SMTPAuth = true;             // Enable SMTP authentication
		$mail->Username = $mail_u; // SMTP username
		$mail->Password = $mail_p;       // SMTP password

		$mail->From = $mail_u.'@'.$mail_h;
		$mail->FromName = '國立中山大學自學園';
		$mail->addAddress($stu_email['email']);   // Add a recipient 

		$mail->isHTML(true); // Set email format to HTML

		$mail->Subject = '小老師預約取消';
		$mail->Body    = '同學您好，<br><br>';
		$mail->Body   .= '由於小老師請假，您於'.$date.' '.$period.':10~'.($period+1).':00的諮詢預約將取消，<br>';
		$mail->Body   .= '造成不便敬請見諒，謝謝。 <br><br>';
		$mail->Body   .= '國立中山大學自學園<br>Mail sent automatically by Tutor Booking System';

		if(!$mail->send()){
			$response['status'] .= $mail->ErrorInfo;
		}

		//Send mail to English Plaza gmail
		$mail = new PHPMailer;
		$mail->CharSet = "UTF-8";
		$mail->isSMTP();                    // Set mailer to use SMTP
		$mail->Host = $mail_h;  // Specify main and backup SMTP servers
		$mail->SMTPAuth = true;             // Enable SMTP authentication
		$mail->Username = $mail_u; // SMTP username
		$mail->Password = $mail_p;       // SMTP password

		$mail->From = $mail_u.'@'.$mail_h;
		$mail->FromName = '國立中山大學自學園';
		$mail->addAddress($ep_mail);   // Add a recipient

		$mail->isHTML(true); // Set email format to HTML

		$mail->Subject = '小老師預約取消';
		$mail->Body    = $tutor.'於'.$date.' '.$period.':10~'.($period+1).':00請假。<br>';
		$mail->Body   .= '請電話通知學生不必出席，謝謝。<br><br>';
		$mail->Body   .= '國立中山大學自學園<br>Mail sent automatically by Tutor Booking System';

		if(!$mail->send()){
			$response['status'] .= $mail->ErrorInfo;
		}
	}

	$response['status'] = 'success';
}
else
	$response['status'] = mysql_error();

mysql_close($conn);
echo json_encode($response);
?>