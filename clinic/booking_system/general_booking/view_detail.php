<?php
session_start();
$id = $_GET['id'];
include '../../../connect_db.php';
$sql = "Select * From general_booking Where id='$id'";
$row = mysql_fetch_array(mysql_query($sql, $conn));

$deadline = strtotime($row['deadline']);
$now = strtotime(date('Y-m-d'));

$sql = "Select id From general_booked Where booked_id='$id'";
$result = mysql_query($sql, $conn);
$n = mysql_num_rows($result);
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=big5">
<title><?php echo $row['topic'];?></title>
<style type="text/css">
<!--
a:hover{
  left: 1px; 
  position: relative; 
  top: 1px; 
  text-decoration:none;
}
a,a:visited{
  text-decoration:none;
}
.style1 {font-size: 13px; color:#003366}
.style2 {font-size: 13px; color:green}
.style3 {font-size: 16px; color:white; font-weight:bold}
.style4 {font-size: 13px; color:white;}
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
<p>
<?php
echo "<div align=center>" . @$_SESSION['message'] . "</div>";
if( @$_SESSION['message'] != "" )
{
	$_SESSION['message'] = "";
	unset($_SESSION['message']);
}
?>
</p>
<table width="500" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#003366">
  <tr>
    <td class="style3" align="center"><table width="30" border="0" align="right" cellpadding="2" cellspacing="0">
      <tr>
        <td bgcolor="#004899" onMouseMove="MOChangeColor(this,'#027AFF')" onMouseOut="MOutChangeColor(this)"><a href="view_booking.php" class="style4">��^</a></td>
      </tr>
    </table>      <?php echo $row['topic'];?></td>
  </tr>
  <tr>
    <td bgcolor="white"><table width="100%"  border="0" cellpadding="3" cellspacing="1" bgcolor="#990033">
      <tr>
        <td bgcolor="#ECF5FF" class="style1"><span class="style1">�D���H</span></td>
        <td bgcolor="white" class="style2"><?php echo $row['compere'];?></td>
        <td bgcolor="#ECF5FF" class="style1">�a�I</td>
        <td bgcolor="white" class="style2"><?php echo $row['location'];?></td>
        <td bgcolor="#ECF5FF" class="style1">�|��ɶ�</td>
        <td bgcolor="white" class="style2"><?php echo str_replace("-", "/", substr($row['time'],0,16));?></td>
      </tr>
      <tr>
        <td bgcolor="#ECF5FF" class="style1">�I����</td>
        <td bgcolor="white" class="style2"><?php echo str_replace("-", "/", $row['deadline']);?></td>
		<td bgcolor="#ECF5FF" class="style1">�̤j���W��</td>
		<td bgcolor="white" class="style2"><?php echo $row['max_booking'];?></td>
		<td bgcolor="#ECF5FF" class="style1">�w���W�H��</td>
		<td bgcolor="white" class="style2"><?php echo $n;?></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td bgcolor="white" class=style1>Description:<br><br>    <span class=style2><?php echo $row['description'];?> </span><br>
    <br>
    �w���W���H�G<br>
<?php
$sql = "Select * From general_booked Where booked_id='$id'";
$result_booked = mysql_query($sql, $conn) or die(mysql_error());
$i = 1;

echo "<table width=300>";
while( $row_booked = mysql_fetch_array($result_booked))
{
    if($row_booked['name']=='����v'){$row_booked['name']="�\���v";} //big5 encoding problem workaround 20171018
  $name = mb_substr($row_booked['name'],0,1,'big5');

	echo "<tr class=style2><td>";
	echo $i . ". </td>";
	echo "<td>" . $row_booked['dept'] . "</td><td>" . $name . "**</td>";
	$i++;
	echo "</tr>";
}
echo "</table>";
?>
    </td>
  </tr>
  <tr>
    <td bgcolor="white" align=center class="style2"><br>

<?php

if (date(l,strtotime('-3 week',$deadline))=="Monday"){
    $opendate=strtotime('-3 week',$deadline);
}else{

    $opendate=strtotime('-3 week last Monday',$deadline);
}



if($now > $deadline)
  echo "���ʤw�I��";
elseif ($now <  $opendate)
    echo "���ʱN�� ".date('Y-m-d',$opendate)." �}����W";
else if( $n < $row['max_booking'] )
	echo '<a href="user_book.php?id='.$id.'" style="color:blue;">[�ڭn���W]</a>&nbsp;&nbsp;&nbsp;<a href="user_delete.php?id='.$id.'" style="color:red;">[�������W]</a>';
else
	echo '���ʤw�B��<br><a href="user_delete.php?id='.$id.'" style="color:red;">[�������W]</a>';
?>
<br>
	<br></td>
  </tr>
</table>
<p style="text-align:center;">�p�L�k�������W�A��Email: <a href="mailto:onlinelearning@mail.nsysu.edu.tw">onlinelearning@mail.nsysu.edu.tw</a></p>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
