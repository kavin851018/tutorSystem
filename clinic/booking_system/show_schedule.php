<?php
$target = "login.htm";
include 'check_login.php';

if( $valid )
{
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=big5">
<title>The Booking Manager</title>
<style type="text/css">
<!--
.title {font-family:Arial, Helvetica, sans-serif;font-size:13px;color:white}
.content {font-family:Arial, Helvetica, sans-serif;font-size:13px;color:black}
.style2 {font-family: "標楷體";	font-size: 18px;	color: #006633;}
.table_class {font-size:13px; color:#990000}
.table_teacher {font-family:Arial, Helvetica, sans-serif;font-size:13px;color:blue}
-->
</style>
</head>
<body>
<table width="770" border="0" cellpadding="3">
  <tr>
    <td width="50">&nbsp;</td>
    <td background="../images/subject_line.gif"><img src="../images/subject.gif" width="25" height="25" align="absmiddle">　<span class="style2">最新消息</span></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><p>．英語諮詢服務時段一覽表<br>
        　自學中心(文學院3F)</p>
        <table width="500" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#FF6600">
          <tr bgcolor="#FFA86F" class="content">
            <td colspan="6"><div align="center" class="title">The schedule of DELL Room [<a href="book.php?room=dell" target="_blank">預約(Booking)</a>]</div></td>
          </tr>
          <tr bgcolor="#FFDEC8" class="content">
            <td bgcolor="#FFDEC8"><div align="center">Time</div></td>
            <td width="75"><div align="center">Monday</div></td>
            <td width="75" bgcolor="#FFDEC8"><div align="center">Tuesday</div></td>
            <td width="75" bgcolor="#FFDEC8"><div align="center">Wednesday</div></td>
            <td width="75" bgcolor="#FFDEC8"><div align="center">Thursday</div></td>
            <td width="75" bgcolor="#FFDEC8"><div align="center">Friday</div></td>
          </tr>
<?php
// Select the schedule from DELL
include '../../connect_db.php';
$sql = "Select * From schedule";
$result = mysql_query($sql, $conn) or die(mysql_error());
$i = 0;
while( $row = mysql_fetch_array($result) )
{
	$tutor_name[$i] = $row['tutor_name'];
	$monday[$i] = $row['monday'];
	$tuesday[$i] = $row['tuesday'];
	$wednesday[$i] = $row['wednesday'];
	$thursday[$i] = $row['thursday'];
	$friday[$i] = $row['friday'];
	$i++;
}

if($i)
{
	$sql = "Select * From class_title Where location='DELL'";
	$result = mysql_query($sql, $conn) or die(mysql_error());
	$j = 0;
	while( $row = mysql_fetch_array($result) )
	{
		$title_name[$j] = $row['title_name'];
		$t_monday[$j] = $row['monday'];
		$t_tuesday[$j] = $row['tuesday'];
		$t_wednesday[$j] = $row['wednesday'];
		$t_thursday[$j] = $row['thursday'];
		$t_friday[$j] = $row['friday'];
		$j++;
	}
?>
          <tr bgcolor="white" class="content">
            <td bgcolor="#FFDEC8"><div align="center">9:00~10:00</div></td>
            <td width="75" bgcolor="white"><?php if($j) print_title(1024, $t_monday, $title_name, $j); print_tutor(1024, $monday, $tutor_name, $i);?></td>
            <td width="75" bgcolor="white"><?php if($j) print_title(1024, $t_tuesday, $title_name, $j);print_tutor(1024, $tuesday, $tutor_name, $i);?></td>
            <td width="75" bgcolor="white"><?php if($j) print_title(1024, $t_wednesday, $title_name, $j);print_tutor(1024, $wednesday, $tutor_name, $i);?></td>
            <td width="75" bgcolor="white"><?php if($j) print_title(1024, $t_thursday, $title_name, $j);print_tutor(1024, $thursday, $tutor_name, $i);?></td>
            <td width="75" bgcolor="white"><?php if($j) print_title(1024, $t_friday, $title_name, $j);print_tutor(1024, $friday, $tutor_name, $i);?></td>
          </tr>
          <tr bgcolor="white" class="content">
            <td bgcolor="#FFDEC8"><div align="center">10:00~11:00</div></td>
            <td width="75" bgcolor="#FFECCE"><?php if($j) print_title(512, $t_monday, $title_name, $j);print_tutor(512, $monday, $tutor_name, $i);?></td>
            <td width="75" bgcolor="#FFECCE"><?php if($j) print_title(512, $t_tuesday, $title_name, $j);print_tutor(512, $tuesday, $tutor_name, $i);?></td>
            <td width="75" bgcolor="#FFECCE"><?php if($j) print_title(512, $t_wednesday, $title_name, $j);print_tutor(512, $wednesday, $tutor_name, $i);?></td>
            <td width="75" bgcolor="#FFECCE"><?php if($j) print_title(512, $t_thursday, $title_name, $j);print_tutor(512, $thursday, $tutor_name, $i);?></td>
            <td width="75" bgcolor="#FFECCE"><?php if($j) print_title(512, $t_friday, $title_name, $j);print_tutor(512, $friday, $tutor_name, $i);?></td>
          </tr>
          <tr bgcolor="white" class="content">
            <td bgcolor="#FFDEC8"><div align="center">11:00~12:00</div></td>
            <td width="75" bgcolor="white"><?php if($j) print_title(256, $t_monday, $title_name, $j);print_tutor(256, $monday, $tutor_name, $i);?></td>
            <td width="75" bgcolor="white"><?php if($j) print_title(256, $t_tuesday, $title_name, $j);print_tutor(256, $tuesday, $tutor_name, $i);?></td>
            <td width="75" bgcolor="white"><?php if($j) print_title(256, $t_wednesday, $title_name, $j);print_tutor(256, $wednesday, $tutor_name, $i);?></td>
            <td width="75" bgcolor="white"><?php if($j) print_title(256, $t_thursday, $title_name, $j);print_tutor(256, $thursday, $tutor_name, $i);?></td>
            <td width="75" bgcolor="white"><?php if($j) print_title(256, $t_friday, $title_name, $j);print_tutor(256, $friday, $tutor_name, $i);?></td>
          </tr>
          <tr bgcolor="white" class="content">
            <td bgcolor="#FFDEC8"><div align="center">12:00~13:00</div></td>
            <td width="75" bgcolor="#FFECCE"><?php if($j) print_title(128, $t_monday, $title_name, $j);print_tutor(128, $monday, $tutor_name, $i);?></td>
            <td width="75" bgcolor="#FFECCE"><?php if($j) print_title(128, $t_tuesday, $title_name, $j);print_tutor(128, $tuesday, $tutor_name, $i);?></td>
            <td width="75" bgcolor="#FFECCE"><?php if($j) print_title(128, $t_wednesday, $title_name, $j);print_tutor(128, $wednesday, $tutor_name, $i);?></td>
            <td width="75" bgcolor="#FFECCE"><?php if($j) print_title(128, $t_thursday, $title_name, $j);print_tutor(128, $thursday, $tutor_name, $i);?></td>
            <td width="75" bgcolor="#FFECCE"><?php if($j) print_title(128, $t_friday, $title_name, $j);print_tutor(128, $friday, $tutor_name, $i);?></td>
          </tr>
          <tr bgcolor="white" class="content">
            <td bgcolor="#FFDEC8"><div align="center">13:00~14:00</div></td>
            <td width="75" bgcolor="white"><?php if($j) print_title(64, $t_monday, $title_name, $j);print_tutor(64, $monday, $tutor_name, $i);?></td>
            <td width="75" bgcolor="white"><?php if($j) print_title(64, $t_tuesday, $title_name, $j);print_tutor(64, $tuesday, $tutor_name, $i);?></td>
            <td width="75" bgcolor="white"><?php if($j) print_title(64, $t_wednesday, $title_name, $j);print_tutor(64, $wednesday, $tutor_name, $i);?></td>
            <td width="75" bgcolor="white"><?php if($j) print_title(64, $t_thursday, $title_name, $j);print_tutor(64, $thursday, $tutor_name, $i);?></td>
            <td width="75" bgcolor="white"><?php if($j) print_title(64, $t_friday, $title_name, $j);print_tutor(64, $friday, $tutor_name, $i);?></td>
          </tr>
          <tr bgcolor="white" class="content">
            <td bgcolor="#FFDEC8"><div align="center">14:00~15:00</div></td>
            <td width="75" bgcolor="#FFECCE"><?php if($j) print_title(32, $t_monday, $title_name, $j);print_tutor(32, $monday, $tutor_name, $i);?></td>
            <td width="75" bgcolor="#FFECCE"><?php if($j) print_title(32, $t_tuesday, $title_name, $j);print_tutor(32, $tuesday, $tutor_name, $i);?></td>
            <td width="75" bgcolor="#FFECCE"><?php if($j) print_title(32, $t_wednesday, $title_name, $j);print_tutor(32, $wednesday, $tutor_name, $i);?></td>
            <td width="75" bgcolor="#FFECCE"><?php if($j) print_title(32, $t_thursday, $title_name, $j);print_tutor(32, $thursday, $tutor_name, $i);?></td>
            <td width="75" bgcolor="#FFECCE"><?php if($j) print_title(32, $t_friday, $title_name, $j);print_tutor(32, $friday, $tutor_name, $i);?></td>
          </tr>
          <tr bgcolor="white" class="content">
            <td bgcolor="#FFDEC8"><div align="center">15:00~16:00</div></td>
            <td width="75" bgcolor="white"><?php if($j) print_title(16, $t_monday, $title_name, $j);print_tutor(16, $monday, $tutor_name, $i);?></td>
            <td width="75" bgcolor="white"><?php if($j) print_title(16, $t_tuesday, $title_name, $j);print_tutor(16, $tuesday, $tutor_name, $i);?></td>
            <td width="75" bgcolor="white"><?php if($j) print_title(16, $t_wednesday, $title_name, $j);print_tutor(16, $wednesday, $tutor_name, $i);?></td>
            <td width="75" bgcolor="white"><?php if($j) print_title(16, $t_thursday, $title_name, $j);print_tutor(16, $thursday, $tutor_name, $i);?></td>
            <td width="75" bgcolor="white"><?php if($j) print_title(16, $t_friday, $title_name, $j);print_tutor(16, $friday, $tutor_name, $i);?></td>
          </tr>
          <tr bgcolor="white" class="content">
            <td bgcolor="#FFDEC8"><div align="center">16:00~17:00</div></td>
            <td width="75" bgcolor="#FFECCE"><?php if($j) print_title(8, $t_monday, $title_name, $j);print_tutor(8, $monday, $tutor_name, $i);?></td>
            <td width="75" bgcolor="#FFECCE"><?php if($j) print_title(8, $t_tuesday, $title_name, $j);print_tutor(8, $tuesday, $tutor_name, $i);?></td>
            <td width="75" bgcolor="#FFECCE"><?php if($j) print_title(8, $t_wednesday, $title_name, $j);print_tutor(8, $wednesday, $tutor_name, $i);?></td>
            <td width="75" bgcolor="#FFECCE"><?php if($j) print_title(8, $t_thursday, $title_name, $j);print_tutor(8, $thursday, $tutor_name, $i);?></td>
            <td width="75" bgcolor="#FFECCE"><?php if($j) print_title(8, $t_friday, $title_name, $j);print_tutor(8, $friday, $tutor_name, $i);?></td>
          </tr>
          <tr bgcolor="white" class="content">
            <td bgcolor="#FFDEC8"><div align="center">17:00~18:00</div></td>
            <td width="75" bgcolor="white"><?php if($j) print_title(4, $t_monday, $title_name, $j);print_tutor(4, $monday, $tutor_name, $i);?></td>
            <td width="75" bgcolor="white"><?php if($j) print_title(4, $t_tuesday, $title_name, $j);print_tutor(4, $tuesday, $tutor_name, $i);?></td>
            <td width="75" bgcolor="white"><?php if($j) print_title(4, $t_wednesday, $title_name, $j);print_tutor(4, $wednesday, $tutor_name, $i);?></td>
            <td width="75" bgcolor="white"><?php if($j) print_title(4, $t_thursday, $title_name, $j);print_tutor(4, $thursday, $tutor_name, $i);?></td>
            <td width="75" bgcolor="white"><?php if($j) print_title(4, $t_friday, $title_name, $j);print_tutor(4, $friday, $tutor_name, $i);?></td>
          </tr>
          <tr bgcolor="white" class="content">
            <td bgcolor="#FFDEC8"><div align="center">18:00~19:00</div></td>
            <td width="75" bgcolor="#FFECCE"><?php if($j) print_title(2, $t_monday, $title_name, $j);print_tutor(2, $monday, $tutor_name, $i);?></td>
            <td width="75" bgcolor="#FFECCE"><?php if($j) print_title(2, $t_tuesday, $title_name, $j);print_tutor(2, $tuesday, $tutor_name, $i);?></td>
            <td width="75" bgcolor="#FFECCE"><?php if($j) print_title(2, $t_wednesday, $title_name, $j);print_tutor(2, $wednesday, $tutor_name, $i);?></td>
            <td width="75" bgcolor="#FFECCE"><?php if($j) print_title(2, $t_thursday, $title_name, $j);print_tutor(2, $thursday, $tutor_name, $i);?></td>
            <td width="75" bgcolor="#FFECCE"><?php if($j) print_title(2, $t_friday, $title_name, $j);print_tutor(2, $friday, $tutor_name, $i);?></td>
          </tr>
          <tr bgcolor="white" class="content">
            <td bgcolor="#FFDEC8"><div align="center">19:00~20:00</div></td>
            <td width="75" bgcolor="white"><?php if($j) print_title(1, $t_monday, $title_name, $j);print_tutor(1, $monday, $tutor_name, $i);?></td>
            <td width="75" bgcolor="white"><?php if($j) print_title(1, $t_tuesday, $title_name, $j);print_tutor(1, $tuesday, $tutor_name, $i);?></td>
            <td width="75" bgcolor="white"><?php if($j) print_title(1, $t_wednesday, $title_name, $j);print_tutor(1, $wednesday, $tutor_name, $i);?></td>
            <td width="75" bgcolor="white"><?php if($j) print_title(1, $t_thursday, $title_name, $j);print_tutor(1, $thursday, $tutor_name, $i);?></td>
            <td width="75" bgcolor="white"><?php if($j) print_title(1, $t_friday, $title_name, $j);print_tutor(1, $friday, $tutor_name, $i);?></td>
          </tr>
        </table>        <p>&nbsp;</p>
        <p class="c1">．英語諮詢服務時段一覽表<br>
        　自學中心(圖資大樓)</p>
        
      <table width="500" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#FF6600">
        <tr bgcolor="#FFA86F" class="content"> 
          <td colspan="6"><div align="center" class="title">The Schedule of library 
              [<a href="book.php?room=lib" target="_blank">預約(Booking)</a>]</div></td>
        </tr>
        <tr bgcolor="#FFDEC8" class="content"> 
          <td bgcolor="#FFDEC8"><div align="center">Time</div></td>
          <td width="75"><div align="center">Monday</div></td>
          <td width="75" bgcolor="#FFDEC8"><div align="center">Tuesday</div></td>
          <td width="75" bgcolor="#FFDEC8"><div align="center">Wednesday</div></td>
          <td width="75" bgcolor="#FFDEC8"><div align="center">Thursday</div></td>
          <td width="75" bgcolor="#FFDEC8"><div align="center">Friday</div></td>
        </tr>
        <?php
}

// Select the schedule from Library
$sql = "Select * From schedule_lib";
$result = mysql_query($sql, $conn) or die(mysql_error());
$i = 0;
while( $row = mysql_fetch_array($result) )
{
	$tutor_name_lib[$i] = $row['tutor_name'];
	$monday_lib[$i] = $row['monday'];
	$tuesday_lib[$i] = $row['tuesday'];
	$wednesday_lib[$i] = $row['wednesday'];
	$thursday_lib[$i] = $row['thursday'];
	$friday_lib[$i] = $row['friday'];
	$i++;
}
if($i)
{
	$sql = "Select * From class_title Where location='LIB'";
	$result = mysql_query($sql, $conn) or die(mysql_error());
	$j = 0;
	while( $row = mysql_fetch_array($result) )
	{
		$title_name[$j] = $row['title_name'];
		$t_monday[$j] = $row['monday'];
		$t_tuesday[$j] = $row['tuesday'];
		$t_wednesday[$j] = $row['wednesday'];
		$t_thursday[$j] = $row['thursday'];
		$t_friday[$j] = $row['friday'];
		$j++;
	}
?>
        <tr bgcolor="white" class="content"> 
          <td bgcolor="#FFDEC8"><div align="center">9:00~10:00</div></td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(1024, $t_monday, $title_name, $j);print_tutor(1024, $monday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(1024, $t_tuesday, $title_name, $j);print_tutor(1024, $tuesday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(1024, $t_wednesday, $title_name, $j);print_tutor(1024, $wednesday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(1024, $t_thursday, $title_name, $j);print_tutor(1024, $thursday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(1024, $t_friday, $title_name, $j);print_tutor(1024, $friday_lib, $tutor_name_lib, $i);?>
          </td>
        </tr>
        <tr bgcolor="white" class="content"> 
          <td bgcolor="#FFDEC8"><div align="center">10:00~11:00</div></td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(512, $t_monday, $title_name, $j);print_tutor(512, $monday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(512, $t_tuesday, $title_name, $j);print_tutor(512, $tuesday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(512, $t_wednesday, $title_name, $j);print_tutor(512, $wednesday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(512, $t_thursday, $title_name, $j);print_tutor(512, $thursday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(512, $t_friday, $title_name, $j);print_tutor(512, $friday_lib, $tutor_name_lib, $i);?>
          </td>
        </tr>
        <tr bgcolor="white" class="content"> 
          <td bgcolor="#FFDEC8"><div align="center">11:00~12:00</div></td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(256, $t_monday, $title_name, $j);print_tutor(256, $monday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(256, $t_tuesday, $title_name, $j);print_tutor(256, $tuesday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(256, $t_wednesday, $title_name, $j);print_tutor(256, $wednesday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(256, $t_thursday, $title_name, $j);print_tutor(256, $thursday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(256, $t_friday, $title_name, $j);print_tutor(256, $friday_lib, $tutor_name_lib, $i);?>
          </td>
        </tr>
        <tr bgcolor="white" class="content"> 
          <td bgcolor="#FFDEC8"><div align="center">12:00~13:00</div></td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(128, $t_monday, $title_name, $j);print_tutor(128, $monday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(128, $t_tuesday, $title_name, $j);print_tutor(128, $tuesday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(128, $t_wednesday, $title_name, $j);print_tutor(128, $wednesday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(128, $t_thursday, $title_name, $j);print_tutor(128, $thursday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(128, $t_friday, $title_name, $j);print_tutor(128, $friday_lib, $tutor_name_lib, $i);?>
          </td>
        </tr>
        <tr bgcolor="white" class="content"> 
          <td bgcolor="#FFDEC8"><div align="center">13:00~14:00</div></td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(64, $t_monday, $title_name, $j);print_tutor(64, $monday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(64, $t_tuesday, $title_name, $j);print_tutor(64, $tuesday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(64, $t_wednesday, $title_name, $j);print_tutor(64, $wednesday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(64, $t_thursday, $title_name, $j);print_tutor(64, $thursday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(64, $t_friday, $title_name, $j);print_tutor(64, $friday_lib, $tutor_name_lib, $i);?>
          </td>
        </tr>
        <tr bgcolor="white" class="content"> 
          <td bgcolor="#FFDEC8"><div align="center">14:00~15:00</div></td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(32, $t_monday, $title_name, $j);print_tutor(32, $monday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(32, $t_tuesday, $title_name, $j);print_tutor(32, $tuesday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(32, $t_wednesday, $title_name, $j);print_tutor(32, $wednesday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(32, $t_thursday, $title_name, $j);print_tutor(32, $thursday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(32, $t_friday, $title_name, $j);print_tutor(32, $friday_lib, $tutor_name_lib, $i);?>
          </td>
        </tr>
        <tr bgcolor="white" class="content"> 
          <td bgcolor="#FFDEC8"><div align="center">15:00~16:00</div></td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(16, $t_monday, $title_name, $j);print_tutor(16, $monday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(16, $t_tuesday, $title_name, $j);print_tutor(16, $tuesday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(16, $t_wednesday, $title_name, $j);print_tutor(16, $wednesday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(16, $t_thursday, $title_name, $j);print_tutor(16, $thursday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(16, $t_friday, $title_name, $j);print_tutor(16, $friday_lib, $tutor_name_lib, $i);?>
          </td>
        </tr>
        <tr bgcolor="white" class="content"> 
          <td bgcolor="#FFDEC8"><div align="center">16:00~17:00</div></td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(8, $t_monday, $title_name, $j);print_tutor(8, $monday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(8, $t_tuesday, $title_name, $j);print_tutor(8, $tuesday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(8, $t_wednesday, $title_name, $j);print_tutor(8, $wednesday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(8, $t_thursday, $title_name, $j);print_tutor(8, $thursday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(8, $t_friday, $title_name, $j);print_tutor(8, $friday_lib, $tutor_name_lib, $i);?>
          </td>
        </tr>
        <tr bgcolor="white" class="content"> 
          <td colspan="6" bgcolor="#FFDEC8"><div align="center"><strong>break</strong></div></td>
        </tr>
        <tr bgcolor="white" class="content"> 
          <td bgcolor="#FFDEC8"><div align="center">19:00~20:00</div></td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(4, $t_monday, $title_name, $j);print_tutor(4, $monday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(4, $t_tuesday, $title_name, $j);print_tutor(4, $tuesday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(4, $t_wednesday, $title_name, $j);print_tutor(4, $wednesday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(4, $t_thursday, $title_name, $j);print_tutor(4, $thursday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(4, $t_friday, $title_name, $j);print_tutor(4, $friday_lib, $tutor_name_lib, $i);?>
          </td>
        </tr>
        <tr bgcolor="white" class="content"> 
          <td bgcolor="#FFDEC8"><div align="center">20:00~21:00</div></td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(2, $t_monday, $title_name, $j);print_tutor(2, $monday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(2, $t_tuesday, $title_name, $j);print_tutor(2, $tuesday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(2, $t_wednesday, $title_name, $j);print_tutor(2, $wednesday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(2, $t_thursday, $title_name, $j);print_tutor(2, $thursday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="#FFECCE" align="center"> 
            <?php if($j) print_title(2, $t_friday, $title_name, $j);print_tutor(2, $friday_lib, $tutor_name_lib, $i);?>
          </td>
        </tr>
        <tr bgcolor="white" class="content"> 
          <td bgcolor="#FFDEC8"><div align="center">21:00~22:00</div></td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(1, $t_monday, $title_name, $j);print_tutor(1, $monday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(1, $t_tuesday, $title_name, $j);print_tutor(1, $tuesday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(1, $t_wednesday, $title_name, $j);print_tutor(1, $wednesday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(1, $t_thursday, $title_name, $j);print_tutor(1, $thursday_lib, $tutor_name_lib, $i);?>
          </td>
          <td width="75" bgcolor="white" align="center"> 
            <?php if($j) print_title(1, $t_friday, $title_name, $j);print_tutor(1, $friday_lib, $tutor_name_lib, $i);?>
          </td>
        </tr>
      </table>
      <p class="c1">&nbsp;</p></td>
  </tr>
</table>
<div align="center">

  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
</body>
</html>

<?php
}
} // login check
mysql_close($conn);


// This function is used to print the tutor's name. It has four variables.
// $index indicates that what the exponent is now.
// $day indicates that what day is now.
// $name indicates that tutors' name.
// $num indicats the number of all tutors.
function print_tutor($index, &$day, $name, $num)
{
	$color = array('blue', 'green', 'red', 'orange', 'purple');

	for( $i=0; $i<$num; $i++ )
	{
		if( $day[$i] >= $index )
		{
			echo "<font color=" . $color[$i] . ">" . $name[$i] . "</font><br>";
			$day[$i] -= $index;
		}
	}
}

function print_title($index, &$day, $name, $num)
{
	for( $i=0; $i<$num; $i++ )
	{
		if( $day[$i] >= $index )
		{
			echo "<font color=#999933>" . $name[$i] . "</font><br>";
			$day[$i] -= $index;
		}
	}
}
?>