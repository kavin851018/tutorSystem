<?php
//connection to mysql and database select
define('HOST', 'localhost');
define('USER_SELF_ACCESS', 'booking');
define('PWD_SELF_ACCESS', 'Zephyr_booking_2016');
define('DB_SELF_ACCESS', 'splendid');
define('DB_BOOKING','booking');

$host = HOST;
$user_self_access = USER_SELF_ACCESS;
$pwd_self_access = PWD_SELF_ACCESS;
$db_self_access = DB_SELF_ACCESS;
$db_booking = DB_BOOKING;

$conn = mysql_connect($host,$user_self_access,$pwd_self_access);

if($conn->connect_error){
    die("Connection failed: ".$conn->connect_error);
}
elseif($db == 'booking'){
	mysql_query("SET NAMES 'utf8'");
	mysql_select_db($db_booking,$conn);
	$mail_h = 'mail.nsysu.edu.tw';
	$mail_u = 'onlinelearning';
	$mail_p = 'jiVx2686';
	$manager_mail = 'dannyjuan@mail.nsysu.edu.tw'; //Manager mail to verify leave
	$ep_mail = 'nsysu.sac@gmail.com'; //English Plaza mail
	//error_reporting(0);
}
else{
	mysql_select_db($db_self_access,$conn);
	error_reporting(0);
}
?>
