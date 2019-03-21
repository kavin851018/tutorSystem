<?php
session_start();
$db = 'booking';
include('../../connect_db.php');

/** pagination & week header **/
$this_week = (date('l') == 'Monday')?strtotime('this monday'):strtotime('last monday'); //First day of this week
if(isset($_GET['week'])) $this_week = $_GET['week'];
$prev_week = strtotime('-1 week',$this_week); //First day of past week
$next_week = strtotime('+1 week',$this_week); //First day of next week

$periods = array('13'=>'13:10~14:00','14'=>'14:10~15:00','15'=>'15:10~16:00','16'=>'16:10~17:00','17'=>'17:10~18:00','18'=>'18:10~19:00','19'=>'19:10~20:00','20'=>'20:10~21:00');

//Select semester
$today = date('Y-m-d',$this_week); //This page's today
$semester = mysql_fetch_array(mysql_query("SELECT * FROM `semester` WHERE '$today' BETWEEN `sem_start_date` AND `sem_end_date`"));
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
<title>小老師請假</title>
<link rel="stylesheet" type="text/css" href="../../../plugin/semantic/dist/semantic.min.css">
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
<script type="text/javascript" src="../../../plugin/semantic/dist/semantic.min.js"></script>
<script type="text/javascript" src="scripts/leave.js"></script>
<style>
.message{
	display: none;
}
h2{
	font-family: "標楷體", DFKai-sb;
}
.main.container{
	padding:10px 0;
	width:1360px !important;
}
</style>
</head>
<body>
<div class="ui main container">
	<?php
	echo '
    <h2 class="ui center aligned header">小老師請假</h2>
    <div style="color:red;text-align:center;font-size:16px;">請假後請電話通知阮偉華助理，電話分機 3211</div>
	<div class="ui inverted green success message"><div class="header">提交成功</div></div>
	<div class="ui inverted red error message"><div class="header">提交失敗</div></div>
	<table class="ui celled teal table" style="text-align:center;">
		<thead>
			<tr>
				<th width="10%"></th>';
				for($i=0;$i<5;$i++){ //5 days
					echo '<th width="18%">'.date('l',strtotime('+'.$i.' days',$this_week)).' ('.date('m/d',strtotime('+'.$i.' days',$this_week)).')</th>';
				}
			echo '
			</tr>
		</thead>
		<tbody>';
		$foreign = 0;
		$schedule_sql = mysql_query("SELECT * FROM `schedule` WHERE `foreign`='$foreign' AND `semester`='$sem'");
		$i = 0; //Initialize
		while($schedule = mysql_fetch_array($schedule_sql)){ //Data from db
			$tutor_name[] = $schedule['tutor_name']; //List of tutor name
			$tutor_desc[$schedule['tutor_name']] = $schedule['desc']; //Tutor skill description, using tutor name as hook
			$tutor_schedule[$i] = array($schedule['mon'],$schedule['tue'],$schedule['wed'],$schedule['thu'],$schedule['fri']); //List of each tutor schedule, $tutor_schedule[tutor][day schedule]
			$i++;
		}

		//Array to save all tutors, 5 days' working periods
		for($x=0;$x<sizeof($tutor_name);$x++){ //Tutors amount
			$tutor_times[$x] = array();
			for($y=0;$y<5;$y++){ //5 days
				$tutor_times[$x][$y] = array();
				$times = explode('-', $tutor_schedule[$x][$y]); //Split tutor's day working period
				for($z=0;$z<sizeof($times);$z++){ //Tutor's day working period
					$tutor_times[$x][$y][$times[$z]] = $tutor_name[$x]; //$tutor_times[tutor][days][times] each tutor's period collection
				}
			}
		}
		//Array of periods collection
		foreach($periods as $period => $time){ //Vertical line
			for($i=0;$i<sizeof($tutor_name);$i++){ //Tutors amount
				for($j=0;$j<5;$j++){ //5 days
					$period_merge[$period][$j] = $tutor_times[$i][$j][$period]; //$period_merge[period==times][days]
				}
				$horizon_period[$period] = array_merge_recursive_new($period_merge[$period], $horizon_period[$period]); //Merge all tutors' time
			}
		}
		//Table result
		foreach($periods as $period => $time){ //Vertical line
			echo '
			<form class="ui form leave" action="leave_submit.php" method="post">
			<tr>
				<td>'.$time.'</td>';
				for($day=0;$day<5;$day++){ // Horizontal line, 5 days
					$check_date = date('Y-m-d',strtotime('+'.$day.' days',$this_week)); //Actually is 'today' while printing table
					$check_tutor = $horizon_period[$period][$day]; //Tutor name
					$appointment_sql = mysql_query("SELECT * FROM `appointment` WHERE `deleted`=0 AND `date`='$check_date' AND `period`='$period' AND `foreign`='$foreign' AND `tutor`='$check_tutor'");
					$holiday_sql = mysql_query("SELECT * FROM `holiday` WHERE '$check_date' BETWEEN `start_date` AND `end_date`");
					$holiday = mysql_fetch_assoc($holiday_sql);

					echo '<td>';
					if(is_array($check_tutor)){ //Multi tutor in one period

						$tutors=array();

						while(is_array($check_tutor)){
							$tutors[]=$check_tutor[1];
							if(is_array($check_tutor[0])){
									$check_tutor=$check_tutor[0];
									continue;
							}
							else{
								$tutors[]=$check_tutor[0];
								break;
							}
						}

						foreach($tutors as $multi_tutor_name){
							$leave_check = mysql_fetch_assoc(mysql_query("SELECT * FROM `tutor_leave` WHERE `date`='$check_date' AND `period`='$period' AND `tutor`='$multi_tutor_name'"));
							$appointment_sql = mysql_query("SELECT * FROM `appointment` WHERE `deleted`=0 AND `date`='$check_date' AND `period`='$period' AND `foreign`='$foreign' AND `tutor`='$multi_tutor_name'");
							if($multi_tutor_name){ //Has tutor start
								echo '
								<div class="ui secondary teal raised segment">
									<div>'.$multi_tutor_name.'</div>';
							}
							//Holiday
							if($check_date >= $holiday['start_date'] && $check_date <= $holiday['end_date'] && $multi_tutor_name){
								echo '<i class="large yellow star icon" data-content="Holiday"></i>';
							}
							//Not Available yet
							elseif($check_date >= date('Y-m-d',strtotime('+15 days')) && $multi_tutor_name){ //2 weeks excluding Sat & Sun
								echo '<i class="large red minus circle icon" data-content="Not available yet"></i>';
							}
							//Overdue date
							elseif($check_date <= date('Y-m-d') && $multi_tutor_name){
								if($appointment = mysql_fetch_assoc($appointment_sql)){ //Appointment exist and overdue
									echo '<div><i class="teal user icon"></i>'.$appointment['id'].'</div>';
									if($leave_check['date']==$check_date && $leave_check['period']==$period && $leave_check['approve']==1){
										echo '假期已核准';
									}
									elseif($leave_check['date']==$check_date && $leave_check['period']==$period && $leave_check['approve']==0){
										echo '假期審核中';
									}
									else{
										echo '<i class="large grey book icon" data-content="Overdue"></i>';
									}
								}
								else{ //No appointment and overdue
									if($leave_check['date']==$check_date && $leave_check['period']==$period && $leave_check['approve']==1){
										echo '假期已核准';
									}
									elseif($leave_check['date']==$check_date && $leave_check['period']==$period && $leave_check['approve']==0){
										echo '假期審核中';
									}
									else{
										echo '<i class="large grey book icon" data-content="No Appointment"></i>';
									}
								}
							}
							//Appointment exist
							elseif($appointment = mysql_fetch_assoc($appointment_sql)){
								echo '<div><i class="teal user icon"></i>'.$appointment['id'].'</div>';
								if($leave_check['date']==$check_date && $leave_check['period']==$period && $leave_check['approve']==1){
									echo '假期已核准';
								}
								elseif($leave_check['date']==$check_date && $leave_check['period']==$period && $leave_check['approve']==0){
									echo '假期審核中';
								}
								else{
									echo '
									<div class="inline fields">
										<div class="field">
									        <div class="ui radio checkbox">
										        <input type="radio" name="leave" tabindex="0" class="hidden" value="事假&'.$multi_tutor_name.'&'.$check_date.'&'.$period.'">
										        <label>事假</label>
									        </div>
									    </div>
									    <div class="field">
									        <div class="ui radio checkbox">
										        <input type="radio" name="leave" tabindex="0" class="hidden" value="病假&'.$multi_tutor_name.'&'.$check_date.'&'.$period.'">
										        <label>病假</label>
									        </div>
									    </div>
									</div>';
								}
							}
							//No appointment
							elseif($multi_tutor_name){
								if($leave_check['date']==$check_date && $leave_check['period']==$period && $leave_check['approve']==1){
									echo '假期已核准';
								}
								elseif($leave_check['date']==$check_date && $leave_check['period']==$period && $leave_check['approve']==0){
									echo '假期審核中';
								}
								else{
									echo '
									<div class="inline fields">
										<div class="field">
									        <div class="ui radio checkbox">
										        <input type="radio" name="leave" tabindex="0" class="hidden" value="事假&'.$multi_tutor_name.'&'.$check_date.'&'.$period.'">
										        <label>事假</label>
									        </div>
									    </div>
									    <div class="field">
									        <div class="ui radio checkbox">
										        <input type="radio" name="leave" tabindex="0" class="hidden" value="病假&'.$multi_tutor_name.'&'.$check_date.'&'.$period.'">
										        <label>病假</label>
									        </div>
									    </div>
									</div>';
								}
							}
							//Has tutor end
							if($multi_tutor_name){
								echo '</div>';
							}
						}
					}
					else{ //Single tutor in one period
						$leave_check = mysql_fetch_array(mysql_query("SELECT * FROM `tutor_leave` WHERE `date`='$check_date' AND `period`='$period' AND `tutor`='$check_tutor'"));
						if($check_tutor){ //Has tutor start
							echo '
							<div class="ui secondary teal raised segment">
								<div>'.$check_tutor.'</div>';
						}
						//Holiday
						if($check_date >= $holiday['start_date'] && $check_date <= $holiday['end_date'] && $check_tutor){
							echo '<i class="large yellow star icon" data-content="Holiday"></i>';
						}
						//Not Available yet
						elseif($check_date >= date('Y-m-d',strtotime('+15 days')) && $check_tutor){ //2 weeks excluding Sat & Sun
							echo '<i class="large red minus circle icon" data-content="Not available yet"></i>';
						}
						//Overdue date
						elseif($check_date <= date('Y-m-d') && $check_tutor){
							if($appointment = mysql_fetch_assoc($appointment_sql)){ //Appointment exist and overdue
								echo '<div><i class="teal user icon"></i>'.$appointment['id'].'</div>';
								if($leave_check['date']==$check_date && $leave_check['period']==$period && $leave_check['approve']==1){
									echo '假期已核准';
								}
								elseif($leave_check['date']==$check_date && $leave_check['period']==$period && $leave_check['approve']==0){
									echo '假期審核中';
								}
								else{
									echo '<i class="large grey book icon" data-content="Overdue"></i>';
								}
							}
							else{ //No appointment and overdue
								if($leave_check['date']==$check_date && $leave_check['period']==$period && $leave_check['approve']==1){
									echo '假期已核准';
								}
								elseif($leave_check['date']==$check_date && $leave_check['period']==$period && $leave_check['approve']==0){
									echo '假期審核中';
								}
								else{
									echo '<i class="large grey book icon" data-content="No Appointment"></i>';
								}
							}
						}
						//Appointment exist
						elseif($appointment = mysql_fetch_assoc($appointment_sql)){
							echo '<div><i class="teal user icon"></i>'.$appointment['id'].'</div>';
							if($leave_check['date']==$check_date && $leave_check['period']==$period && $leave_check['approve']==1){
								echo '假期已核准';
							}
							elseif($leave_check['date']==$check_date && $leave_check['period']==$period && $leave_check['approve']==0){
								echo '假期審核中';
							}
							else{
								echo '
								<div class="inline fields">
									<div class="field">
								        <div class="ui radio checkbox">
									        <input type="radio" name="leave" tabindex="0" class="hidden" value="事假&'.$check_tutor.'&'.$check_date.'&'.$period.'">
									        <label>事假</label>
								        </div>
								    </div>
								    <div class="field">
								        <div class="ui radio checkbox">
									        <input type="radio" name="leave" tabindex="0" class="hidden" value="病假&'.$check_tutor.'&'.$check_date.'&'.$period.'">
									        <label>病假</label>
								        </div>
								    </div>
								</div>';
							}
						}
						//No appointment
						elseif($check_tutor){
							if($leave_check['date']==$check_date && $leave_check['period']==$period && $leave_check['approve']==1){
								echo '假期已核准';
							}
							elseif($leave_check['date']==$check_date && $leave_check['period']==$period && $leave_check['approve']==0){
								echo '假期審核中';
							}
							else{
								echo '
								<div class="inline fields">
									<div class="field">
								        <div class="ui radio checkbox">
									        <input type="radio" name="leave" tabindex="0" class="hidden" value="事假&'.$check_tutor.'&'.$check_date.'&'.$period.'">
									        <label>事假</label>
								        </div>
								    </div>
								    <div class="field">
								        <div class="ui radio checkbox">
									        <input type="radio" name="leave" tabindex="0" class="hidden" value="病假&'.$check_tutor.'&'.$check_date.'&'.$period.'">
									        <label>病假</label>
								        </div>
								    </div>
								</div>';
							}
						}
						//Has tutor end
						if($check_tutor){
							echo '</div>';
						}
					}
					echo '</td>';
				}
			echo '</tr>';
		}
		echo '
		</tbody>
	</table>
	<div align="center"><input class="ui blue button" type="submit" value="提交"></div>
	</form>
	<div align="center">
		<div class="ui pagination inverted teal menu" style="text-align:center;margin-top: 20px;">
		    <a class="item prev week" href="?week='.$prev_week.'"><i class="chevron left icon"></i>Previous week</a>
		    <a class="item this week" href="./leave.php">Today</a>
		    <a class="item next week" href="?week='.$next_week.'">Next week<i class="chevron right icon"></i></a>
		</div>
	</div>';
	?>
</div>
</body>
</html>
<?php
function array_merge_recursive_new($first, $second){
    $result = array();
    foreach($first as $key => $value){
        $result[$key] = $value;
    }
    foreach($second as $key => $value){
    	if($value==NULL)
    		continue;
    	elseif($result[$key]!=NULL) //Merge recursive
    		$result[$key] = array($value,$result[$key]);
    	else
        	$result[$key] = $value;
    }
    return $result;
}
?>
