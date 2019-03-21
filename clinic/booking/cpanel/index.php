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
<title>自學園小老師預約管理後台</title>
<link rel="stylesheet" type="text/css" href="../../../../plugin/semantic/dist/semantic.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.rawgit.com/mdehoog/Semantic-UI/6e6d051d47b598ebab05857545f242caf2b4b48c/dist/components/calendar.min.css" />
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
<script type="text/javascript" src="../../../../plugin/semantic/dist/semantic.min.js"></script>
<script type="text/javascript" src="https://cdn.rawgit.com/mdehoog/Semantic-UI/6e6d051d47b598ebab05857545f242caf2b4b48c/dist/components/calendar.min.js"></script>
<script type="text/javascript" src="cpanel.js"></script>
<link rel="stylesheet" type="text/css" href="cpanel.css">
<style type="text/css">
body > .grid{
    height: 100%;
}
.message, .hidden{
    display: none;
}
</style>
</head>
<body>
	<?php
	if($_SESSION['booking_login']==null){
		echo '
		<div class="ui middle aligned center aligned grid">
			<div class="column" style="width:450px;">
				<h2 class="ui blue header">
			      	<div class="content">自學園小老師預約管理後台</div>
			    </h2>
				<form class="ui form login" action="cpanel_update.php" method="post">
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
	elseif($_SESSION['booking_login'] == 'englishplaza'){
		$now = time();
		if($now>$_SESSION['expire']){
			session_destroy();
			header('Refresh:0');
		}
		else{
			echo '
			<i id="back-to-top" class="arrow up big icon"></i>
			<div class="ui container" style="padding:10px 0px;">
				<a class="ui teal button left floated" href="../">小老師預約</a>
				<a class="ui red button right floated" href="logout.php">登出</a>
				<h2 class="ui center aligned header" style="margin-top:5px;">自學園小老師預約管理後台</h2>
				<div class="ui blue fluid three item menu">
					<a class="item" data-url="booking_list">預約記錄查詢</a>
					<a class="item" data-url="blacklist">黑名單</a>
					<a class="item" data-url="holiday">假期</a>
				</div>
				<div class="ui success message" id="success_message"></div>
				<div class="ui error message" id="error_message">
				    <p>請聯絡系統管理員。</p>
				</div>
				<div id="booking_list" class="hidden">';
					booking_list();
				echo '
				</div>
				<div id="blacklist" class="hidden">';
					blacklist();
				echo '
				</div>
				<div id="holiday" class="hidden">';
					holiday();
				echo '
				</div>
			</div>';
		}
	}
    elseif($_SESSION['booking_login'] == 'tutor'){
        $now = time();
        if($now>$_SESSION['expire']){
            session_destroy();
            header('Refresh:0');
        }
        else{

            echo '
			<i id="back-to-top" class="arrow up big icon"></i>
			<div class="ui container" style="padding:10px 0px;">
				<a class="ui teal button left floated" href="../">小老師預約</a>
				<a class="ui red button right floated" href="logout.php">登出</a>
				<h2 class="ui center aligned header" style="margin-top:5px;">自學園小老師預約管理後台</h2>
				<div class="ui blue fluid item menu">
					<a class="item" data-url="booking_onlylook">預約記錄查詢</a>
				</div>
				<div class="ui success message" id="success_message"></div>
				<div class="ui error message" id="error_message">
				    <p>請聯絡系統管理員。</p>
				</div>
				<div id="booking_onlylook" class="hidden">';
                booking_onlylook();
            echo '
				</div>


			</div>';
        }
    }
	elseif($_SESSION['booking_login'] == 'admin'){
		$now = time();
		if($now>$_SESSION['expire']){
			session_destroy();
			header('Refresh:0');
		}
		else{
			echo '
			<i id="back-to-top" class="arrow up big icon"></i>
			<div class="ui container" style="padding:10px 0px;">
				<a class="ui teal button left floated" href="../">小老師預約</a>
				<a class="ui red button right floated" href="logout.php">登出</a>
				<h2 class="ui center aligned header" style="margin-top:5px;">自學園小老師預約管理後台</h2>
				<div class="ui blue fluid four item menu">
					<a class="item" data-url="booking_list">預約記錄查詢</a>
					<a class="item" data-url="blacklist">黑名單</a>
					<a class="item" data-url="holiday">假期</a>
					<a class="item" data-url="setting">後台設定</a>
				</div>
				<div class="ui success message" id="success_message"></div>
				<div class="ui error message" id="error_message">
				    <div class="header">更新失敗</div>
				    <p>請聯絡系統管理員。</p>
				</div>
				<div id="booking_list" class="hidden">';
					booking_list();
				echo '
				</div>
				<div id="blacklist" class="hidden">';
					blacklist();
				echo '
				</div>
				<div id="holiday" class="hidden">';
					holiday();
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
function booking_list(){
	global $sem_start_date,$sem_end_date;
	echo '
	<p><div class="ui calendar input datepick booking"><input type="text" id="bookingSearch" placeholder="選擇日期"></div></p>
	<div align="center">
	<table class="ui selectable celled center aligned table">
		<thead>
			<tr>
				<th rowspan="">Name</th>
				<th rowspan="">Student ID</th>
				<th rowspan="">Phone</th>
				<th colspan="">Email</th>
				<th rowspan="">Learning Content</th>
				<th rowspan="">Date</th>
				<th>Start time</th>
				<th>Tutor</th>
				<th width="85px"></th>
			</tr>
		</thead>';
    echo "<script>console.log(1);</script>";

	$appointment_sql = mysql_query("SELECT * FROM `appointment` WHERE (`date` BETWEEN '$sem_start_date' AND '$sem_end_date') AND `deleted`=0 ORDER BY `date` DESC,`period`,`foreign`,`tutor`");
	while($appointment = mysql_fetch_array($appointment_sql)){
		$date = date('Y/m/d',strtotime($appointment['date']));
		echo '
		<tr id="'.$appointment['rno'].'" class="booking_search '.$appointment['date'].'">
			<td>'.$appointment['name'].'</td>
			<td>'.$appointment['id'].'</td>
			<td>'.$appointment['phone'].'</td>
			<td>'.$appointment['email'].'</td>
			<td>'.$appointment['content'].'</td>
			<td>'.$date.'</td>
			<td>'.$appointment['period'].':00</td>
			<td>'.$appointment['tutor'].'</td>
			<td><button type="button" class="ui red compact basic button delete" data-rno="'.$appointment['rno'].'">刪除</button></td>
		</tr>';
	}
	echo '
	</table>
	</div>';
}

function booking_onlylook(){
    global $sem_start_date,$sem_end_date;
    echo '
	<p><div class="ui calendar input datepick booking"><input type="text" id="bookingSearch" placeholder="選擇日期"></div></p>
	<div align="center">
	<table class="ui selectable celled center aligned table">
		<thead>
			<tr>
				<th rowspan="">Name</th>
				<th rowspan="">Student ID</th>
				<th rowspan="">Learning Content</th>
				<th rowspan="">Date</th>
				<th>Start time</th>
				<th>Tutor</th>

			</tr>
		</thead>';

    $appointment_sql = mysql_query("SELECT * FROM `appointment` WHERE (`date` BETWEEN '$sem_start_date' AND '$sem_end_date') AND `deleted`=0 ORDER BY `date` DESC,`period`,`foreign`,`tutor`");
    while($appointment = mysql_fetch_array($appointment_sql)){
        $date = date('Y/m/d',strtotime($appointment['date']));
        echo '
		<tr id="'.$appointment['rno'].'" class="booking_search '.$appointment['date'].'">
			<td>'.$appointment['name'].'</td>
			<td>'.$appointment['id'].'</td>

			<td>'.$appointment['content'].'</td>
			<td>'.$date.'</td>
			<td>'.$appointment['period'].':00</td>
			<td>'.$appointment['tutor'].'</td>

		</tr>';
    }
    echo '
	</table>
	</div>';
}
function blacklist(){
	echo '
	<div align="center">
	<b style="color:red;font-size:16px;"><u>開始日期</u>請由缺席/遲到日算起</b>
	<table class="ui selectable collapsing celled center aligned table">
		<thead>
			<tr>
				<th>Student ID</th>
				<th>Start Date</th>
				<th>End Date</th>
				<th></th>
			</tr>
		</thead>
		<tr id="create_blacklist">
			<form class="ui form create_blacklist" action="cpanel_update.php" method="post">
			<td><div class="ui input"><input type="text" name="id" class="create_blacklist id" placeholder="學號"></div></td>
			<td><div class="ui calendar input datepick"><input type="text" name="start_date" class="create_blacklist start_date" placeholder="開始日期"></div></td>
			<td><div class="ui disabled input"><input type="text"></div></td>
			<td><button class="ui blue compact basic button create-blacklist" type="submit">新增</button></td>
			</form>
		</tr>';
	$today = date('Y-m-d');
	$blacklist_sql = mysql_query("SELECT * FROM `blacklist` WHERE `deleted`=0 AND `end_date`>'$today' ORDER BY `start_date` DESC");
	while($blacklist = mysql_fetch_array($blacklist_sql)){
		echo '
		<tr id="blacklist'.$blacklist['rno'].'">
			<td>'.$blacklist['id'].'</td>
			<td>'.$blacklist['start_date'].'</td>
			<td>'.$blacklist['end_date'].'</td>
			<td><button type="button" class="ui red compact basic button blacklist-delete" data-rno="'.$blacklist['rno'].'">刪除</button></td>
		</tr>';
	}
	echo '
	</table>
	</div>';
}

function holiday(){
	global $sem_start_date,$sem_end_date;
	echo '
	<div align="center">
	<table class="ui selectable collapsing celled center aligned table">
		<thead>
			<tr>
				<th>Start Date</th>
				<th>End Date</th>
				<th>備註</th>
				<th></th>
			</tr>
		</thead>
		<tr id="create_holiday">
			<form class="ui form create_holiday" action="cpanel_update.php" method="post">
			<td><div class="ui calendar input datepick"><input type="text" name="start_date" class="create_holiday start_date" placeholder="開始日期"></div></td>
			<td><div class="ui calendar input datepick"><input type="text" name="end_date" class="create_holiday end_date" placeholder="結束日期"></div></td>
			<td><div class="ui input"><input type="text" name="remark" placeholder="備註"></div></td>
			<td><button class="ui blue compact basic button create-holiday" type="submit">新增</button></td>
			</form>
		</tr>';
	$today = date('Y-m-d');
	$holiday_sql = mysql_query("SELECT * FROM `holiday` WHERE `start_date`>='$sem_start_date' AND `end_date`<='$sem_end_date' ORDER BY `rno` DESC");
	while($holiday = mysql_fetch_array($holiday_sql)){
		echo '
		<tr id="holiday'.$holiday['rno'].'">
			<td>'.$holiday['start_date'].'</td>
			<td>'.$holiday['end_date'].'</td>
			<td>'.$holiday['remark'].'</td>
			<td><button type="button" class="ui red compact basic button holiday-delete" data-rno="'.$holiday['rno'].'">刪除</button></td>
		</tr>';
	}
	echo '
	</table>
	</div>';
}

function setting(){
	global $sem;
	$get_tutor = mysql_query("SELECT * FROM `tutor` WHERE `deleted`=0");

	//Create tutor schedule
	$get_speciality = mysql_query("SELECT * FROM `speciality` WHERE `deleted`=0");
	$get_schedule = mysql_query("SELECT * FROM `schedule` WHERE `semester`='$sem' AND `deleted`=0 ORDER BY `foreign`");
	$week = array('mon','tue','wed','thu','fri');
	$period = array('13'=>'13:10~14:00','14'=>'14:10~15:00','15'=>'15:10~16:00','16'=>'16:10~17:00','17'=>'17:10~18:00','18'=>'18:10~19:00','19'=>'19:10~20:00','20'=>'20:10~21:00');
	echo '
	<div align="center">
	<b style="font-size:16px;">小老師班表 <span style="color:red;">(同一時段最多兩位小老師)</span></b>
	<table class="ui center aligned celled table create_schedule">
		<thead>
			<tr>
				<th width="115px">姓名</th>
				<th width="105px">學期</th>
				<th width="125px">專長</th>
				<th>Monday</th>
				<th>Tuesday</th>
				<th>Wednesday</th>
				<th>Thusday</th>
				<th>Friday</th>
				<th width="85px"></th>
			</tr>
		</thead>';
		while($schedule = mysql_fetch_array($get_schedule)){
      $tutor_name_temp=explode('-',$schedule['tutor_name']);
			echo '
			<tr id="schedule'.$schedule['rno'].'">
				<td>'.$tutor_name_temp[0].'</td>
				<td>'.$schedule['semester'].'</td>
				<td>'.$schedule['desc'].'</td>
				<td>'.str_replace('-',',',$schedule['mon']).'</td>
				<td>'.str_replace('-',',',$schedule['tue']).'</td>
				<td>'.str_replace('-',',',$schedule['wed']).'</td>
				<td>'.str_replace('-',',',$schedule['thu']).'</td>
				<td>'.str_replace('-',',',$schedule['fri']).'</td>
				<td><button type="button" class="ui red compact basic button schedule-delete" data-rno="'.$schedule['rno'].'">刪除</button></td>
			</tr>';
		}
		echo '
		<tr id="create_schedule">
			<form class="ui form create_schedule" action="cpanel_update.php" method="post">';
			echo '
			<td>
				<div class="ui fluid selection dropdown create_schedule tutor">
					<input type="hidden" name="name">
					<i class="dropdown icon"></i>
					<div class="default text"></div>
					<div class="menu">';
				while($tutor = mysql_fetch_assoc($get_tutor)){
					echo '<div class="item" data-value="'.$tutor['name'].'" data-foreign="'.$tutor['foreign'].'">'.$tutor['name'].'</div>';
				}
				mysql_data_seek($get_tutor,0); //Reset mysql query
				echo '
					</div>
				</div>
			</td>
			<td>
				<div class="ui fluid input">
					<input type="text" name="sem" class="create_schedule sem" placeholder="eg: 1051">
				</div>
			</td>
			<td>
				<div class="ui fluid multiple selection dropdown create_schedule desc">
					<input type="hidden" name="desc">
					<i class="dropdown icon"></i>
					<div class="default text"></div>
					<div class="menu">';
					while($desc = mysql_fetch_assoc($get_speciality)){
						echo '<div class="item" data-value="'.$desc['speciality'].'">'.$desc['speciality'].'</div>';
					}
				echo '
					</div>
				</div>
			</td>';
			foreach($week as $weeks){ //5 days
				echo '
				<td>
					<div class="ui fluid multiple selection dropdown create_schedule '.$weeks.'">
						<input type="hidden" name="'.$weeks.'">
						<i class="dropdown icon"></i>
						<div class="default text"></div>
						<div class="menu">';
						foreach($period as $periods => $time){
							echo '<div class="item" data-value="'.$periods.'">'.$time.'</div>';
						}
					echo '
						</div>
					</div>
				</td>';
			}
			echo '
				<td><button class="ui blue compact basic button create-schedule" type="submit">新增</button></td>
			</form>
		</tr>
	</table>
	<div class="ui fluid error message create_schedule"></div>
	</div>

	<br>
	<div align="center">
	<b style="font-size:16px;">小老師資訊</b>
	<table class="ui selectable celled padded center aligned table">
		<thead>
			<tr>
				<th>姓名</th>
				<th width="15%">學號</th>
				<th width="20%">系所</th>
				<th>電話</th>
				<th>Email</th>
				<th>外籍</th>
				<th width="10%"></th>
			</tr>
		</thead>';
		while($tutor = mysql_fetch_array($get_tutor)){
			echo '
			<tr id="tutor'.$tutor['rno'].'">
				<form class="ui form edit_tutor" action="cpanel_update.php" method="post">
				<td>
					<div class="content name">'.$tutor['name'].'</div>
					<div class="ui input">
						<input type="text" name="name" class="edit_tutor name hidden" value="'.$tutor['name'].'">
					</div>
				</td>
				<td>
					<div class="content id">'.$tutor['id'].'</div>
					<div class="ui fluid input">
						<input type="text" name="id" class="edit_tutor id hidden"  value="'.$tutor['id'].'">
					</div>
				</td>
				<td>
					<div class="content dept">'.$tutor['dept'].'</div>
					';
					require('department2.php');
					echo '
				</td>
				<td>
					<div class="content phone">'.$tutor['phone'].'</div>
					<div class="ui input">
						<input type="text" name="phone" class="edit_tutor phone hidden" value="'.$tutor['phone'].'">
					</div>
				</td>
				<td>
					<div class="content email">'.$tutor['email'].'</div>
					<div class="ui input">
						<input type="text" name="email" class="edit_tutor email hidden" value="'.$tutor['email'].'">
					</div>
				</td>
				<td>
					<div class="content">';
						if($tutor['foreign']==1) echo '<i class="checkmark icon"></i>';
						echo '
					</div>
				</td>
				<td>
				<button type="button" class="ui green compact basic button edit tutor-edit" data-rno="'.$tutor['rno'].'">修改</button>
				<button type="submit" class="ui blue compact basic button tutor-complete" style="display:none;" data-rno="'.$tutor['rno'].'">完成</button>
				<button type="button" class="ui red compact basic button tutor-delete" data-rno="'.$tutor['rno'].'">刪除</button>
				<button type="button" class="ui red compact basic button tutor-cancel" style="display:none;" data-rno="'.$tutor['rno'].'">取消</button>

				</td>
				</form>
			</tr>';
		}
		echo '
		<tr id="create_tutor">
			<form class="ui form create_tutor" action="cpanel_update.php" method="post">
			<td><div class="ui input"><input type="text" name="name" class="create_tutor name" placeholder="姓名"></div></td>
			<td><div class="ui fluid input"><input type="text" name="id" class="create_tutor id"  placeholder="學號"></div></td>
			<td>';
				require('department.php');
				echo '
			</td>
			<td><div class="ui input"><input type="text" name="phone" class="create_tutor phone" placeholder="手機號碼"></div></td>
			<td><div class="ui input"><input type="text" name="email" class="create_tutor email" placeholder="Email"></div></td>
			<td><div class="ui fitted checkbox"><input type="checkbox" name="foreign" class="create_tutor foreign"></div></td>
			<td><button class="ui blue compact basic button create-tutor" type="submit">新增</button></td>
			</form>
		</tr>
	</table>
	<div class="ui fluid error message create_tutor"></div>
	</div>

	<br>
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
			<form class="ui form create_sem" action="cpanel_update.php" method="post">
			<td><div class="ui input"><input type="number" name="sem_year" class="create_sem sem_year" placeholder="eg: 1051"></div></td>
			<td><div class="ui calendar input datepick"><input type="text" name="sem_start_date" class="create_sem sem_start_date" placeholder="學期開始日期"></div></td>
			<td><div class="ui calendar input datepick"><input type="text" name="sem_end_date" class="create_sem sem_end_date" placeholder="學期結束日期"></div></td>
			<td><button class="ui blue compact basic button create-sem" type="submit">新增</button></td>
			</form>
		</tr>
	</table>
	</div>

	<br>
	<div align="center">
		<b style="font-size:16px;">更新管理員密碼</b>
		<div class="ui segment" style="width:450px;text-align:left;">
			<form class="ui form update_pw" action="cpanel_update.php" method="post">
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
?>
