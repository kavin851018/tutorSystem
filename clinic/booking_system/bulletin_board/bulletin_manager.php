<?php
$target="../login.php";
include '../../../check_login.php';
include '../../../connect_db.php';
?>
 <p>&nbsp;</p>
<font color=blue size=2><p align="center">[<a href="add_subject1.php">Add a Subject</a>][<a href="../show_management.php">Back</a>]</p></font>
<form name="form1" method="post" action="modify_puttop.php">
<input name="classify" type="hidden" value="�t�W�ǳN����">
<table width="700" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#666600">
  <tr bgcolor="#666600"> 
    <td colspan="5"><font color="white" size="3"><strong>�t�W�ǳN����</strong></font></td>
  </tr>
  <tr bgcolor="#FFFFA4"> 
    <td><font color="#000099" size="2">No</font></td>
    <td><font color="#000099" size="2">���D</font></td>
    <td><font color="#000099" size="2">���i���</font></td>
    <td><font color="#000099" size="2">���ɼ�</font></td>
    <td><font color="#000099" size="2">�m��</font></td>
    <td><font color="#000099" size="2">�R��</font></td>
  </tr>
<?php
$sql = "Select * From bulletin_board Where classify='�t�W�ǳN����' Order By bulletin_id DESC";
$result = mysql_query($sql, $conn) or die(mysql_error());
$i = 1;
while( $row = mysql_fetch_array($result) )
{
	$sql = "Select * From bulletin_files Where bulletin_id='" . $row['bulletin_id'] . "'";
	$n = mysql_num_rows(mysql_query($sql, $conn));
	echo "<tr bgcolor=white>";
	echo "<td align=center><font size=2 color=green>" . $i . "</font></td>";
	echo "<td><a href=modify_subject1.php?bid=" . $row['bulletin_id'];
	echo "><font size=2 color=green>" . $row['bulletin_title'] . "</font></a></td>";
	echo "<td><font size=2 color=green>" . $row['publish_date'] . "</font></td>";
	echo "<td><font size=2 color=green>" . $n . "</font></td>";
	if( $row['puttop'] )
		echo "<td><input type=checkbox name=checkbox_" . $row['bulletin_id'] . " value=1 checked></td>";
	else
		echo "<td><input type=checkbox name=checkbox_" . $row['bulletin_id'] . " value=0></td>";
		
	echo "<td><a href=delete_subject.php?bid=" . $row['bulletin_id'] . "><font size=2 color=red>DEL</font></a></td>";
	echo "</tr>";
	$i++;
}
?>
<tr bgcolor=white align=center><td colspan=6><input type="submit" name="Submit" value="�ק�m��"></td></tr>
</table>
</form>

<p align="center">&nbsp;</p>
<form name="form2" method="post" action="modify_puttop.php">
<input name="classify" type="hidden" value="�t�W�@�뤽�i">
<table width="700" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#666600">
  <tr bgcolor="#666600"> 
    <td colspan="5"><font color="white" size="3"><strong>�t�W�@�묡�ʤ��i</strong></font></td>
  </tr>
  <tr bgcolor="#FFFFA4"> 
    <td><font color="#000099" size="2">No</font></td>
    <td><font color="#000099" size="2">���D</font></td>
    <td><font color="#000099" size="2">���i���</font></td>
    <td><font color="#000099" size="2">���ɼ�</font></td>
    <td><font color="#000099" size="2">�m��</font></td>
    <td><font color="#000099" size="2">�R��</font></td>
  </tr>
<?php
$sql = "Select * From bulletin_board Where classify='�t�W�@�뤽�i' Order By bulletin_id DESC";
$result = mysql_query($sql, $conn) or die(mysql_error());
$i = 1;
while( $row = mysql_fetch_array($result) )
{
	$sql = "Select * From bulletin_files Where bulletin_id='" . $row['bulletin_id'] . "'";
	$n = mysql_num_rows(mysql_query($sql, $conn));
	echo "<tr bgcolor=white>";
	echo "<td align=center><font size=2 color=green>" . $i . "</font></td>";
	echo "<td><a href=modify_subject1.php?bid=" . $row['bulletin_id'];
	echo "><font size=2 color=green>" . $row['bulletin_title'] . "</font></a></td>";
	echo "<td><font size=2 color=green>" . $row['publish_date'] . "</font></td>";
	echo "<td><font size=2 color=green>" . $n . "</font></td>";
	if( $row['puttop'] )
		echo "<td><input type=checkbox name=checkbox_" . $row['bulletin_id'] . " value=1 checked></td>";
	else
		echo "<td><input type=checkbox name=checkbox_" . $row['bulletin_id'] . " value=0></td>";
		
	echo "<td><a href=delete_subject.php?bid=" . $row['bulletin_id'] . "><font size=2 color=red>DEL</font></a></td>";
	echo "</tr>";
	$i++;
}
?>
<tr bgcolor=white align=center><td colspan=6><input type="submit" name="Submit" value="�ק�m��"></td></tr>
</table>
</form>

<p align="center">&nbsp;</p>
<form name="form3" method="post" action="modify_puttop.php">
<input name="classify" type="hidden" value="�ե~�ǳN����">
<table width="700" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#666600">
  <tr bgcolor="#666600"> 
    <td colspan="5"><font color="white" size="3"><strong>�ե~�ǳN����</strong></font></td>
  </tr>
  <tr bgcolor="#FFFFA4"> 
    <td><font color="#000099" size="2">No</font></td>
    <td><font color="#000099" size="2">���D</font></td>
    <td><font color="#000099" size="2">���i���</font></td>
    <td><font color="#000099" size="2">���ɼ�</font></td>
    <td><font color="#000099" size="2">�m��</font></td>
    <td><font color="#000099" size="2">�R��</font></td>
  </tr>
<?php
$sql = "Select * From bulletin_board Where classify='�ե~�ǳN����' Order By bulletin_id DESC";
$result = mysql_query($sql, $conn) or die(mysql_error());
$i = 1;
while( $row = mysql_fetch_array($result) )
{
	$sql = "Select * From bulletin_files Where bulletin_id='" . $row['bulletin_id'] . "'";
	$n = mysql_num_rows(mysql_query($sql, $conn));
	echo "<tr bgcolor=white>";
	echo "<td align=center><font size=2 color=green>" . $i . "</font></td>";
	echo "<td><a href=modify_subject1.php?bid=" . $row['bulletin_id'];
	echo "><font size=2 color=green>" . $row['bulletin_title'] . "</font></a></td>";
	echo "<td><font size=2 color=green>" . $row['publish_date'] . "</font></td>";
	echo "<td><font size=2 color=green>" . $n . "</font></td>";
	if( $row['puttop'] )
		echo "<td><input type=checkbox name=checkbox_" . $row['bulletin_id'] . " value=1 checked></td>";
	else
		echo "<td><input type=checkbox name=checkbox_" . $row['bulletin_id'] . " value=0></td>";
		
	echo "<td><a href=delete_subject.php?bid=" . $row['bulletin_id'] . "><font size=2 color=red>DEL</font></a></td>";
	echo "</tr>";
	$i++;
}
?>
<tr bgcolor=white align=center><td colspan=6><input type="submit" name="Submit" value="�ק�m��"></td></tr>
</table>
</form>

<p align="center">&nbsp;</p>
<form name="form4" method="post" action="modify_puttop.php">
<input name="classify" type="hidden" value="���Ǫ����i">
<table width="700" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#666600">
  <tr bgcolor="#666600"> 
    <td colspan="5"><font color="white" size="3"><strong>���Ǫ����i</strong></font></td>
  </tr>
  <tr bgcolor="#FFFFA4"> 
    <td><font color="#000099" size="2">No</font></td>
    <td><font color="#000099" size="2">���D</font></td>
    <td><font color="#000099" size="2">���i���</font></td>
    <td><font color="#000099" size="2">���ɼ�</font></td>
    <td><font color="#000099" size="2">�m��</font></td>
    <td><font color="#000099" size="2">�R��</font></td>
  </tr>
  <?php
$sql = "Select * From bulletin_board Where classify='���Ǫ����i' Order By bulletin_id DESC";
$result = mysql_query($sql, $conn) or die(mysql_error());
$i = 1;
while( $row = mysql_fetch_array($result) )
{
	$sql = "Select * From bulletin_files Where bulletin_id='" . $row['bulletin_id'] . "'";
	$n = mysql_num_rows(mysql_query($sql, $conn));
	echo "<tr bgcolor=white>";
	echo "<td align=center><font size=2 color=green>" . $i . "</font></td>";
	echo "<td><a href=modify_subject1.php?bid=" . $row['bulletin_id'];
	echo "><font size=2 color=green>" . $row['bulletin_title'] . "</font></a></td>";
	echo "<td><font size=2 color=green>" . $row['publish_date'] . "</font></td>";
	echo "<td><font size=2 color=green>" . $n . "</font></td>";
	if( $row['puttop'] )
		echo "<td><input type=checkbox name=checkbox_" . $row['bulletin_id'] . " value=1 checked></td>";
	else
		echo "<td><input type=checkbox name=checkbox_" . $row['bulletin_id'] . " value=0></td>";
		
	echo "<td><a href=delete_subject.php?bid=" . $row['bulletin_id'] . "><font size=2 color=red>DEL</font></a></td>";
	echo "</tr>";
	$i++;
}
?>
<tr bgcolor=white align=center><td colspan=6><input type="submit" name="Submit" value="�ק�m��"></td></tr>
</table>
</form>
<?php
mysql_close($conn);
?>
