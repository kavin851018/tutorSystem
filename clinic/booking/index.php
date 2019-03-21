<?php
$db = 'booking';
require('../../connect_db.php');

/** pagination & week header **/
$this_week = (date('l') == 'Monday')?strtotime('this monday'):strtotime('last monday'); //First day of this week
if(isset($_GET['week'])) $this_week = $_GET['week'];
$prev_week = strtotime('-1 week',$this_week); //First day of past week
$next_week = strtotime('+1 week',$this_week); //First day of next week

$periods = array('13'=>'13:10~14:00','14'=>'14:10~15:00','15'=>'15:10~16:00','16'=>'16:10~17:00','17'=>'17:10~18:00','18'=>'18:10~19:00','19'=>'19:10~20:00','20'=>'20:10~21:00');

//Select semester
$today = date('Y-m-d',$this_week); //This page's today  //這邊的today是當周的周一吧?
$semester = mysql_fetch_array(mysql_query("SELECT * FROM `semester` WHERE '$today' BETWEEN `sem_start_date` AND `sem_end_date`"));
$sem = ($semester['sem_year']==NULL)?'x':$semester['sem_year'];
//用當周的星期一去看是否在學期資料中，如果的確處於某一學期，就取得學期年度，如果沒有就賦值x
//Select semester
?>
<!DOCTYPE html>
<html>
<head>
<meta name="google-site-verification" content="G2m0e8ZyazB08BlQbIdK46xMiDK51C98PrK8TycT7bw" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!--[if IE]>
<p style="text-align:center;font-size:24px;padding:100px 0;">Your IE version is too old.<br>Please upgrade or change to <a href="https://www.google.com/chrome/">Google Chrome</a> / <a href="https://www.mozilla.org/firefox/">Mozilla Firefox</a> for better experiences.</p>
<![endif]-->
<title>自學園 小老師諮詢預約</title>
<link rel="stylesheet" type="text/css" href="../../../plugin/semantic/dist/semantic.min.css">
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
<script type="text/javascript" src="../../../plugin/semantic/dist/semantic.min.js"></script>
<script type="text/javascript" src="main.js"></script>
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
/** Footer **/
.footer_link,
.footer_link:visited,
.footer_link:hover{
	color: #000000;
}
.footer.vertical.segment{
	background-color: #FFF !important;
	width: 100%;
	bottom: 0;
	left: 0;
    /*position: fixed;*/
}
/** Footer **/
i{
	cursor: pointer;
}
</style>
</head>
<body>
<div class="ui main container">
	<?php
	require('rules.php');
	if(isset($_GET['foreign'])){ //Foreign tutor
		echo '
		<div class="ui teal buttons">
			<a class="ui button left floated" href="/">自學園</a>
			<a class="ui button left floated" href="./">一對一諮詢預約</a>
		</div>
		<a href="cpanel"><i class="grey right floated configure icon" style="float:right;"></i></a>
		<h2 class="ui center aligned header" style="margin-top:-15px;">自學園 一對多諮詢預約</h2>
		<p style="text-align:center;color:red;font-weight:bold;font-size:16px;">同一時段可讓5位同學預約</p>';
	}
	else{ //Local tutor
		echo '
		<div class="ui teal buttons">
			<a class="ui button left floated" href="/">自學園</a>
			<a class="ui button left floated" href="?foreign=1">一對多諮詢預約</a>
		</div>
		<a href="cpanel"><i class="grey right floated configure icon" style="float:right;"></i></a>
        <p><h2 class="ui center aligned header" style="margin-top:-15px;">自學園 一對一諮詢預約</h2><br /></p>';
	}
	echo '
	<div class="ui inverted green success message"></div>
	<div class="ui inverted red error message">
	    <div class="header">Error</div>
	</div>
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
		$foreign = (isset($_GET['foreign']))?1:0; //Check tutor selection
		$schedule_sql = mysql_query("SELECT * FROM `schedule` WHERE `foreign`='$foreign' AND `semester`='$sem' AND `deleted`=0");
		$i = 0; //Initialize
		while($schedule = mysql_fetch_array($schedule_sql)){ //Data from db

			$tutor_name[] = $schedule['tutor_name']; //List of tutor name
			$tutor_desc[$schedule['tutor_name']] = $schedule['desc']; //Tutor skill description, using tutor name as hook //就是在這邊造成專長的覆蓋
			$tutor_schedule[$i] = array($schedule['mon'],$schedule['tue'],$schedule['wed'],$schedule['thu'],$schedule['fri']); //List of each tutor's schedule, $tutor_schedule[tutor][day schedule]
			$i++;
		}//第一個key是單純的數字跑過一遍，會把schedule裡面的所有都跑過一遍，重複人名也會，第二個key則是星期，這就是為什麼星期不會被覆蓋

		//Array to save all tutors, 5 days' working periods
		for($x=0;$x<sizeof($tutor_name);$x++){ //Tutors' amount
			$tutor_times[$x] = array();
			for($y=0;$y<5;$y++){ //5 days
				$tutor_times[$x][$y] = array();
				$times = explode('-', $tutor_schedule[$x][$y]); //Split tutor's daily working period
				for($z=0;$z<sizeof($times);$z++){ //Tutor's daily working period
					$tutor_times[$x][$y][$times[$z]] = $tutor_name[$x]; //$tutor_times[tutor][days][times] Every tutor's period collection
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
		//以上可能就是出問題的地方
		//Table result
		foreach($periods as $period => $time){ //Vertical line

			echo '
			<tr>
				<td>'.$time.'</td>';
				for($day=0;$day<5;$day++){ // Horizontal line, 5 days
					$check_date = date('Y-m-d',strtotime('+'.$day.' days',$this_week)); //Actually is 'today' while printing table
					$check_date_expired = date('Y-m-d',strtotime('-1 day',strtotime($check_date))).' 1200'; //Today's booking expired after yesterday noon
					$check_tutor = $horizon_period[$period][$day]; //Tutor name
					$appointment_sql = mysql_query("SELECT * FROM `appointment` WHERE `deleted`=0 AND `date`='$check_date' AND `period`='$period' AND `foreign`='$foreign' AND `tutor`='$check_tutor'");
					$count_appointment_foreign = mysql_num_rows($appointment_sql);
					$holiday_sql = mysql_query("SELECT * FROM `holiday` WHERE '$check_date' BETWEEN `start_date` AND `end_date`");
					$holiday = mysql_fetch_assoc($holiday_sql);
					$tutor_leave = mysql_fetch_assoc(mysql_query("SELECT * FROM `tutor_leave` WHERE `date`='$check_date' AND `period`='$period' AND `tutor`='$check_tutor' AND `approve`=1"));

					echo '<td>';
					if(is_array($check_tutor)){ //Multi tutor in one period

//以下這段程式碼完成了同一個時段多個小老師的任務

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
							$count_appointment_foreign = mysql_num_rows($appointment_sql);
							$tutor_leave = mysql_fetch_assoc(mysql_query("SELECT * FROM `tutor_leave` WHERE `date`='$check_date' AND `period`='$period' AND `tutor`='$multi_tutor_name' AND `approve`=1"));

							if($multi_tutor_name){ //Has tutor start


								echo "<script>console.log('".$multi_tutor_name."');</script>";
								$str=$multi_tutor_name;
								$str=explode('-',$str);
								$str2=$str[0];
								echo "<script>console.log('".$str2."');</script>";
								echo '
								<div class="ui secondary teal raised segment">
									<div>'.$tutor_desc[$multi_tutor_name].' ('.$str2.')</div>';
							}
							//Holiday
							if($check_date >= $holiday['start_date'] && $check_date <= $holiday['end_date'] && $multi_tutor_name){
								echo '<i class="large yellow star icon" data-content="Holiday" style="cursor:default;"></i>';
							}
							//Not Available yet
							elseif($check_date >= date('Y-m-d',strtotime('+15 days')) && $multi_tutor_name){ //2 weeks excluding Sat & Sun
								echo '<i class="large red minus circle icon" data-content="Not available yet" style="cursor:default;"></i>';
							}
							//Tutor take leave
							elseif($tutor_leave['date']==$check_date && $tutor_leave['period']==$period && $tutor_leave['tutor']==$multi_tutor_name){
								if($appointment = mysql_fetch_assoc($appointment_sql)){
									echo '
									<div><i class="teal user icon"></i>'.$appointment['id'].'</div>
									<i class="large red warning circle icon" data-content="Tutor take leave" style="cursor:default;"></i>';
								}
								else{
									echo '<i class="large red warning circle icon" data-content="Tutor take leave" style="cursor:default;"></i>';
								}
							}
							//Expired date
							elseif($check_date_expired <= date('Y-m-d Hi') && $multi_tutor_name){
								if($appointment = mysql_fetch_assoc($appointment_sql)){ //Appointment exist and expired
									if($foreign == 0){
										if($check_date == date('Y-m-d') || $check_date == date('Y-m-d', strtotime('+1 day'))){ //Expired today, announcement to attend on time
											echo '
											<div><i class="teal user icon"></i>'.$appointment['id'].'</div>
											<i class="large grey book icon" data-content="Please attend on time" style="cursor:default;"></i>';
										}
										else{
											echo '
											<div><i class="teal user icon"></i>'.$appointment['id'].'</div>
											<i class="large grey book icon" data-content="Expired" style="cursor:default;"></i>';
										}
									}
									elseif($foreign == 1){
										if($check_date == date('Y-m-d') || $check_date == date('Y-m-d', strtotime('+1 day'))){ //Expired today, announcement to attend in time
											echo '
											<div><i class="teal user icon"></i>'.$appointment['id'].'</div>'; //The first appointment
											while($appointment_foreign = mysql_fetch_array($appointment_sql)){
												echo '<div><i class="teal user icon"></i>'.$appointment_foreign['id'].'</div>'; //Print the rest appointment of this foreign period excluding the first one
											}
											echo '<i class="large grey book icon" data-content="Please attend on time" style="cursor:default;"></i>';
										}
										else{
											echo '
											<div><i class="teal user icon"></i>'.$appointment['id'].'</div>'; //The first appointment
											while($appointment_foreign = mysql_fetch_array($appointment_sql)){
												echo '<div><i class="teal user icon"></i>'.$appointment_foreign['id'].'</div>'; //Print the rest appointment of this foreign period excluding the first one
											}
											echo '<i class="large grey book icon" data-content="Expired" style="cursor:default;"></i>';
										}
									}
								}
								else{ //No appointment and expired
									echo '<i class="large grey book icon" data-content="Expired" style="cursor:default;"></i>';
								}
							}
							//Appointment exist
							elseif($appointment = mysql_fetch_assoc($appointment_sql)){
								if($foreign == 0){
									echo '
									<div><i class="teal user icon"></i>'.$appointment['id'].'</div>
									<i class="large teal edit icon" data-content="Cancel appointment" data-date="'.$check_date.'" data-period="'.$period.'" data-tutor="'.$multi_tutor_name.'"></i>';
								}
								elseif($foreign == 1){
									echo '
									<div><i class="teal user icon"></i>'.$appointment['id'].'</div>'; //The first appointment
									while($appointment_foreign = mysql_fetch_array($appointment_sql)){
										echo '<div><i class="teal user icon"></i>'.$appointment_foreign['id'].'</div>'; //Print the rest appointment of this foreign period excluding the first one
									}
									if($count_appointment_foreign<5){ //Maximum 5 appointments for foreign tutor
										echo '
										<i class="large teal book icon register" data-content="Make appointment" data-date="'.$check_date.'" data-period="'.$period.'" data-tutor="'.$multi_tutor_name.'"></i>
										<i class="large teal edit icon" data-content="Cancel appointment" data-date="'.$check_date.'" data-period="'.$period.'" data-tutor="'.$multi_tutor_name.'"></i>';
									}
									else{
										echo '
										<div>Appointment full.</div>
										<i class="large teal edit icon" data-content="Cancel appointment" data-date="'.$check_date.'" data-period="'.$period.'" data-tutor="'.$multi_tutor_name.'"></i>';
									}
									echo '
									<div class="ui small modal register '.$check_date.' '.$period.' '.$multi_tutor_name.'">
										<i class="close icon"></i>
										<div class="header">
											Make Appointment
										</div>
										<div class="content">
											<form class="ui form register '.$check_date.' '.$period.' '.$multi_tutor_name.'" action="booking_update.php" method="post">
											<input type="hidden" name="foreign" value="'.$foreign.'">
											<div class="field">
												<label>Full Name</label>
												<input type="text" name="name" placeholder="Full Name (in Chinese)">
											</div>
											<div class="field">
												<label>Student ID</label>
												<input type="text" name="id" placeholder="Student ID">
											</div>
											<div class="field">
												<label>Contact Number</label>
												<input type="text" name="phone" placeholder="09xxxxxxxx">
											</div>
											<div class="field">
												<label>Email</label>
												<input type="text" name="email" placeholder="onlinelearning@mail.com">
											</div>
										</div>
										<div class="actions">
									    	<input class="ui green button" type="submit" value="Submit">
											<div class="ui black deny clear button">Cancel</div>
											</form>
										</div>
									</div>';
								}
							}
							//No appointment
							elseif($multi_tutor_name){
								$tutor_desc_explode = explode(',', $tutor_desc[$multi_tutor_name]);
								echo '<i class="large teal book icon register" data-content="Make appointment" data-date="'.$check_date.'" data-period="'.$period.'" data-tutor="'.$multi_tutor_name.'"></i>';
								echo '
								<div class="ui small modal register '.$check_date.' '.$period.' '.$multi_tutor_name.'">
									<i class="close icon"></i>
									<div class="header">
										Make Appointment
									</div>
									<div class="content">
										<form class="ui form register '.$check_date.' '.$period.' '.$multi_tutor_name.'" action="booking_update.php" method="post">
										<input type="hidden" name="foreign" value="'.$foreign.'">
										<div class="field">
											<label>Full Name</label>
											<input type="text" name="name" placeholder="Full Name (in Chinese)">
										</div>
										<div class="field">
											<label>Student ID</label>
											<input type="text" name="id" placeholder="Student ID">
										</div>
										<div class="field">
											<label>Contact Number</label>
											<input type="text" name="phone" placeholder="09xxxxxxxx">
										</div>
										<div class="field">
											<label>Email</label>
											<input type="text" name="email" placeholder="onlinelearning@mail.com">
										</div>';
										if($foreign==1){}
										else{
											echo '
											<div class="field">
											<label>Learning Content</label>
											<select class="ui dropdown" name="learn_content">
												<option value=""></option>';
												foreach($tutor_desc_explode as $desc){
													echo '<option value="'.trim($desc).'">'.trim($desc).'</option>';
												}
											echo '
											</select>
										</div>';
										}
									echo '
									</div>
									<div class="actions">
								    	<input class="ui green button" type="submit" value="Submit">
										<div class="ui black deny clear button">Cancel</div>
										</form>
									</div>
								</div>';
							}
							//Has tutor end
							if($multi_tutor_name){
								echo '</div>';
							}
						}
					}
					else{ //Single tutor in one period
						if($check_tutor){ //Has tutor start
							$tutor_name_temp=explode('-',$check_tutor);
							echo '
							<div class="ui secondary teal raised segment">
								<div>'.$tutor_desc[$check_tutor].' ('.$tutor_name_temp[0].')</div>';
						}
						//Holiday
						if($check_date >= $holiday['start_date'] && $check_date <= $holiday['end_date'] && $check_tutor){
							echo '<i class="large yellow star icon" data-content="Holiday" style="cursor:default;"></i>';
						}
						//Not Available yet
						elseif($check_date >= date('Y-m-d',strtotime('+15 days')) && $check_tutor){ //2 weeks excluding Sat & Sun
							echo '<i class="large red minus circle icon" data-content="Not available yet" style="cursor:default;"></i>';
						}
						//Tutor take leave
						elseif($tutor_leave['date']==$check_date && $tutor_leave['period']==$period && $tutor_leave['tutor']==$check_tutor){
							if($appointment = mysql_fetch_assoc($appointment_sql)){
								echo '
								<div><i class="teal user icon"></i>'.$appointment['id'].'</div>
								<i class="large red warning circle icon" data-content="Tutor take leave" style="cursor:default;"></i>';
							}
							else{
								echo '<i class="large red warning circle icon" data-content="Tutor take leave" style="cursor:default;"></i>';
							}
						}
						//Expired date
						elseif($check_date_expired <= date('Y-m-d Hi') && $check_tutor){
							if($appointment = mysql_fetch_assoc($appointment_sql)){ //Appointment exist and expired
								if($foreign == 0){
									if($check_date == date('Y-m-d') || $check_date == date('Y-m-d', strtotime('+1 day'))){ //Expired today, announcement to attend on time
										echo '
										<div><i class="teal user icon"></i>'.$appointment['id'].'</div>
										<i class="large grey book icon" data-content="Please attend on time" style="cursor:default;"></i>';
									}
									else{
										echo '
										<div><i class="teal user icon"></i>'.$appointment['id'].'</div>
										<i class="large grey book icon" data-content="Expired" style="cursor:default;"></i>';
									}
								}
								elseif($foreign == 1){
									if($check_date == date('Y-m-d') || $check_date == date('Y-m-d', strtotime('+1 day'))){ //Expired today, announcement to attend in time
										echo '
										<div><i class="teal user icon"></i>'.$appointment['id'].'</div>'; //The first appointment
										while($appointment_foreign = mysql_fetch_array($appointment_sql)){
											echo '<div><i class="teal user icon"></i>'.$appointment_foreign['id'].'</div>'; //Print the rest appointment of this foreign period excluding the first one
										}
										echo '<i class="large grey book icon" data-content="Please attend on time" style="cursor:default;"></i>';
									}
									else{
										echo '
										<div><i class="teal user icon"></i>'.$appointment['id'].'</div>'; //The first appointment
										while($appointment_foreign = mysql_fetch_array($appointment_sql)){
											echo '<div><i class="teal user icon"></i>'.$appointment_foreign['id'].'</div>'; //Print the rest appointment of this foreign period excluding the first one
										}
										echo '<i class="large grey book icon" data-content="Expired" style="cursor:default;"></i>';
									}
								}
							}
							else{ //No appointment and expired
								echo '<i class="large grey book icon" data-content="Expired" style="cursor:default;"></i>';
							}
						}
						//Appointment exist
						elseif($appointment = mysql_fetch_assoc($appointment_sql)){
							if($foreign == 0){
								echo '
								<div><i class="teal user icon"></i>'.$appointment['id'].'</div>
								<i class="large teal edit icon" data-content="Cancel appointment" data-date="'.$check_date.'" data-period="'.$period.'" data-tutor="'.$check_tutor.'"></i>';
							}
							elseif($foreign == 1){
								echo '
								<div><i class="teal user icon"></i>'.$appointment['id'].'</div>'; //The first appointment
								while($appointment_foreign = mysql_fetch_array($appointment_sql)){
									echo '<div><i class="teal user icon"></i>'.$appointment_foreign['id'].'</div>'; //Print the rest appointment of this foreign period excluding the first one
								}
								if($count_appointment_foreign<5){ //Maximum 5 appointments for foreign tutor
									echo '
									<i class="large teal book icon register" data-content="Make appointment" data-date="'.$check_date.'" data-period="'.$period.'" data-tutor="'.$check_tutor.'"></i>
									<i class="large teal edit icon" data-content="Cancel appointment" data-date="'.$check_date.'" data-period="'.$period.'" data-tutor="'.$check_tutor.'"></i>';
								}
								else{
									echo '
									<div>Appointment full.</div>
									<i class="large teal edit icon" data-content="Cancel appointment" data-date="'.$check_date.'" data-period="'.$period.'" data-tutor="'.$check_tutor.'"></i>';
								}
								echo '
								<div class="ui small modal register '.$check_date.' '.$period.' '.$check_tutor.'">
									<i class="close icon"></i>
									<div class="header">
										Make Appointment
									</div>
									<div class="content">
										<form class="ui form register '.$check_date.' '.$period.' '.$check_tutor.'" action="booking_update.php" method="post">
										<input type="hidden" name="foreign" value="'.$foreign.'">
										<div class="field">
											<label>Full Name</label>
											<input type="text" name="name" placeholder="Full Name (in Chinese)">
										</div>
										<div class="field">
											<label>Student ID</label>
											<input type="text" name="id" placeholder="Student ID">
										</div>
										<div class="field">
											<label>Contact Number</label>
											<input type="text" name="phone" placeholder="09xxxxxxxx">
										</div>
										<div class="field">
											<label>Email</label>
											<input type="text" name="email" placeholder="onlinelearning@mail.com">
										</div>
									</div>
									<div class="actions">
								    	<input class="ui green button" type="submit" value="Submit">
										<div class="ui black deny clear button">Cancel</div>
										</form>
									</div>
								</div>';
							}
						}
						//No appointment
						elseif($check_tutor){
							$tutor_desc_explode = explode(',', $tutor_desc[$check_tutor]);
							echo '<i class="large teal book icon register" data-content="Make appointment" data-date="'.$check_date.'" data-period="'.$period.'" data-tutor="'.$check_tutor.'"></i>';
							echo '
							<div class="ui small modal register '.$check_date.' '.$period.' '.$check_tutor.'">
								<i class="close icon"></i>
								<div class="header">
									Make Appointment
								</div>
								<div class="content">
									<form class="ui form register '.$check_date.' '.$period.' '.$check_tutor.'" action="booking_update.php" method="post">
									<input type="hidden" name="foreign" value="'.$foreign.'">
									<div class="field">
										<label>Full Name</label>
										<input type="text" name="name" placeholder="Full Name (in Chinese)">
									</div>
									<div class="field">
										<label>Student ID</label>
										<input type="text" name="id" placeholder="Student ID">
									</div>
									<div class="field">
										<label>Contact Number</label>
										<input type="text" name="phone" placeholder="09xxxxxxxx">
									</div>
									<div class="field">
										<label>Email</label>
										<input type="text" name="email" placeholder="onlinelearning@mail.com">
									</div>';
									if($foreign==1){}
									elseif($foreign==0){
										echo '
										<div class="field">
										<label>Learning Content</label>
										<select class="ui dropdown" name="learn_content">
											<option value=""></option>';
											foreach($tutor_desc_explode as $desc){
												echo '<option value="'.trim($desc).'">'.trim($desc).'</option>';
											}
										echo '
										</select>
									</div>';
									}
								echo '
								</div>
								<div class="actions">
							    	<input class="ui green button" type="submit" value="Submit">
									<div class="ui black deny clear button">Cancel</div>
									</form>
								</div>
							</div>';
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
	<div class="ui small modal delete">
		<i class="close icon"></i>
		<div class="header">
			Cancel Appointment
		</div>
		<div class="content">
			<form class="ui form delete" action="booking_update.php" method="post">
			<div class="field">
				<label>Full Name</label>
				<input type="text" name="name" placeholder="Full Name (in Chinese)">
			</div>
			<div class="field">
				<label>Student ID</label>
				<input type="text" name="id" placeholder="Student ID">
			</div>
			<div class="field">
				<label>Contact Number</label>
				<input type="text" name="phone" placeholder="09xxxxxxxx">
			</div>
		</div>
		<div class="actions">
			<input class="ui green button" type="submit" value="Submit">
			<div class="ui black deny clear button">Cancel</div>
			</form>
		</div>
	</div>
	<div align="center">
		<div class="ui pagination inverted teal menu" style="text-align:center;margin-top: 20px;">';
			if(isset($_GET['foreign'])){ //Foreign tutor
				echo '
			    <a class="item prev week" href="?foreign=1&week='.$prev_week.'"><i class="chevron left icon"></i>Previous week</a>
			    <a class="item this week" href="./?foreign=1">Today</a>
			    <a class="item next week" href="?foreign=1&week='.$next_week.'">Next week<i class="chevron right icon"></i></a>';
			}
			else{
				echo '
			    <a class="item prev week" href="?week='.$prev_week.'"><i class="chevron left icon"></i>Previous week</a>
			    <a class="item this week" href="./">Today</a>
			    <a class="item next week" href="?week='.$next_week.'">Next week<i class="chevron right icon"></i></a>';
			}
			echo '
		</div>
	</div>';
	?>
</div>
<div class="ui footer vertical basic segment">
    <div class="ui grid container">
        <div class="center aligned column">

            <a href="mailto:onlinelearning@mail.nsysu.edu.tw" class="footer_link">onlinelearning@mail.nsysu.edu.tw</a> | 07-5252000 #3149
            <br>
            <?php
            /* Since year counter */
            $since = '2016';
            $year = $since;
            $thisyear = date('Y');
            if($thisyear>$since)
                $year = $since.' - '.$thisyear;
            else
            	$year = $since;
            /* Since year counter */
            echo '
            Copyright &copy; '.$year.' <a href="http://etc.nsysu.edu.tw" target="_blank" class="footer_link">English Teaching Center, NSYSU</a>';
            ?>
        </div>
    </div>
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
