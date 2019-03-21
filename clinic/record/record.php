<?php
$db = 'booking';
require('../../connect_db.php');
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
<title>自學園小老師諮詢記錄</title>
<link rel="stylesheet" type="text/css" href="../../../plugin/semantic/dist/semantic.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.rawgit.com/mdehoog/Semantic-UI/6e6d051d47b598ebab05857545f242caf2b4b48c/dist/components/calendar.min.css" />
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
<script type="text/javascript" src="../../../plugin/semantic/dist/semantic.min.js"></script>
<script type="text/javascript" src="https://cdn.rawgit.com/mdehoog/Semantic-UI/6e6d051d47b598ebab05857545f242caf2b4b48c/dist/components/calendar.min.js"></script>
<script type="text/javascript" src="scripts/record.js"></script>
<style>
.message, .hidden{
	display: none;
}
h2{
	font-family: "標楷體", DFKai-sb;
}
</style>
</head>
<body>
<div class="ui container" style="padding:10px 0px;">
	<div class="ui compact blue basic buttons">
		<button class="ui button left floated leave">小老師請假</button>
		<button class="ui button left floated check">繳交記錄查詢</button>
		<button class="ui button left floated booking">小老師預約</button>
	</div>
	<h2 class="ui center aligned header" style="margin-top:-10px;">自學園小老師諮詢紀錄</h2>
	<div class="ui success message" id="success_message">
	    <div class="header">提交成功</div>
	    <p>已成功提交本次諮詢紀錄，請稍等頁面刷新。</p>
	</div>
	<div class="ui error message" id="error_message">
	    <div class="header">提交失敗</div>
	    <p>無法提交本次諮詢紀錄，請聯絡系統管理員。</p>
	</div>
	<form class="ui form" action="record_submit.php" method="post">
		<div class="three wide field">
			<label>小老師</label>
			<?php
			$get_tutor = mysql_query("SELECT `tutor_name`,`desc` FROM `schedule` WHERE `foreign`=0 AND `semester`='$sem' AND `deleted`=0 ");
			echo '
			<select class="ui fluid dropdown" name="tutor_name">
				<option value=""></option>';
			while($row = mysql_fetch_array($get_tutor)){
				$nameWithHash=$row['tutor_name'];
				$name=explode('-',$nameWithHash);
				//echo "<script>console.log(".$name[0].")</script>";
				$desc=$row['desc'];
				$showName=$name[0]."-".$desc;
				echo '<option value="'.$row['tutor_name'].'">'.$showName.'</option>';
			}
			echo '</select>';
			?>
		</div>
		<div class="fields">
			<div class="ui calendar three wide field" id="datepick">
				<label>諮詢日期</label>
				<input type="text" name="date" placeholder="諮詢日期">
			</div>
			<div class="four wide field">
				<label>諮詢開始及結束時間</label>
				<div class="two fields">
					<div class="ui calendar field" id="start_timepick">
						<input type="text" name="start_time" placeholder="Start time">
					</div>
					<div class="ui calendar field" id="end_timepick">
						<input type="text" name="end_time" placeholder="End time">
					</div>
				</div>
			</div>
		</div>
		<div class="field">
			<div class="ui checkbox" id="late">
				<input type="checkbox" name="late" value="1">
				<label>補交請勾選</label>
			</div>
		</div>
		<h3 class="ui dividing header">學生資料</h3>
		<div class="field">
			<div class="ui checkbox" id="stu_absent">
				<input type="checkbox" name="stu_absent" value="1">
				<label>學生無故缺席</label>
			</div>
		</div>
		<div class="fields">
			<div class="three wide field stu_absent">
				<label>姓名</label>
				<input type="text" name="stu_name" placeholder="Name">
			</div>
			<div class="three wide field">
				<label>學號</label>
				<input type="text" name="stu_id" placeholder="Ex: B003012000" maxlength="10">
			</div>
		</div>
		<div class="field stu_absent">
			<label>系級</label>
			<div class="two fields">
				<div class="four wide field">
					<?php include 'department.php'; ?>
					<input type="text" class="hidden text dept" placeholder="請輸入其他系所之名稱">
				</div>
				<div class="two wide field">
					<select class="ui fluid dropdown" name="stu_year">
						<option value="">年級</option>
						<option value="1">一年級</option>
						<option value="2">二年級</option>
						<option value="3">三年級</option>
						<option value="4">四年級</option>
						<option value="5">五年級</option>
						<option value="6">六年級</option>
					</select>
				</div>
			</div>
		</div>
		<div class="two fields stu_absent">
			<div class="three wide field">
				<label>聯絡電話</label>
				<input type="text" name="stu_phone" placeholder="非必填" style="ime-mode:disabled" onkeyup="return ValidateNumber(this,value)" maxlength="10">
			</div>
			<div class="three wide field">
				<label>Email</label>
				<input type="email" name="stu_email" placeholder="非必填">
			</div>
		</div>
		<h3 class="ui dividing header stu_absent">諮詢內容及建議</h3>
		<div class="field stu_absent">
			<label>諮詢內容記錄</label>
			<textarea name="record" placeholder="（學生是聽、說、讀、寫哪方面的問題，或是其他的英語學習困難，小老師使用什麼軟體或教材輔導學生，小老師諮詢是否有無法解決的問題等，請列下。）"></textarea>
		</div>
		<div class="field stu_absent">
			<label>小老師建議</label>
			<textarea name="suggestion"></textarea>
		</div>
		<button class="ui blue submit button" type="submit" value="submit">提交</button>
	</form>
</div>

<div class="ui modal check">
	<i class="close icon"></i>
	<div class="header">繳交記錄查詢</div>
	<div class="content">
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
			</thead>

			<?php
			$get_tutor = mysql_query("SELECT `tutor_name` FROM `schedule` WHERE `foreign`=0 AND `semester`='$sem'"); //Tutor name from Reservation system in database
			while($tutor = mysql_fetch_array($get_tutor)){
				$tutor_name = $tutor['tutor_name'];

				$tutor_hrs = mysql_fetch_array(mysql_query("SELECT `mon`,`tue`,`wed`,`thu`,`fri` FROM `schedule` WHERE `tutor_name`='$tutor_name' AND `semester`='$sem'"));
				$mon_hr = isset($tutor_hrs['mon'])?count(explode('-',$tutor_hrs['mon'])):0;
				$tue_hr = isset($tutor_hrs['tue'])?count(explode('-',$tutor_hrs['tue'])):0;
				$wed_hr = isset($tutor_hrs['wed'])?count(explode('-',$tutor_hrs['wed'])):0;
				$thu_hr = isset($tutor_hrs['thu'])?count(explode('-',$tutor_hrs['thu'])):0;
				$fri_hr = isset($tutor_hrs['fri'])?count(explode('-',$tutor_hrs['fri'])):0;
				$tutor_hrs_total = $mon_hr+$tue_hr+$wed_hr+$thu_hr+$fri_hr;

				$total_passup = mysql_num_rows(mysql_query("SELECT `tutor` FROM `appointment` WHERE `tutor`='$tutor_name' AND `deleted`=0 AND `date` BETWEEN '$sem_start_date' AND '$today'"));

				$actual_passup = $actual_add = $late_passup = $late_add = 0;
				$get_passup = mysql_query("SELECT `late`,`start_time`,`end_time` FROM `record` WHERE `tutor_name`='$tutor_name' AND `deleted`=0 AND `date` BETWEEN '$sem_start_date' AND '$sem_end_date'");
				while($passup = mysql_fetch_array($get_passup)){
					if($passup['late'] == 0) $actual_passup++;
					if($passup['late'] == 0 && ($passup['end_time']-$passup['start_time'])>1) $actual_add++; //Passup 2hrs in one record situation
					if($passup['late'] == 1) $late_passup++;
					if($passup['late'] == 1 && ($passup['end_time']-$passup['start_time'])>1) $late_add++; //Passup 2hrs in one record situation
				}

				$lack_passup = $total_passup-$actual_passup-$actual_add-$late_passup-$late_add;

				$sick_leave = $shi_leave = 0;
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
		?>
		</table>
	</div>
</div>
</body>
</html>
