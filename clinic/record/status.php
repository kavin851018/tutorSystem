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
<title>諮詢記錄狀態</title>
<link rel="stylesheet" type="text/css" href="../../../plugin/semantic/dist/semantic.min.css">
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
<script type="text/javascript" src="../../../plugin/semantic/dist/semantic.min.js"></script>
<script type="text/javascript" src="scripts/status.js"></script>
<style>
.message{
	display: none;
}
h2{
	font-family: "標楷體", DFKai-sb;
}
.main.container{
	padding:10px 0;
	width:1200px !important;
}
</style>
</head>
<body>
<div class="ui main container">
	<?php
	echo '
    <h2 class="ui center aligned header">諮詢紀錄狀態</h2>
	<div class="ui inverted green success message"></div>
	<div class="ui inverted red error message"></div>
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
		$schedule_sql = mysql_query("SELECT * FROM `schedule` WHERE `foreign`='$foreign' AND `semester`='$sem' AND `deleted`=0");
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
			$end_time_2 = $period+1; //End time for passup 2 hrs in one record
			echo '
			<tr>
				<td>'.$time.'</td>';
				for($day=0;$day<5;$day++){ // Horizontal line, 5 days
					$check_date = date('Y-m-d',strtotime('+'.$day.' days',$this_week)); //Actually is 'today' while printing table
					$check_tutor = $horizon_period[$period][$day]; //Tutor name
					$appointment_sql = mysql_query("SELECT * FROM `appointment` WHERE `deleted`=0 AND `date`='$check_date' AND `period`='$period' AND `foreign`='$foreign' AND `tutor`='$check_tutor'");
					$holiday_sql = mysql_query("SELECT * FROM `holiday` WHERE '$check_date' BETWEEN `start_date` AND `end_date`");
					$holiday = mysql_fetch_assoc($holiday_sql);
					$tutor_leave = mysql_fetch_assoc(mysql_query("SELECT * FROM `tutor_leave` WHERE `date`='$check_date' AND `period`='$period' AND `tutor`='$check_tutor'"));

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
							$appointment_sql = mysql_query("SELECT * FROM `appointment` WHERE `deleted`=0 AND `date`='$check_date' AND `period`='$period' AND `foreign`='$foreign' AND `tutor`='$multi_tutor_name'");
							$tutor_leave = mysql_fetch_assoc(mysql_query("SELECT * FROM `tutor_leave` WHERE `date`='$check_date' AND `period`='$period' AND `tutor`='$multi_tutor_name'"));
							if($multi_tutor_name){ //Has tutor start
								 $str=$multi_tutor_name;
								 $str2=explode('-',$str);
								echo '
								<div class="ui secondary teal raised segment">
									<div>'.$str2[0].'</div>';
							}
							//Holiday
							if($check_date >= $holiday['start_date'] && $check_date <= $holiday['end_date'] && $multi_tutor_name){
								echo '<i class="large yellow star icon" data-content="Holiday"></i>';
							}
							//Not Available yet
							elseif($check_date >= date('Y-m-d',strtotime('+15 days')) && $multi_tutor_name){ //2 weeks excluding Sat & Sun
								echo '<i class="large red minus circle icon" data-content="Not available yet"></i>';
							}
							//Tutor take leave
							elseif($tutor_leave['date']==$check_date && $tutor_leave['period']==$period && $tutor_leave['tutor']==$multi_tutor_name){
								if($tutor_leave['approve']==1){ //Leave approved
									if($appointment = mysql_fetch_assoc($appointment_sql)){
										echo '
										<div><i class="teal user icon"></i>'.$appointment['id'].'</div>
										<i class="large red warning circle icon" data-content="Tutor take leave" style="cursor:default;"></i>';
									}
									else{
										echo '<i class="large red warning circle icon" data-content="Tutor take leave" style="cursor:default;"></i>';
									}
								}
								elseif($tutor_leave['approve']==0){ //Leave register waiting for approvement
									echo '
									<div>請假申請中</div>
									<button class="ui tiny positive button leave" data-value="1" data-rno="'.$tutor_leave['rno'].'" data-tutor="'.$tutor_leave['tutor'].'" data-date="'.$tutor_leave['date'].'" data-period="'.$tutor_leave['period'].'">批准</button>
									<button class="ui tiny negative button leave" data-value="0" data-rno="'.$tutor_leave['rno'].'" data-tutor="'.$tutor_leave['tutor'].'" data-date="'.$tutor_leave['date'].'" data-period="'.$tutor_leave['period'].'">不批准</button>';
								}
							}
							//Expired date
							elseif($check_date <= date('Y-m-d') && $multi_tutor_name){
								$record_check = mysql_fetch_assoc(mysql_query("SELECT * FROM `record` WHERE `date`='$check_date' AND (`start_time` LIKE '$period%' OR `end_time` LIKE '$end_time_2%') AND `tutor_name`='$multi_tutor_name' AND `deleted`=0"));
								if($appointment = mysql_fetch_assoc($appointment_sql)){ //Appointment exist and Expired
									if($record_check){
										echo '
										<div><i class="teal user icon"></i>'.$appointment['id'].'</div>
										<i class="large green book icon" data-content="已交"></i>';
									}
									else{
										echo '
										<div><i class="teal user icon"></i>'.$appointment['id'].'</div>
										<i class="large red book icon" data-content="未交"></i>';
									}
								}
								else{ //No appointment and Expired
									echo '<i class="large grey book icon" data-content="No Appointment"></i>';
								}
							}
							//Appointment exist
							elseif($appointment = mysql_fetch_assoc($appointment_sql)){
								echo '
								<div><i class="teal user icon"></i>'.$appointment['id'].'</div>';
							}
							//No appointment
							elseif($multi_tutor_name){
								echo '<i class="large grey book icon" data-content="No Appointment"></i>';
							}
							//Has tutor end
							if($multi_tutor_name){
								echo '</div>';
							}
						}
					}
					else{ //Single tutor in one period
						if($check_tutor){ //Has tutor start
							$str=$check_tutor;
							$str2=explode('-',$str);
							echo '
							<div class="ui secondary teal raised segment">
								<div>'.$str2[0].'</div>';
						}
						//Holiday
						if($check_date >= $holiday['start_date'] && $check_date <= $holiday['end_date'] && $check_tutor){
							echo '<i class="large yellow star icon" data-content="Holiday"></i>';
						}
						//Not Available yet
						elseif($check_date >= date('Y-m-d',strtotime('+15 days')) && $check_tutor){ //2 weeks excluding Sat & Sun
							echo '<i class="large red minus circle icon" data-content="Not available yet"></i>';
						}
						//Tutor take leave
						elseif($tutor_leave['date']==$check_date && $tutor_leave['period']==$period && $tutor_leave['tutor']==$check_tutor){
							if($tutor_leave['approve']==1){ //Leave approved
								if($appointment = mysql_fetch_assoc($appointment_sql)){
									echo '
									<div><i class="teal user icon"></i>'.$appointment['id'].'</div>
									<i class="large red warning circle icon" data-content="Tutor take leave" style="cursor:default;"></i>';
								}
								else{
									echo '<i class="large red warning circle icon" data-content="Tutor take leave" style="cursor:default;"></i>';
								}
							}
							elseif($tutor_leave['approve']==0){ //Leave register waiting for approvement
								echo '
								<div>請假申請中</div>
								<button class="ui tiny positive button leave" data-value="1" data-rno="'.$tutor_leave['rno'].'" data-tutor="'.$tutor_leave['tutor'].'" data-date="'.$tutor_leave['date'].'" data-period="'.$tutor_leave['period'].'">批准</button>
								<button class="ui tiny negative button leave" data-value="0" data-rno="'.$tutor_leave['rno'].'" data-tutor="'.$tutor_leave['tutor'].'" data-date="'.$tutor_leave['date'].'" data-period="'.$tutor_leave['period'].'">不批准</button>';
							}
						}
						//Expired date
						elseif($check_date <= date('Y-m-d') && $check_tutor){
							$record_check = mysql_fetch_assoc(mysql_query("SELECT * FROM `record` WHERE `date`='$check_date' AND (`start_time` LIKE '$period%' OR `end_time` LIKE '$end_time_2%') AND `tutor_name`='$check_tutor' AND `deleted`=0"));
							if($appointment = mysql_fetch_assoc($appointment_sql)){ //Appointment exist and Expired
								if($record_check){
									echo '
									<div><i class="teal user icon"></i>'.$appointment['id'].'</div>
									<i class="large green book icon" data-content="已交"></i>';
								}
								else{
									echo '
									<div><i class="teal user icon"></i>'.$appointment['id'].'</div>
									<i class="large red book icon" data-content="未交"></i>';
								}
							}
							else{ //No appointment and Expired
								echo '<i class="large grey book icon" data-content="No Appointment"></i>';
							}
						}
						//Appointment exist
						elseif($appointment = mysql_fetch_assoc($appointment_sql)){
							echo '
							<div><i class="teal user icon"></i>'.$appointment['id'].'</div>';
						}
						//No appointment
						elseif($check_tutor){
							echo '<i class="large grey book icon" data-content="No Appointment"></i>';
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
	<div align="center">
		<div class="ui pagination inverted teal menu" style="text-align:center;margin-top: 20px;">
		    <a class="item prev week" href="?week='.$prev_week.'"><i class="chevron left icon"></i>Previous week</a>
		    <a class="item this week" href="./status.php">Today</a>
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
