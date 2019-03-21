<?php
header('Content-type: application/json');
$db = 'booking';
require('../../connect_db.php');
require('../../../plugin/PHPMailer/PHPMailerAutoload.php');

$name = mysql_real_escape_string(trim($_POST['name']));
$id = mysql_real_escape_string(trim(strtoupper($_POST['id'])));
$phone = mysql_real_escape_string(trim($_POST['phone']));
$email = mysql_real_escape_string(trim(strtolower($_POST['email'])));
$content = $_POST['learn_content'];
$date = $_POST['date'];
$this_monday = (date('l',strtotime($date)) == 'Monday')?date('Y-m-d',strtotime('this monday',strtotime($date))):date('Y-m-d',strtotime('last monday',strtotime($date)));
$this_friday = date('Y-m-d',strtotime($this_monday.' +4 days'));
$period = $_POST['period'];
$tutor = $_POST['tutor'];
$foreign = $_POST['foreign'];

switch($_POST['type']){
	case 'register':
		$id_check = mysql_fetch_assoc(mysql_query("SELECT * FROM `appointment` WHERE `id`='$id' AND `date`='$date' AND `period`='$period' AND `deleted`=0"));
		$period_check = mysql_fetch_assoc(mysql_query("SELECT * FROM `appointment` WHERE `date`='$date' AND `period`='$period' AND `tutor`='$tutor' AND `foreign`=0 AND `deleted`=0 LIMIT 1"));
		$blacklist_check = mysql_fetch_assoc(mysql_query("SELECT * FROM `blacklist` WHERE ('$date' BETWEEN `start_date` AND `end_date`) AND `id`='$id' AND `deleted`=0 LIMIT 1"));
		$register_limit_check = mysql_num_rows(mysql_query("SELECT * FROM `appointment` WHERE `id`='$id' AND (`date` BETWEEN '$this_monday' AND '$this_friday') AND `deleted`=0"));
		$register = "INSERT INTO `appointment`(`name`,`id`,`phone`,`email`,`content`,`date`,`period`,`tutor`,`foreign`) VALUES ('$name','$id','$phone','$email','$content','$date','$period','$tutor','$foreign')";
		if($id_check['id']==$id && $id_check['date']==$date && $id_check['period']==$period){ //Check if same person made appointment at same period
			$response['status'] = 'exist';
		}
		elseif($period_check['date']!=null && $period_check['period']!=null && $period_check['tutor']==$tutor){ //Check if same period has appointment
			$response['status'] = 'period exist';
		}
		elseif($blacklist_check['id']!=null && $blacklist_check['start_date']!=null){ //Check blacklist
			$response['status'] = 'blacklist exist';
		}
		elseif($register_limit_check >= 4){ //Check register limit
			$response['status'] = 'register limit';
		}
		else{
			if(mysql_query($register, $conn)){
				$response['status'] = 'success';
				send_register_email($email,$date,$period,$mail_h,$mail_u,$mail_p);
			}
			else
				$response['status'] = mysql_error();
		}
		echo json_encode($response);
		mysql_close($conn);
		break;

	case 'delete':
		$check = mysql_fetch_assoc(mysql_query("SELECT * FROM `appointment` WHERE `name`='$name' AND `id`='$id' AND `phone`='$phone' AND `date`='$date' AND `period`='$period' AND `tutor`='$tutor' AND `deleted`=0 LIMIT 1"));
		$delete = "UPDATE `appointment` SET `deleted`=1 WHERE `name`='$name' AND `id`='$id' AND `phone`='$phone' AND `date`='$date' AND `period`='$period' AND `tutor`='$tutor'";
		if($check['name']!=$name || $check['id']!=$id || $check['phone']!=$phone){
			$response['status'] = 'check failed';
		}
		else{
			if(mysql_query($delete, $conn))
				$response['status'] = 'success';
			else
				$response['status'] = mysql_error();
		}
		echo json_encode($response);
		mysql_close($conn);
		break;

	default:
		break;
}

function send_register_email($email,$date,$period,$mail_host,$mail_user,$mail_pw){
	$date = date('Y/m/d',strtotime($date));
	//Send mail
	$mail = new PHPMailer;
	$mail->CharSet = "UTF-8";
	$mail->isSMTP();                    // Set mailer to use SMTP
	$mail->Host = $mail_host;  // Specify main and backup SMTP servers
	$mail->SMTPAuth = true;             // Enable SMTP authentication
	$mail->Username = $mail_user; // SMTP username
	$mail->Password = $mail_pw;       // SMTP password

	$mail->From = $mail_user.'@'.$mail_host;
	$mail->FromName = '國立中山大學自學園';
	$mail->addAddress($email); // Add a recipient

	$mail->isHTML(true); // Set email format to HTML

	$mail->Subject = '[小老師諮詢預約]成功預約通知';
	$mail->Body    = '同學您好，<br><br>';
	$mail->Body   .= '感謝您預約小老師諮詢，您預約的諮詢時間為'.$date.' '.$period.':10~'.($period+1).':00。<br>';
	$mail->Body   .= '提醒您若因故無法出席，請自行線上取消預約，取消時間將於預約諮詢的前一日中午12:00截止。<br>';
	$mail->Body   .= '敬請參閱<a href="zephyr.nsysu.edu.tw/splendid/clinic/booking/#rules">小老師諮詢預約規則</a>並準時出席，謝謝。<br>';
	$mail->Body   .= '<br><br><br>';
	$mail->Body   .= '國立中山大學自學園<br>Mail sent automatically by Tutor Booking System';

	if(!$mail->send()){
		$response['status'] .= $mail->ErrorInfo;
	}
}
?>
