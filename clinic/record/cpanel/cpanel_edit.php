<?php
session_start();
header('Content-type: application/json');
$db = 'booking';
require('../../../../plugin/PHPMailer/PHPMailerAutoload.php');
require('../../../connect_db.php');

$rno = $_POST['rno'];
$tutor_name = $_POST['tutor_name'];
$date = $_POST['date'];
$start_time = $_POST['start_time'];
$end_time = $_POST['end_time'];
$stu_name = $_POST['stu_name'];
$stu_id = strtoupper($_POST['stu_id']);
$stu_dept = $_POST['stu_dept'];
$stu_year = $_POST['stu_year'];
$stu_phone = $_POST['stu_phone'];
$stu_email = mysql_real_escape_string(trim($_POST['stu_email']));
$record = mysql_real_escape_string(trim(addslashes(nl2br($_POST['record']))));
$suggestion = mysql_real_escape_string(trim(addslashes(nl2br($_POST['suggestion']))));

$login_id = mysql_real_escape_string(trim($_POST['login_id']));
$pw = mysql_real_escape_string(trim($_POST['pw']));
$new_pw = mysql_real_escape_string(trim($_POST['new_pw']));

//Manual tutor leave
$tutor = $_POST['tutor'];
$period = $_POST['period'];
$reason = $_POST['reason'];

$sem_start_date = $_POST['sem_start_date'];
$sem_end_date = $_POST['sem_end_date'];
$sem_year = $_POST['sem_year'];


switch($_POST['type']){
	case 'delete':
		$delete = "UPDATE `record` SET `deleted`='1' WHERE `rno`='$rno'";
		if(mysql_query($delete, $conn))
			$response['status'] = 'success';
		else
			$response['status'] = mysql_error();
		echo json_encode($response);
		mysql_close($conn);
		break;

	case 'edit':
		$edit = "UPDATE `record` SET `tutor_name`='$tutor_name',`date`='$date',`start_time`='$start_time',`end_time`='$end_time',`stu_name`='$stu_name',`stu_id`='$stu_id',`stu_dept`='$stu_dept',`stu_year`='$stu_year',`stu_phone`='$stu_phone',`stu_email`='$stu_email',`record`='$record',`suggestion`='$suggestion' WHERE `rno`='$rno'";
		if(mysql_query($edit, $conn))
			$response['status'] = 'success';
		else
			$response['status'] = mysql_error();
		echo json_encode($response);
		mysql_close($conn);
		break;

	case 'login':
		$login = "SELECT * FROM `manager` WHERE `id`='$login_id'";
		$row = @mysql_fetch_row(mysql_query($login));
		if($login_id!=NULL && $pw!=NULL && $row[0]==$login_id && $row[1]==$pw){
			$_SESSION['record_login'] = $login_id;
			$_SESSION['start'] = time(); //Time now
            $_SESSION['expire'] = $_SESSION['start'] + (60 * 30); //Ending session in 30 minutes from starting time
			$response['status'] = 'success';
		}
		else
			$response['status'] = mysql_error();
		echo json_encode($response);
		mysql_close($conn);
		break;

	case 'update_pw':
		$login_id = $_SESSION['login'];
		$check_pw = @mysql_fetch_row(mysql_query("SELECT * FROM `manager` WHERE `id`='$login_id'"));
		$update_pw = "UPDATE `user` SET `passwd`='$new_pw' WHERE `id`='$login_id'";
		if($check_pw[1]===$pw){
			if(mysql_query($update_pw, $conn))
				$response['status'] = 'success';
			else
				$response['status'] = mysql_error();
		}
		else
			$response['status'] = 'Old password incorrect.';
		echo json_encode($response);
		mysql_close($conn);
		break;

	//Create semester
	case 'create_sem':
		$create_sem = "INSERT INTO `semester`(`sem_start_date`,`sem_end_date`,`sem_year`) VALUES ('$sem_start_date','$sem_end_date','$sem_year')";
		if(mysql_query($create_sem, $conn)){
			$response['status'] = 'success';
		}
		else
			$response['status'] = mysql_error();
		echo json_encode($response);
		mysql_close($conn);
		break;

	//Delete semester
	case 'delete_sem':
		$delete_sem = "DELETE FROM `semester` WHERE `rno`='$rno'";
		if(mysql_query($delete_sem, $conn))
			$response['status'] = 'success';
		else
			$response['status'] = mysql_error();
		echo json_encode($response);
		mysql_close($conn);
		break;

	//Create tutor leave
	case 'create_leave':
		$stu_email = mysql_fetch_assoc(mysql_query("SELECT `email` FROM `appointment` WHERE `date`='$date' AND `period`='$period' AND `tutor`='$tutor'"));
		$create_leave = "INSERT INTO `tutor_leave`(`tutor`,`date`,`period`,`leave`,`approve`) VALUES ('$tutor','$date','$period','$reason','1')";
		if(mysql_query($create_leave, $conn)){
			if($stu_email['email']){ //Tutor leave approved & has student appointment
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
			$response['status'] = $tutor;
		echo json_encode($response);
		mysql_close($conn);
		break;

	default:
		break;
}
?>