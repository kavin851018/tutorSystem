<?php
$target = "show_booking.php";
include 'check_login.php';

if( $valid )
{

$tutor = $_GET['tutor'];
$location = $_GET['location'];
include '../../connect_db.php';
if($location == "DELL")
	$sql = "Select * From schedule Where tutor_name='$tutor'";
else if($location == "LIB")
	$sql = "Select * From schedule_lib Where tutor_name='$tutor'";
else if($location == "NIGHT")
	$sql = "Select * From schedule_night Where tutor_name='$tutor'";	
$row = mysql_fetch_array(mysql_query($sql, $conn));
$monday =$row['monday'];
$tuesday = $row['tuesday'];
$wednesday = $row['wednesday'];
$thursday = $row['thursday'];
$friday = $row['friday'];
$email = $row['email'];
$class = $row['class'];
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=big5">
<title>無標題文件</title>
<style type="text/css">
<!--
.content {font-family:Arial, Helvetica, sans-serif;font-size:13px;color:black}
.title {font-family:Arial, Helvetica, sans-serif;font-size:15px;color:white}
-->
</style>
</head>

<body>
<form action="modify_schedule2.php" method="post" enctype="application/x-www-form-urlencoded" name="form1">

<table width="500" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#FF6600">
  <tr bgcolor="#FFA86F" class="title">
    <td colspan="6" align="center"><?php echo $tutor . "'s schedule"; ?></td>
  </tr>
  <tr bgcolor="#FFDEC8" class="content">
    <td colspan="6" align="center" bgcolor="#FFDEC8"><?php echo $tutor . "'s email:"; ?>
    <input name="email" type="text" id="email" value="<?echo $email;?>">
	Class: <select name="class" id="class">
<?php
$sql = "Select title_name, id From class_title Where location='$location'";
$result = mysql_query($sql, $conn) or die(mysql_error());
$i = 0;
while( $row = mysql_fetch_array($result) )
{
	echo "<option value=\"" . $row['id'] . "\"";
	if( $row['id'] == $class ) echo " selected";
	echo ">" . $row['title_name'] . "</option>";
	$i++;
}
?>
	</select>
	</td></tr>
  <tr bgcolor="#FFDEC8" class="content">
    <td bgcolor="#FFDEC8" align="center">Time</td>
    <td width="75" align="center">Monday</td>
    <td width="75" bgcolor="#FFDEC8" align="center">Tuesday</td>
    <td width="75" bgcolor="#FFDEC8" align="center">Wednesday</td>
    <td width="75" bgcolor="#FFDEC8" align="center">Thursday</td>
    <td width="75" bgcolor="#FFDEC8" align="center">Friday</td>
  </tr>
  <tr bgcolor="white">
    <td bgcolor="#FFDEC8" class="content"><div align="center">9:00~10:00</div></td>
    <td width="75" bgcolor=<?php checked_color(2048,$monday,"white");?>><div align="center">
        <input name="monday1" type="checkbox" id="monday1" value="2048"<?php checked(2048,$monday);?>>
    </div></td>
    <td width="75" bgcolor=<?php checked_color(2048,$tuesday,"white");?>><div align="center">
        <input name="tuesday1" type="checkbox" id="tuesday1" value="2048"<?php checked(2048,$tuesday);?>>
    </div></td>
    <td width="75" bgcolor=<?php checked_color(2048,$wednesday,"white");?>><div align="center">
        <input name="wednesday1" type="checkbox" id="wednesday1" value="2048"<?php checked(2048,$wednesday);?>>
    </div></td>
    <td width="75" bgcolor=<?php checked_color(2048,$thursday,"white");?>><div align="center">
        <input name="thursday1" type="checkbox" id="thursday1" value="2048"<?php checked(2048,$thursday);?>>
    </div></td>
    <td width="75" bgcolor=<?php checked_color(2048,$friday,"white");?>><div align="center">
        <input name="friday1" type="checkbox" id="friday1" value="2048"<?php checked(2048,$friday);?>>
    </div></td>
  </tr>
  <tr bgcolor="white">
    <td bgcolor="#FFDEC8" class="content"><div align="center">10:00~11:00</div></td>
    <td width="75" bgcolor=<?php checked_color(1024,$monday,"#FFECCE");?>><div align="center">
        <input name="monday2" type="checkbox" id="monday2" value="1024"<?php checked(1024,$monday);?>>
    </div></td>
    <td width="75" bgcolor=<?php checked_color(1024,$tuesday,"#FFECCE");?>><div align="center">
        <input name="tuesday2" type="checkbox" id="tuesday2" value="1024"<?php checked(1024,$tuesday);?>>
    </div></td>
    <td width="75" bgcolor=<?php checked_color(1024,$wednesday,"#FFECCE");?>><div align="center">
        <input name="wednesday2" type="checkbox" id="wednesday2" value="1024"<?php checked(1024,$wednesday);?>>
    </div></td>
    <td width="75" bgcolor=<?php checked_color(1024,$thursday,"#FFECCE");?>><div align="center">
        <input name="thursday2" type="checkbox" id="thursday2" value="1024"<?php checked(1024,$thursday);?>>
    </div></td>
    <td width="75" bgcolor=<?php checked_color(1024,$friday,"#FFECCE");?>><div align="center">
        <input name="friday2" type="checkbox" id="friday2" value="1024"<?php checked(1024,$friday);?>>
    </div></td>
  </tr>
  <tr bgcolor="white">
    <td bgcolor="#FFDEC8" class="content"><div align="center">11:00~12:00</div></td>
    <td width="75" bgcolor=<?php checked_color(512,$monday,"white");?>><div align="center">
        <input name="monday3" type="checkbox" id="monday3" value="512"<?php checked(512,$monday);?>>
    </div></td>
    <td width="75" bgcolor=<?php checked_color(512,$tuesday,"white");?>><div align="center">
        <input name="tuesday3" type="checkbox" id="tuesday3" value="512"<?php checked(512,$tuesday);?>>
    </div></td>
    <td width="75" bgcolor=<?php checked_color(512,$wednesday,"white");?>><div align="center">
        <input name="wednesday3" type="checkbox" id="wednesday3" value="512"<?php checked(512,$wednesday);?>>
    </div></td>
    <td width="75" bgcolor=<?php checked_color(512,$thursday,"white");?>><div align="center">
        <input name="thursday3" type="checkbox" id="thursday3" value="512"<?php checked(512,$thursday);?>>
    </div></td>
    <td width="75" bgcolor=<?php checked_color(512,$friday,"white");?>><div align="center">
        <input name="friday3" type="checkbox" id="friday3" value="512"<?php checked(512,$friday);?>>
    </div></td>
  </tr>
  <tr bgcolor="white">
    <td bgcolor="#FFDEC8" class="content"><div align="center">12:00~13:00</div></td>
    <td width="75" bgcolor=<?php checked_color(256,$monday,"#FFECCE");?>><div align="center">
        <input name="monday4" type="checkbox" id="monday4" value="256"<?php checked(256,$monday);?>>
    </div></td>
    <td width="75" bgcolor=<?php checked_color(256,$tuesday,"#FFECCE");?>><div align="center">
        <input name="tuesday4" type="checkbox" id="tuesday4" value="256"<?php checked(256,$tuesday);?>>
    </div></td>
    <td width="75" bgcolor=<?php checked_color(256,$wednesday,"#FFECCE");?>><div align="center">
        <input name="wednesday4" type="checkbox" id="wednesday4" value="256"<?php checked(256,$wednesday);?>>
    </div></td>
    <td width="75" bgcolor=<?php checked_color(256,$thursday,"#FFECCE");?>><div align="center">
        <input name="thursday4" type="checkbox" id="thursday4" value="256"<?php checked(256,$thursday);?>>
    </div></td>
    <td width="75" bgcolor=<?php checked_color(256,$friday,"#FFECCE");?>><div align="center">
        <input name="friday4" type="checkbox" id="friday4" value="256"<?php checked(256,$friday);?>>
    </div></td>
  </tr>
  <tr bgcolor="white">
    <td bgcolor="#FFDEC8" class="content"><div align="center">13:00~14:00</div></td>
    <td width="75" bgcolor=<?php checked_color(128,$monday,"white");?>><div align="center">
        <input name="monday5" type="checkbox" id="monday5" value="128"<?php checked(128,$monday);?>>
    </div></td>
    <td width="75" bgcolor=<?php checked_color(128,$tuesday,"white");?>><div align="center">
        <input name="tuesday5" type="checkbox" id="tuesday5" value="128"<?php checked(128,$tuesday);?>>
    </div></td>
    <td width="75" bgcolor=<?php checked_color(128,$wednesday,"white");?>><div align="center">
        <input name="wednesday5" type="checkbox" id="wednesday5" value="128"<?php checked(128,$wednesday);?>>
    </div></td>
    <td width="75" bgcolor=<?php checked_color(128,$thursday,"white");?>><div align="center">
        <input name="thursday5" type="checkbox" id="thursday5" value="128"<?php checked(128,$thursday);?>>
    </div></td>
    <td width="75" bgcolor=<?php checked_color(128,$friday,"white");?>><div align="center">
        <input name="friday5" type="checkbox" id="friday5" value="128"<?php checked(128,$friday);?>>
    </div></td>
  </tr>
  <tr bgcolor="white">
    <td bgcolor="#FFDEC8" class="content"><div align="center">14:00~15:00</div></td>
    <td width="75" bgcolor=<?php checked_color(64,$monday,"#FFECCE");?>><div align="center">
        <input name="monday6" type="checkbox" id="monday6" value="64"<?php checked(64,$monday);?>>
    </div></td>
    <td width="75" bgcolor=<?php checked_color(64,$tuesday,"#FFECCE");?>><div align="center">
        <input name="tuesday6" type="checkbox" id="tuesday6" value="64"<?php checked(64,$tuesday);?>>
    </div></td>
    <td width="75" bgcolor=<?php checked_color(64,$wednesday,"#FFECCE");?>><div align="center">
        <input name="wednesday6" type="checkbox" id="wednesday6" value="64"<?php checked(64,$wednesday);?>>
    </div></td>
    <td width="75" bgcolor=<?php checked_color(64,$thursday,"#FFECCE");?>><div align="center">
        <input name="thursday6" type="checkbox" id="thursday6" value="64"<?php checked(64,$thursday);?>>
    </div></td>
    <td width="75" bgcolor=<?php checked_color(64,$friday,"#FFECCE");?>><div align="center">
        <input name="friday6" type="checkbox" id="friday6" value="64"<?php checked(64,$friday);?>>
    </div></td>
  </tr>
  <tr bgcolor="white">
    <td bgcolor="#FFDEC8" class="content"><div align="center">15:00~16:00</div></td>
    <td width="75" bgcolor=<?php checked_color(32,$monday,"white");?>><div align="center">
        <input name="monday7" type="checkbox" id="monday7" value="32"<?php checked(32,$monday);?>>
    </div></td>
    <td width="75" bgcolor=<?php checked_color(32,$tuesday,"white");?>><div align="center">
        <input name="tuesday7" type="checkbox" id="tuesday7" value="32"<?php checked(32,$tuesday);?>>
    </div></td>
    <td width="75" bgcolor=<?php checked_color(32,$wednesday,"white");?>><div align="center">
        <input name="wednesday7" type="checkbox" id="wednesday7" value="32"<?php checked(32,$wednesday);?>>
    </div></td>
    <td width="75" bgcolor=<?php checked_color(32,$thursday,"white");?>><div align="center">
        <input name="thursday7" type="checkbox" id="thursday7" value="32"<?php checked(32,$thursday);?>>
    </div></td>
    <td width="75" bgcolor=<?php checked_color(32,$friday,"white");?>><div align="center">
        <input name="friday7" type="checkbox" id="friday7" value="32"<?php checked(32,$friday);?>>
    </div></td>
  </tr>
  <tr bgcolor="white">
    <td bgcolor="#FFDEC8" class="content"><div align="center">16:00~17:00</div></td>
    <td width="75" bgcolor=<?php checked_color(16,$monday,"#FFECCE");?>><div align="center">
        <input name="monday8" type="checkbox" id="monday8" value="16"<?php checked(16,$monday);?>>
    </div></td>
    <td width="75" bgcolor=<?php checked_color(16,$tuesday,"#FFECCE");?>><div align="center">
        <input name="tuesday8" type="checkbox" id="tuesday8" value="16"<?php checked(16,$tuesday);?>>
    </div></td>
    <td width="75" bgcolor=<?php checked_color(16,$wednesday,"#FFECCE");?>><div align="center">
        <input name="wednesday8" type="checkbox" id="wednesday8" value="16"<?php checked(16,$wednesday);?>>
    </div></td>
    <td width="75" bgcolor=<?php checked_color(16,$thursday,"#FFECCE");?>><div align="center">
        <input name="thursday8" type="checkbox" id="thursday8" value="16"<?php checked(16,$thursday);?>>
    </div></td>
    <td width="75" bgcolor=<?php checked_color(16,$friday,"#FFECCE");?>><div align="center">
        <input name="friday8" type="checkbox" id="friday8" value="16"<?php checked(16,$friday);?>>
    </div></td>
  </tr>
  <tr bgcolor="white">
    <td bgcolor="#FFDEC8" class="content"><div align="center">17:00~18:00</div></td>
    <td width="75" bgcolor=<?php checked_color(8,$monday,"white");?>><div align="center">
        <input name="monday9" type="checkbox" id="monday9" value="8"<?php checked(8,$monday);?>>
    </div></td>
    <td width="75" bgcolor=<?php checked_color(8,$tuesday,"white");?>><div align="center">
        <input name="tuesday9" type="checkbox" id="tuesday9" value="8"<?php checked(8,$tuesday);?>>
    </div></td>
    <td width="75" bgcolor=<?php checked_color(8,$wednesday,"white");?>><div align="center">
        <input name="wednesday9" type="checkbox" id="wednesday9" value="8"<?php checked(8,$wednesday);?>>
    </div></td>
    <td width="75" bgcolor=<?php checked_color(8,$thursday,"white");?>><div align="center">
        <input name="thursday9" type="checkbox" id="thursday9" value="8"<?php checked(8,$thursday);?>>
    </div></td>
    <td width="75" bgcolor=<?php checked_color(8,$friday,"white");?>><div align="center">
        <input name="friday9" type="checkbox" id="friday9" value="8"<?php checked(8,$friday);?>>
    </div></td>
  </tr>
  <tr bgcolor="white">
    <td bgcolor="#FFDEC8" class="content"><div align="center">18:00~19:00</div></td>
    <td width="75" bgcolor=<?php checked_color(4,$monday,"#FFECCE");?>><div align="center">
        <input name="monday10" type="checkbox" id="monday10" value="4"<?php checked(4,$monday);?>>
    </div></td>
    <td width="75" bgcolor=<?php checked_color(4,$tuesday,"#FFECCE");?>><div align="center">
        <input name="tuesday10" type="checkbox" id="tuesday10" value="4"<?php checked(4,$tuesday);?>>
    </div></td>
    <td width="75" bgcolor=<?php checked_color(4,$wednesday,"#FFECCE");?>><div align="center">
        <input name="wednesday10" type="checkbox" id="wednesday10" value="4"<?php checked(4,$wednesday);?>>
    </div></td>
    <td width="75" bgcolor=<?php checked_color(4,$thursday,"#FFECCE");?>><div align="center">
        <input name="thursday10" type="checkbox" id="thursday10" value="4"<?php checked(4,$thursday);?>>
    </div></td>
    <td width="75" bgcolor=<?php checked_color(4,$friday,"#FFECCE");?>><div align="center">
        <input name="friday10" type="checkbox" id="friday10" value="4"<?php checked(4,$friday);?>>
    </div></td>
  </tr>
  <tr bgcolor="white">
    <td bgcolor="#FFDEC8" class="content"><div align="center">19:00~20:00</div></td>
    <td width="75" bgcolor=<?php checked_color(2,$monday,"white");?>><div align="center">
        <input name="monday11" type="checkbox" id="monday11" value="2"<?php checked(2,$monday);?>>
    </div></td>
    <td width="75" bgcolor=<?php checked_color(2,$tuesday,"white");?>><div align="center">
        <input name="tuesday11" type="checkbox" id="tuesday11" value="2"<?php checked(2,$tuesday);?>>
    </div></td>
    <td width="75" bgcolor=<?php checked_color(2,$wednesday,"white");?>><div align="center">
        <input name="wednesday11" type="checkbox" id="wednesday11" value="2"<?php checked(2,$wednesday);?>>
    </div></td>
    <td width="75" bgcolor=<?php checked_color(2,$thursday,"white");?>><div align="center">
        <input name="thursday11" type="checkbox" id="thursday11" value="2"<?php checked(2,$thursday);?>>
    </div></td>
    <td width="75" bgcolor=<?php checked_color(2,$friday,"white");?>><div align="center">
        <input name="friday11" type="checkbox" id="friday11" value="2"<?php checked(2,$friday);?>>
    </div></td>
  </tr>
  
  <tr bgcolor="white">
    <td bgcolor="#FFDEC8" class="content"><div align="center">20:00~21:00</div></td>
    <td width="75" bgcolor=<?php checked_color(1,$monday,"white");?>><div align="center">
        <input name="monday12" type="checkbox" id="monday11" value="1"<?php checked(1,$monday);?>>
    </div></td>
    <td width="75" bgcolor=<?php checked_color(1,$tuesday,"white");?>><div align="center">
        <input name="tuesday12" type="checkbox" id="tuesday11" value="1"<?php checked(1,$tuesday);?>>
    </div></td>
    <td width="75" bgcolor=<?php checked_color(1,$wednesday,"white");?>><div align="center">
        <input name="wednesday12" type="checkbox" id="wednesday11" value="1"<?php checked(1,$wednesday);?>>
    </div></td>
    <td width="75" bgcolor=<?php checked_color(1,$thursday,"white");?>><div align="center">
        <input name="thursday12" type="checkbox" id="thursday11" value="1"<?php checked(1,$thursday);?>>
    </div></td>
    <td width="75" bgcolor=<?php checked_color(1,$friday,"white");?>><div align="center">
        <input name="friday12" type="checkbox" id="friday11" value="1"<?php checked(1,$friday);?>>
    </div></td>
  </tr>  
  
  
  
  
  
  
  
  
  <tr bgcolor="#FFDEC8">
    <td colspan="6" class="content"><div align="center">
      <input name="location" type="hidden" id="location" value="<?php echo $location; ?>">
      <input name="tutor" type="hidden" id="tutor" value="<?php echo $tutor;?>">
      <input type="submit" name="Submit" value="Modify">

    [<a href="show_management.php">Back</a>]</div></td>
    </tr>
</table>
</form>
</body>
</html>

<?php
mysql_close($conn);

} // login check

function checked($index, &$day)
{
	if( $day >= $index )
	{
		echo " checked";
		$day -= $index;
	}
}

function checked_color($index, &$day, $color)
{
	if( $day >= $index )
	{
		echo "#AEFF93";
	}
	else
	{
		echo $color;
	}
}
?>