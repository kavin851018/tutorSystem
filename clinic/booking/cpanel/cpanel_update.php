<?php
session_start();
header('Content-type: application/json');
$db = 'booking';
require('../../../connect_db.php');
require('../../../../plugin/PHPMailer/PHPMailerAutoload.php');

$login_id = mysql_real_escape_string(trim($_POST['login_id']));
$pw = mysql_real_escape_string(trim($_POST['pw']));
$new_pw = mysql_real_escape_string(trim($_POST['new_pw']));

$rno = $_POST['rno'];

$blacklist_id = trim(strtoupper($_POST['id']));
$blacklist_start_date = $_POST['start_date'];
$blacklist_end_date = date('Y-m-d', strtotime($blacklist_start_date.'+30 days'));

$holiday_start_date = $_POST['start_date'];
$holiday_end_date = $_POST['end_date'];
$holiday_remark = trim($_POST['remark']);

$sem_start_date = $_POST['sem_start_date'];
$sem_end_date = $_POST['sem_end_date'];
$sem_year = trim($_POST['sem_year']);

$tutor_name = trim($_POST['name']);
$tutor_id = trim(strtoupper($_POST['id']));
$tutor_dept = $_POST['dept'];
$tutor_phone = trim($_POST['phone']);
$tutor_email = trim(strtolower($_POST['email']));
$tutor_foreign = ($_POST['foreign'])?1:0; //Check true

//Tutor schedule
$foreign = $_POST['foreign'];
$sem = trim($_POST['sem']);
$desc = str_replace(',',', ',$_POST['desc']); //Replace to selected format
$mon = str_replace(',','-',$_POST['mon']); //Replace to selected format
$tue = str_replace(',','-',$_POST['tue']); //Replace to selected format
$wed = str_replace(',','-',$_POST['wed']); //Replace to selected format
$thu = str_replace(',','-',$_POST['thu']); //Replace to selected format
$fri = str_replace(',','-',$_POST['fri']); //Replace to selected format

switch($_POST['type']){
	case 'login':
		$login = "SELECT * FROM `manager` WHERE `id`='$login_id'";
		$row = @mysql_fetch_row(mysql_query($login));
		if($login_id!=NULL && $pw!=NULL && $row[0]==$login_id && $row[1]==$pw){
			$_SESSION['booking_login'] = $login_id;
			$_SESSION['start'] = time(); //Time now
            $_SESSION['expire'] = $_SESSION['start'] + (60 * 60); //Ending session in 60 minutes from starting time
			$response['status'] = 'success';
		}
		else
			$response['status'] = mysql_error();
		echo json_encode($response);
		mysql_close($conn);
		break;

	case 'update_pw':
		$login_id = $_SESSION['login'];
		$check_pw = @mysql_fetch_row(mysql_query("SELECT * FROM `admin` WHERE `id`='$login_id'"));
		$update_pw = "UPDATE `admin` SET `pw`='$new_pw' WHERE `id`='$login_id'";
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

	//Delete booking
	case 'delete':
		$delete = "UPDATE `appointment` SET `deleted`=1 WHERE `rno`='$rno'";
		if(mysql_query($delete, $conn))
			$response['status'] = 'success';
		else
			$response['status'] = mysql_error();
		echo json_encode($response);
		mysql_close($conn);
		break;

	//Create blacklist
	case 'create_blacklist':
		$create_blacklist = "INSERT INTO `blacklist`(`id`,`start_date`,`end_date`) VALUES ('$blacklist_id','$blacklist_start_date','$blacklist_end_date')";
		$remove_blacklist_booking = "UPDATE `appointment` SET `deleted`=1 WHERE `date`>='$blacklist_start_date' AND `id`='$blacklist_id'"; //Remove all future booking after blacklist
		if(mysql_query($create_blacklist, $conn)){
			mysql_query($remove_blacklist_booking,$conn);
			$stu_email = mysql_fetch_assoc(mysql_query("SELECT `email` FROM `appointment` WHERE `id`='$blacklist_id' AND `deleted`=0 ORDER BY `rno` DESC LIMIT 1"));
			send_blacklist_email($stu_email['email'],$blacklist_start_date,$blacklist_end_date,$mail_h,$mail_u,$mail_p);
			$response['status'] = 'success';
		}
		else
			$response['status'] = mysql_error();
		echo json_encode($response);
		mysql_close($conn);
		break;

	//Delete blacklist
	case 'delete_blacklist':
		$delete_blacklist = "UPDATE `blacklist` SET `deleted`=1 WHERE `rno`='$rno'";
		if(mysql_query($delete_blacklist, $conn))
			$response['status'] = 'success';
		else
			$response['status'] = mysql_error();
		echo json_encode($response);
		mysql_close($conn);
		break;
	default:
		break;

	//Create holiday
	case 'create_holiday':
		$create_holiday = "INSERT INTO `holiday`(`start_date`,`end_date`,`remark`) VALUES ('$holiday_start_date','$holiday_end_date','$holiday_remark')";
		if(mysql_query($create_holiday, $conn)){
			$response['status'] = 'success';
		}
		else
			$response['status'] = mysql_error();
		echo json_encode($response);
		mysql_close($conn);
		break;

	//Delete holiday
	case 'delete_holiday':
		$delete_holiday = "DELETE FROM `holiday` WHERE `rno`='$rno'";
		if(mysql_query($delete_holiday, $conn))
			$response['status'] = 'success';
		else
			$response['status'] = mysql_error();
		echo json_encode($response);
		mysql_close($conn);
		break;
	default:
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

	//Create tutor
	case 'create_tutor':
		$check = mysql_fetch_array(mysql_query("SELECT * FROM `tutor` WHERE `deleted`=0 AND `name`='$tutor_name' OR `id`='$tutor_id'" ));
		$create_tutor = "INSERT INTO `tutor`(`name`,`id`,`dept`,`phone`,`email`,`foreign`) VALUES ('$tutor_name','$tutor_id','$tutor_dept','$tutor_phone','$tutor_email','$tutor_foreign')";
		if($check['name']==$tutor_name || $check['id']==$tutor_id){
			$response['status'] = 'exist';
		}
		else{
			if(mysql_query($create_tutor, $conn)){
				$response['status'] = 'success';
			}
			else
				$response['status'] = mysql_error();
		}
		echo json_encode($response);
		mysql_close($conn);
		break;
	//Edit tutor
	case 'edit_tutor':
		$edit_tutor = "UPDATE `tutor` SET  `name` =  '$tutor_name' , `id` =  '$tutor_id' ,  `dept` =  '$tutor_dept' ,
		`phone` =  '$tutor_phone' ,  `email` =  '$tutor_email'   WHERE `rno` ='$rno' LIMIT 1 ";
		if(mysql_query($edit_tutor, $conn))
			$response['status'] = "success";
		else
			$response['status'] = mysql_error();

		echo json_encode($response);
		mysql_close($conn);
		break;
	//Delete tutor
	case 'delete_tutor':
		$delete_tutor = "UPDATE `tutor` SET `deleted`=1 WHERE `rno`='$rno'";
		if(mysql_query($delete_tutor, $conn))
			$response['status'] = 'success';
		else
			$response['status'] = mysql_error();
		echo json_encode($response);
		mysql_close($conn);
		break;

	//Create tutor schedule
	case 'create_schedule':
		$check = mysql_fetch_array(mysql_query("SELECT * FROM `schedule` WHERE `tutor_name`='$tutor_name' AND `semester`= '$sem' AND `deleted`=0"));
		$tutor_name=$tutor_name.'-'. hash('ripemd160', $desc);
		$create_schedule = "INSERT INTO `schedule`(`tutor_name`,`foreign`,`semester`,`desc`,`mon`,`tue`,`wed`,`thu`,`fri`) VALUES ('$tutor_name','$foreign','$sem','$desc','$mon','$tue','$wed','$thu','$fri')";
	if($check['tutor_name']==$tutor_name && $check['semester']==$sem){
				$response['status'] = 'exist';
		}
		else{
			if(mysql_query($create_schedule, $conn)){
				$response['status'] = 'success';
			}
			else
				$response['status'] = mysql_error();
		}
		echo json_encode($response);
		mysql_close($conn);
		break;

	//Delete tutor
	case 'delete_schedule':
		$delete_schedule = "UPDATE `schedule` SET `deleted`=1 WHERE `rno`='$rno'";
		if(mysql_query($delete_schedule, $conn))
			$response['status'] = 'success';
		else
			$response['status'] = mysql_error();
		echo json_encode($response);
		mysql_close($conn);
		break;

	default:
		break;
}

function send_blacklist_email($email,$start_date,$end_date,$mail_host,$mail_user,$mail_pw){
	$start_b_date = explode('-',$start_date);
	$end_b_date = explode('-',$end_date);
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

	$mail->Subject = '[小老師諮詢預約]黑名單通知';
	$mail->Body    = '同學您好，<br><br>';
	$mail->Body   .= '由於您於'.$start_b_date[0].'年'.$start_b_date[1].'月'.$start_b_date[2].'日缺席／遲到超過10分鐘，依小老師預約規則將您列入黑名單。<br>';
	$mail->Body   .= '黑名單時間於'.$end_b_date[0].'年'.$end_b_date[1].'月'.$end_b_date[2].'日結束，謝謝。<br><br><br><br>';
	$mail->Body   .= '國立中山大學自學園<br>Mail sent automatically by Tutor Booking System';

	if(!$mail->send()){
		$response['status'] .= $mail->ErrorInfo;
	}
}
?>
