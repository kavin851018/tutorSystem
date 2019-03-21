<?php
$target = "../login.htm";
include '../../../check_login.php';
include '../../../connect_db.php';

$id = $_GET['id'];
// Select 'topic' column from table 'general_booking'.
$sql = "Select topic From general_booking Where id='$id'";
$row = mysql_fetch_array( mysql_query($sql, $conn));
$topic = $row['topic'];

$sql =  "Select * From general_booked Where booked_id='$id'";
$result = mysql_query($sql, $conn) or die(mysql_error());
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=big5">
<title>Show the booked persons</title>

<style type="text/css">
<!--
A:hover {LEFT: 1px; POSITION: relative; TOP: 1px; text-decoration:none}
A{text-decoration:none}
.style1{ font-size:16px; color:white; font-weight:bold;}
.style2{font-size:13px;color:#003366;}
.style3{font-size:13px;color:green;}
.style4{font-size:13px;color:white;}
-->
</style>

<script language="JavaScript" type="text/JavaScript">

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

<body>
<p>&nbsp;</p>
<table width="600" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#003366">
  <tr>
    <td colspan="5" align=center class="style1">
		<table width="40" border="0" align="right" cellpadding="3" cellspacing="0">
	      <tr align="center">
	        <td bgcolor="#00428A" onmousemove="MOChangeColor(this,'#005ABD')" onmouseout="MOutChangeColor(this)"><a href="show_general_booking.php" class="style4">返回</a></td>
	      </tr>
    </table>
    『<?php echo $topic;?>』中已預約的人</td>
  </tr>
  <tr class="style2" align="center" bgcolor="#B0D6FF">
    <td>姓名</td>
    <td>系級</td>
    <td>電話</td>
    <td>email</td>
    <td>&nbsp;</td>
  </tr>

<?php
while( $row = mysql_fetch_array($result) )
{
	echo "<tr bgcolor=white align=center class=style3>";
	echo "<td>" . $row['name'] . "</td>";
	echo "<td>" . $row['dept'] . "</td>";
	echo "<td>" . $row['phone'] . "</td>";
	echo "<td>" . $row['email'] . "</td>";
	echo "<td><a href=delete_booked_person.php?id=" . $row['id'] . "&bid=" . $id . ">DEL</a></td>";
	echo "</tr>";
}
?>

</table>
</body>
</html>

<?php
	mysql_close($conn);
?>