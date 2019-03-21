<?php
session_start();
$db = 'booking';
require('../../../connect_db.php');

//Select semester
$today = date('Y-m-d');
$semester = mysql_fetch_array(mysql_query("SELECT * FROM `semester` WHERE '$today' BETWEEN `sem_start_date` AND `sem_end_date`"));
$sem_start_date = $semester['sem_start_date'];
$sem_end_date = $semester['sem_end_date'];
$sem = ($semester['sem_year']==NULL)?'x':$semester['sem_year'];
//Select semester
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex">
<!--[if IE]>
<p style="text-align:center;font-size:24px;padding:100px 0;">Your IE version is too old.<br>Please upgrade or change to <a href="https://www.google.com/chrome/">Google Chrome</a> / <a href="https://www.mozilla.org/firefox/">Mozilla Firefox</a> for better experiences.</p>
<![endif]-->
<title>諮詢記錄管理後台</title>
<link rel="stylesheet" type="text/css" href="../../../../plugin/semantic/dist/semantic.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.rawgit.com/mdehoog/Semantic-UI/6e6d051d47b598ebab05857545f242caf2b4b48c/dist/components/calendar.min.css" />
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
<script type="text/javascript" src="../../../../plugin/semantic/dist/semantic.min.js"></script>
<script type="text/javascript" src="https://cdn.rawgit.com/mdehoog/Semantic-UI/6e6d051d47b598ebab05857545f242caf2b4b48c/dist/components/calendar.min.js"></script>
<script type="text/javascript" src="../scripts/cpanel.js"></script>
<link rel="stylesheet" type="text/css" href="cpanel.css">
<style>
body > .grid{
	height: 100%;
}
</style>
</head>
<body>
	<?php
	if($_SESSION['record_login']==null){
		echo '
		<div class="ui middle aligned center aligned grid">
			<div class="column" style="width:450px;">
				<h2 class="ui blue header">
			      	<div class="content">小老師諮詢紀錄管理後台</div>
			    </h2>
				<form class="ui form login" action="cpanel_edit.php" method="post">
				<div class="ui segment">
					<div class="field">
					    <div class="ui left icon input focus">
					    	<i class="user icon"></i>
					    	<input type="text" name="login_id" placeholder="ID">
					    </div>
					</div>
					<div class="field">
					    <div class="ui left icon input">
					    	<i class="lock icon"></i>
					    	<input type="password" name="pw" placeholder="Password">
					    </div>
					</div>
					<button type="submit" class="ui fluid large blue button login">登入</button>
				</div>
				</form>
				<div class="ui success message">
					<p>登入成功，請稍候</p>
				</div>
				<div class="ui error message">
					<p>帳號或密碼不正確，請重新嘗試登入。</p>
				</div>
			</div>
		</div>';
	}
	elseif($_SESSION['record_login'] == 'admin'){
		$now = time();
		if($now>$_SESSION['expire']){
			session_destroy();
			header('Refresh:0');
		}
		else{
			echo '
			<i id="back-to-top" class="arrow up big icon"></i>
			<div class="ui container" style="padding:10px 0px;">
				<h2 class="ui center aligned header">諮詢紀錄管理後台</h2>
				<div class="ui blue four item menu">
					<a class="item" data-url="status">諮詢紀錄狀態</a>
					<a class="item" data-url="view_record">查看諮詢紀錄</a>
					<a class="item" data-url="record_stat">諮詢紀錄統計</a>
					<a class="item" data-url="setting">後台設定</a>
				</div>
				<div class="ui success message" id="success_message"></div>
				<div class="ui error message" id="error_message">
				    <p>請聯絡系統管理員。</p>
				</div>
				<div id="status" class="hidden">';
					status();
				echo '
				</div>
				<div id="view_record" class="hidden">';
					view_record();
				echo '
				</div>
				<div id="record_stat" class="hidden">';
					record_stat();
				echo '
				</div>
				<div id="setting" class="hidden">';
					setting();
				echo '
				</div>
			</div>';
		}
	}
	?>
</body>
</html>

<?php
function status(){
	global $sem_start_date, $sem_end_date, $sem;
	$get_tutor = mysql_query("SELECT * FROM `schedule` WHERE `semester`='$sem' AND `deleted`='0' ");
	$period = array('13'=>'13:10~14:00','14'=>'14:10~15:00','15'=>'15:10~16:00','16'=>'16:10~17:00','17'=>'17:10~18:00','18'=>'18:10~19:00','19'=>'19:10~20:00','20'=>'20:10~21:00');
	echo '
	<div align="center">
	<b style="font-size:16px;">手動添加小老師請假</b>
	<table class="ui selectable collapsing celled center aligned table">
		<thead>
			<tr>
				<th>Tutor</th>
				<th>Date</th>
				<th>Period</th>
				<th>Reason</th>
				<th></th>
			</tr>
		</thead>
		<tr>
			<form class="ui form create_leave" action="cpanel_edit.php" method="post">
			<td>
				<select class="ui dropdown create_leave tutor" name="tutor">
					<option value="">Tutor</option>';
				while($tutor = mysql_fetch_assoc($get_tutor)){
					echo '<option value="'.$tutor['tutor_name'].'">'.$tutor['tutor_name'].'</option>';
				}
				echo '
				</select>
			</td>
			<td>
				<div class="ui calendar input datepick"><input type="text" name="date" class="create_leave date" placeholder="Date"></div>
			</td>
			<td>
				<select class="ui dropdown create_leave period" name="period">
					<option value="">Period</option>';
					foreach($period as $periods => $time){
						echo '<option value="'.$periods.'">'.$time.'</option>';
					}
				echo '
				</select>
			</td>
			<td>
				<select class="ui fluid dropdown create_leave reason" name="reason">
					<option value="">Reason</option>
					<option value="事假">事假</option>
					<option value="病假">病假</option>
				</select>
			</td>
			<td><button class="ui blue compact basic button create-leave" type="submit">新增</button></td>
			</form>
		</tr>
	</table>
	</div>';
}
function view_record(){
	global $sem_start_date, $sem_end_date, $sem; //Get variable outside function
	//temporary, delete after update
	//$sem_start_date = '2017-09-18';
	//$sem_end_date = '2018-01-19';
	//$sem = 1061;
	//temporary, delete after update
	$tutor_rno = array(); //Save tutor name to find rno
	echo '
	<select class="ui selection dropdown selectTutor">
		<option value="">選擇Tutor</option>
		<option value="all">ALL</option>';
		$get_tutor = mysql_query("SELECT `rno`,`tutor_name` FROM `schedule` WHERE `foreign`=0 AND `semester`='$sem'");
		while($tutor = mysql_fetch_array($get_tutor)){
			echo '<option value="'.$tutor['rno'].'">'.$tutor['tutor_name'].'</option>';
			$tutor_rno[$tutor['rno']] = $tutor['tutor_name']; //save tutor name
		}
		echo '
	</select>
	<br><br>
	<b>Double-click to edit.</b>';
	$record_arr = array('Tutor'=>'tutor_name','諮詢日期'=>'date','開始時間'=>'start_time','結束時間'=>'end_time','學生姓名'=>'stu_name','學生學號'=>'stu_id','學生系所'=>'stu_dept','學生年級'=>'stu_year','學生電話'=>'stu_phone','學生Email'=>'stu_email','諮詢內容記錄'=>'record','小老師建議'=>'suggestion');
	$get_record = mysql_query("SELECT * FROM `record` WHERE `date` BETWEEN '$sem_start_date' AND '$sem_end_date' AND `deleted`=0 ORDER BY `rno` DESC");
	$count_record = mysql_num_rows($get_record);

	while($record = mysql_fetch_array($get_record)){
		$rno = array_search($record['tutor_name'],$tutor_rno); //rno of tutor
		$output = '
		<div class="RecordRow tutor'.$rno.'" id="record'.$record['rno'].'">
		<p style="padding-top:10px;">'.$count_record.'</p>
		<div class="ui segment">';
		$output .= ($record['late']==1)?'<b style="color:red;">諮詢紀錄補交</b><br>':''; //Late passup record add remark
		switch($record['stu_absent']){
			case 0: //Default result
				$output .= '
				<form class="ui form" action="cpanel_edit.php" method="post">
					<table class="ui celled very basic table">';
					foreach($record_arr as $desc => $value){ //Print record table
						if($value == 'record' || $value == 'suggestion') //Remove slashes in value
							$output .= '<tr><td class="collapsing">'.$desc.'</td><td class="editable textarea" data-value="'.$value.'">'.stripslashes($record[$value]).'</td></tr>';
						else
							$output .= '<tr><td class="collapsing">'.$desc.'</td><td class="editable" data-value="'.$value.'">'.$record[$value].'</td></tr>';
					}
				break;

			case 1: //Student absent add remark and different output result
				$output .= '
				<b style="color:blue;">學生無故缺席</b><br>
				<form class="ui form" action="cpanel_edit.php" method="post">
					<table class="ui celled very basic table">';
					$absent_arr = array_slice($record_arr,0,6); //Extract data needed for absent from array
					foreach($absent_arr as $desc => $value){ //Print record table
						if($desc == '學生姓名') continue; //Skip printing student name
						$output .= '<tr><td class="collapsing">'.$desc.'</td><td class="editable" data-value="'.$value.'">'.$record[$value].'</td></tr>';
					}
				break;

			default:
				break;
		}
		echo
		$output .= '</table>
		<button type="button" class="ui blue compact basic button edit disabled" data-rno="'.$record['rno'].'">修改</button>
		<button type="button" class="ui red compact basic button delete" data-rno="'.$record['rno'].'">刪除</button>
		<button type="button" class="ui red compact button cancel hidden" style="display:none;">取消</button>
		<button type="button" class="ui green compact basic button disabled download_pdf" data-rno="'.$record['rno'].'">下載pdf</button>
		<button type="button" class="ui green compact button success" style="display:none;">更新成功</button>
		</form>
		</div>
		</div>';
		$count_record--; //Countdown
	}
}

function record_stat(){
	//記錄下載 (檔名：學號-諮詢年月日.pdf)
	//每月歸檔 by 學號，點選連結後選擇月份，壓縮檔內含當月所有紀錄，只顯示有紀錄的月份
	//請假紀錄下載，同一時段算一次
	echo '歷年統計<br>';
	$count_1051 = mysql_result(mysql_query("SELECT count(*) FROM `appointment` WHERE `date` BETWEEN '2016-09-01' AND '2017-01-30' AND `deleted`=0"),0);
	$count_1052 = mysql_result(mysql_query("SELECT count(*) FROM `appointment` WHERE `date` BETWEEN '2017-02-01' AND '2017-06-30' AND `deleted`=0"),0);
	$count_1061 = mysql_result(mysql_query("SELECT count(*) FROM `appointment` WHERE `date` BETWEEN '2017-09-01' AND '2018-01-30' AND `deleted`=0"),0);
	$count_1062 = mysql_result(mysql_query("SELECT count(*) FROM `appointment` WHERE `date` BETWEEN '2018-02-01' AND '2018-06-30' AND `deleted`=0"),0);
	$count_blacklist_1051 = mysql_result(mysql_query("SELECT count(*) FROM `blacklist` WHERE `start_date` BETWEEN '2016-09-01' AND '2017-01-30' AND `deleted`=0"),0);
	$count_blacklist_1052 = mysql_result(mysql_query("SELECT count(*) FROM `blacklist` WHERE `start_date` BETWEEN '2017-02-01' AND '2017-06-30' AND `deleted`=0"),0);
	$count_blacklist_1061 = mysql_result(mysql_query("SELECT count(*) FROM `blacklist` WHERE `start_date` BETWEEN '2017-09-01' AND '2018-01-30' AND `deleted`=0"),0);
	$count_blacklist_1062 = mysql_result(mysql_query("SELECT count(*) FROM `blacklist` WHERE `start_date` BETWEEN '2018-02-01' AND '2018-06-30' AND `deleted`=0"),0);

	echo '1051預約記錄 = 預約'.$count_1051.'次 - 黑名單'.$count_blacklist_1051.'次 = '.($count_1051-$count_blacklist_1051).'次<br>';
	echo '1052預約記錄 = 預約'.$count_1052.'次 - 黑名單'.$count_blacklist_1052.'次 = '.($count_1052-$count_blacklist_1052).'次<br>';
	echo '1061預約記錄 = 預約'.$count_1061.'次 - 黑名單'.$count_blacklist_1061.'次 = '.($count_1061-$count_blacklist_1061).'次<br>';
	echo '1062預約記錄 = 預約'.$count_1062.'次 - 黑名單'.$count_blacklist_1062.'次 = '.($count_1062-$count_blacklist_1062).'次<br>';
	echo '
	<p>
		<div class="ui center aligned equal width grid">
		  <div class="column"><a href="#stu_stat">學生諮詢紀錄統計</a></div>
		  <div class="column"><a href="#stu_year_stat">年級統計</a></div>
		  <div class="column"><a href="#stu_dept_stat">系所統計</a></div>
		  <div class="column"><a href="#time_stat">時間統計</a></div>
		</div>
	</p>
	<div align="center">
		<table id="tutor_stat" class="ui selectable padded center aligned table">
			<thead>
				<tr>
					<th rowspan="2">Tutor</th>
					<th rowspan="2">每週時數<br>(小時)</th>
					<th rowspan="2">應繳交次數</th>
					<th rowspan="2">實繳交次數</th>
					<th rowspan="2">補交次數</th>
					<th rowspan="2">缺交次數</th>
					<th colspan="2">請假時數</th>
				</tr>
				<tr>
					<th>病假</th>
					<th>事假</th>
				</tr>
			</thead>';
			tutor_stat();
			echo '
		</table>
		<table id="stu_stat" class="ui selectable celled padded collapsing center aligned table">
			<thead>
				<tr>
					<th>學生學號</th>
					<th>諮詢次數</th>
					<th>無故缺席次數</th>
					<th>檔案下載<br><b style="color:red">測試中</b></th>
				</tr>
			</thead>';
			stu_stat();
			echo '
		</table>
		<table id="stu_year_stat" class="ui selectable celled padded collapsing center aligned table">
			<thead>
				<tr>
					<th>學生年級</th>
					<th>諮詢次數</th>
				</tr>
			</thead>';
			stu_year_stat();
			echo '
		</table>
		<table id="stu_dept_stat" class="ui selectable celled padded collapsing center aligned table">
			<thead>
				<tr>
					<th>學生系所</th>
					<th>諮詢次數</th>
				</tr>
			</thead>';
			stu_dept_stat();
			echo '
		</table>
		<table id="time_stat" class="ui selectable celled padded collapsing center aligned table">
			<thead>
				<tr>
					<th>時間</th>
					<th>諮詢次數</th>
				</tr>
			</thead>';
			time_stat();
			echo '
		</table>
	</div>';
}



function setting(){
	echo '
	<div align="center">
	<b style="font-size:16px;">學期設定</b>
	<table class="ui selectable collapsing celled center aligned table">
		<thead>
			<tr>
				<th>Semester Year</th>
				<th>Semester Start Date</th>
				<th>Semester End Date</th>
				<th></th>
			</tr>
		</thead>';
	$today = date('Y-m-d');
	$sem_sql = mysql_query("SELECT * FROM `semester` ORDER BY `rno` DESC");
	while($sem = mysql_fetch_array($sem_sql)){
		echo '
		<tr id="sem'.$sem['rno'].'">
			<td>'.$sem['sem_year'].'</td>
			<td>'.$sem['sem_start_date'].'</td>
			<td>'.$sem['sem_end_date'].'</td>
			<td><button type="button" class="ui red compact basic button sem-delete" data-rno="'.$sem['rno'].'">刪除</button></td>
		</tr>';
	}
	echo '
		<tr id="create_semester">
			<form class="ui form create_sem" action="cpanel_edit.php" method="post">
			<td><div class="ui input"><input type="number" name="sem_year" class="create_sem sem_year" placeholder="eg: 1051"></div></td>
			<td><div class="ui calendar input datepick"><input type="text" name="sem_start_date" class="create_sem sem_start_date" placeholder="學期開始日期"></div></td>
			<td><div class="ui calendar input datepick"><input type="text" name="sem_end_date" class="create_sem sem_end_date" placeholder="學期結束日期"></div></td>
			<td><button class="ui blue compact basic button create-sem" type="submit">新增</button></td>
			</form>
		</tr>
	</table>
	</div>
	<br><br>
	<div align="center">
		<b id="update_pw">更新管理員密碼</b>
		<div class="ui segment" style="width:450px;text-align:left;">
			<div class="ui success update_pw"></div>
			<div class="ui error update_pw"></div>
			<form class="ui form update_pw" action="cpanel_edit.php" method="post">
			<div class="field">
			    <div class="ui input">
			    	<input type="password" name="pw" placeholder="Old password">
			    </div>
			</div>
			<div class="field">
			    <div class="ui input">
			    	<input type="password" name="new_pw" placeholder="New password">
			    </div>
			</div>
			<div class="field">
			    <div class="ui input">
			    	<input type="password" name="c_new_pw" placeholder="Confirm new password">
			    </div>
			</div>
			<button class="ui fluid blue button update_pw" type="submit">送出</button>
			</form>
		</div>
	</div>';
}
/** Sub Function **/
function tutor_stat(){
	global $sem_start_date,$sem_end_date,$sem,$today;

	$get_tutor = mysql_query("SELECT `tutor_name` FROM `schedule` WHERE `foreign`=0 AND `semester`='$sem' AND `deleted`=0"); //Tutor name from Reservation system in database
	while($tutor = mysql_fetch_array($get_tutor)){
		$tutor_name = $tutor['tutor_name'];

		$tutor_hrs = mysql_fetch_array(mysql_query("SELECT `mon`,`tue`,`wed`,`thu`,`fri` FROM `schedule` WHERE `tutor_name`='$tutor_name' AND `semester`='$sem' AND `deleted`=0"));
		$mon_hr = empty($tutor_hrs['mon'])?0:count(explode('-',$tutor_hrs['mon']));
		$tue_hr = empty($tutor_hrs['tue'])?0:count(explode('-',$tutor_hrs['tue']));
		$wed_hr = empty($tutor_hrs['wed'])?0:count(explode('-',$tutor_hrs['wed']));
		$thu_hr = empty($tutor_hrs['thu'])?0:count(explode('-',$tutor_hrs['thu']));
		$fri_hr = empty($tutor_hrs['fri'])?0:count(explode('-',$tutor_hrs['fri']));
		$tutor_hrs_total = $mon_hr+$tue_hr+$wed_hr+$thu_hr+$fri_hr;

		$total_passup = mysql_num_rows(mysql_query("SELECT `tutor` FROM `appointment` WHERE `tutor`='$tutor_name' AND `deleted`=0 AND `date` BETWEEN '$sem_start_date' AND '$today'"));

		$actual_passup = $actual_add = $late_passup = $late_add = 0; //Initialize
		$get_passup = mysql_query("SELECT `late`,`start_time`,`end_time` FROM `record` WHERE `tutor_name`='$tutor_name' AND `deleted`=0 AND `date` BETWEEN '$sem_start_date' AND '$sem_end_date'");
		while($passup = mysql_fetch_array($get_passup)){
			if($passup['late'] == 0) ++$actual_passup;
			if($passup['late'] == 0 && ($passup['end_time']-$passup['start_time'])>1) ++$actual_add; //Passup 2hrs in one record situation
			if($passup['late'] == 1) ++$late_passup;
			if($passup['late'] == 1 && ($passup['end_time']-$passup['start_time'])>1) ++$late_add; //Passup 2hrs in one record situation
		}

		$lack_passup = $total_passup-$actual_passup-$actual_add-$late_passup-$late_add;

		$sick_leave = $shi_leave = 0; //Initialize
		$get_leave = mysql_query("SELECT `leave` FROM `tutor_leave` WHERE `approve`=1 AND `tutor`='$tutor_name' AND `date` BETWEEN '$sem_start_date' AND '$sem_end_date'");
		while($leave = mysql_fetch_array($get_leave)){
			if($leave['leave'] == '病假') $sick_leave++;
			if($leave['leave'] == '事假') $shi_leave++;
		}

		echo '<tr>
		<td>'.$tutor_name.'</td>
		<td>'.$tutor_hrs_total.'</td>
		<td>'.$total_passup.'</td>
		<td>'.($actual_passup+$actual_add).'</td>
		<td>'.($late_passup+$late_add).'</td>
		<td>'.$lack_passup.'</td>
		<td>'.$sick_leave.'</td>
		<td>'.$shi_leave.'</td>
		</tr>';
	}
}
function stu_stat(){
	global $sem_start_date,$sem_end_date,$sem;
	$get_record = mysql_query("SELECT DISTINCT `stu_id` FROM `record` WHERE `date` BETWEEN '$sem_start_date' AND '$sem_end_date' AND `deleted`=0 ORDER BY `stu_id`"); //Student ID from Reservation system in database eliminated duplicates
	$record_total = 0; //Initialize
	$stu_absent_total = 0; //Initialize
	while($record = mysql_fetch_array($get_record)){
		$stu_id = $record['stu_id'];
		echo '<tr>
		<td>'.$stu_id.'</td>
		<td>'.$record_count = mysql_num_rows(mysql_query("SELECT `stu_id` FROM `record` WHERE `date` BETWEEN '$sem_start_date' AND '$sem_end_date' AND `deleted`=0 AND `stu_id`='$stu_id'")).'</td>
		<td>'.$stu_absent_count = mysql_num_rows(mysql_query("SELECT `stu_id` FROM `record` WHERE `date` BETWEEN '$sem_start_date' AND '$sem_end_date' AND `deleted`=0 AND `stu_id`='$stu_id' AND `stu_absent`=1")).'</td>
		<td><a>下載</a></td>
		</tr>';
		$record_total = $record_total + $record_count; //Sum of record count
		$stu_absent_total = $stu_absent_total + $stu_absent_count; //Sum of student absent count
	}
	echo '<tfoot><tr>
	<th>Total</th>
	<th>'.$record_total.'</th>
	<th>'.$stu_absent_total.'</th>
	<th><a href="">下載全部</a></th>
	</tr></tfoot>';
}
function stu_year_stat(){
	global $sem_start_date,$sem_end_date,$sem;
	$stu_year_total = 0; //Initialize
	for($stu_year=1;$stu_year<=6;$stu_year++){ //There are six year grade to be count
		$stu_year_count = mysql_num_rows(mysql_query("SELECT `stu_year` FROM `record` WHERE `date` BETWEEN '$sem_start_date' AND '$sem_end_date' AND `deleted`=0 AND `stu_year`='$stu_year'"));
		$stu_year_count_arr[$stu_year] = $stu_year_count; //Store current value to array
		$stu_year_total = $stu_year_total + $stu_year_count; //Sum of student year count
	}
	for($i=1;$i<=6;$i++){
		$max = max($stu_year_count_arr); //Find maximum
		$output = ($stu_year_count_arr[$i] == $max)?'<tr class="active">':'<tr>'; //Maximum add class active
		echo $output .= '
		<td>'.$i.'</td>
		<td>'.$stu_year_count_arr[$i].'</td>
		</tr>';

	}
	echo '<tfoot><tr>
	<th>Total</th>
	<th>'.$stu_year_total.'</th>
	</tr></tfoot>';
}
function stu_dept_stat(){
	global $sem_start_date,$sem_end_date,$sem;
	$get_record = mysql_query("SELECT DISTINCT `stu_dept` FROM `record` WHERE `date` BETWEEN '$sem_start_date' AND '$sem_end_date' AND `deleted`=0 AND `stu_absent`=0 ORDER BY `stu_dept`"); //Student department from Reservation system in database
	$stu_dept_total = 0; //Initialize
	while($record = mysql_fetch_array($get_record)){
		$stu_dept = $record['stu_dept'];
		echo '<tr>
		<td>'.$stu_dept.'</td>
		<td>'.$stu_dept_count = mysql_num_rows(mysql_query("SELECT `stu_dept` FROM `record` WHERE `date` BETWEEN '$sem_start_date' AND '$sem_end_date' AND `deleted`=0 AND `stu_dept`='$stu_dept'")).'</td>
		</tr>';
		$stu_dept_total = $stu_dept_total + $stu_dept_count; //Sum of student department count
	}
	echo '<tfoot><tr>
	<th>Total</th>
	<th>'.$stu_dept_total.'</th>
	</tr></tfoot>';
}
function time_stat(){
	global $sem_start_date,$sem_end_date,$sem;
	$time = array('13','14','15','16','17','18','19','20'); //13:00~20:00
	$time_total = 0; //Initialize
	for($i=0;$i<count($time);$i++){
		$start_time = $time[$i];
		$time_count = mysql_num_rows(mysql_query("SELECT `start_time` FROM `record` WHERE `date` BETWEEN '$sem_start_date' AND '$sem_end_date' AND `deleted`=0 AND `start_time` LIKE '$start_time%'"));
		$time_count_arr[$i] = $time_count; //Store current value to array
		$time_total = $time_total + $time_count; //Sum of time count
	}
	for($i=0;$i<count($time);$i++){
		$max = max($time_count_arr); //Find maximum
		$output = ($time_count_arr[$i] == $max)?'<tr class="active">':'<tr>'; //Maximum add class active
		echo $output .= '
		<td>'.$time[$i].':10~'.($time[$i]+1).':00</td>
		<td>'.$time_count_arr[$i].'</td>
		</tr>';
	}
	echo '<tfoot><tr>
	<th>Total</th>
	<th>'.$time_total.'</th>
	</tr></tfoot>';
}
/** Sub Function **/
?>
