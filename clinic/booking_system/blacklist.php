<?php
$target = "login.htm";
include '../../check_login.php';
if($n != 0 )
{
include '../../connect_db.php';
?>

<html>
<head>
<style type="text/css">
<!--
.title{font-family:Arial, Helvetica, sans-serif; font-size:15px;color:#666}
.content{font-family:Arial, Helvetica, sans-serif;font-size:13px;color:black}
.red{font-family:Arial, Helvetica, sans-serif;font-size:13px;color:red; font-weight:bold}
-->
</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>The Booking Blacklist</title>
<style type="text/css">
<!--
A:hover {LEFT: 1px; POSITION: relative; TOP: 1px; text-decoration:none}
A{text-decoration:none}
.style1 {color: white; font-family:Arial, Helvetica, sans-serif; font-size:13px}
.style2 {color: white; font-family:Arial, Helvetica, sans-serif; font-size:24px}
.style3 {color: #006699; font-family:Arial, Helvetica, sans-serif; font-size:13px}
.style_category {color: #006699; font-family:Arial, Helvetica, sans-serif; font-size:13px}
.style_category_title {color: white; font-family:Arial, Helvetica, sans-serif; font-size:13px}
.style4 {font-family: Arial, Helvetica, sans-serif; font-size: 13px;}
-->
</style>

<script language="JavaScript" type="text/JavaScript">

function initial()
{
<?php
if( isset($_SESSION['message']) && $_SESSION['message'] != "" )
{
	$mes = str_replace("<br>", "\\n", $_SESSION['message']);
	echo "alert(\"" . $mes . "\")";
	unset($_SESSION['message']);
}
?>
}

function MOChangeColor(obj, color)
{
	obj.style.backgroundColor = color;
}

function MOutChangeColor(obj)
{
	obj.style.backgroundColor = "";
}

</script>
</head>

<body onLoad="initial();">

<table width="400" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">
  <tr bgcolor="#666">
    <td colspan="3" align=center class=style2><br>
      Blacklist<br>
    <br></td>
  </tr>
  <tr bgcolor="#666">
    <td class="style1" align=center>ID</td>
    <td class="style1" align=center>Time</td>
    <td class="style1" align=center>&nbsp;</td>
  </tr>
	<form action="add_blacklist.php" method="post" enctype="multipart/form-data" name="form1">
		<tr bgcolor="#FFF" class="style3">
			<td align=center><input name="id" type="text" id="id" size="8" maxlength="16"></td>
			<td class=\"style3\" align=center>
				<input name="start" type="text" id="start" size="8" maxlength="10">~
				<input name="end" type="text" id="end" size="8" maxlength="10"><br />
			</td>
			<td align=center><input type="submit" name="Submit2" value="Add / Modify"></td>
		</tr>
	</form>
<?php

  $_SESSION['back'] = "blacklist.php";

  $sql = "Select * From booking_blacklist Order By starttime DESC";
  $result = mysql_query($sql, $conn) or die(mysql_error());
  $n = mysql_num_rows($result);
	if( $n ) {
	  while( $row = mysql_fetch_array($result) ) {
	  
	  $start = date("Y/m/d", strtotime($row['starttime']));
	  $end = date("Y/m/d", strtotime($row['endtime']));
	  
    echo "<tr bgcolor=white onmousemove=\"MOChangeColor(this,'#FFFFCC')\" onmouseout=\"MOutChangeColor(this)\">";
    echo "  <td class=\"style3\" align=center>" . $row['student_id'] . "</td>";
    echo "  <td class=\"style3\" align=center>" . $start . " ~ " . $end . "</td>";
    echo "  <td class=\"style3\" align=center>";
    echo "    <a href=delete_blacklist.php?id=" .$row['student_id'] . "><img src=images/delete.png border=0 alt=\"Delete it from blacklist\"></a>";
    echo "  </td>";
    echo "  </td>";
    echo "</tr>";
    
    }
  }

?>
  
</table>

<br />
<center>[<a href="show_management.php" class="title">Back</a>]</center>

</body>
</html>
<?php
}
?>