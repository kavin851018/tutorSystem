<?
// =====
// This file is used to modify a subject
// =====

$target = "../login.php";
include '../../../check_login.php';
include '../../../connect_db.php';

// Read data from the 'bulletin_board'.
@$bulletin_id = $_GET['bid'];

if( isset($bulletin_id) && $bulletin_id != "")
{
	$sql = "Select * From bulletin_board Where bulletin_id='$bulletin_id'";
	$result = mysql_query($sql, $conn) or die(mysql_error());
	$row = mysql_fetch_array($result);
	$bulletin_id = $row['bulletin_id'];
	$title = $row['bulletin_title'];
	$content = $row['bulletin_content'];
	$date = $row['publish_date'];
	$classify = $row['classify'];
}
else
{
	$bulletin_id = $_SESSION['bulletin_id'];
	$title = $_SESSION['title'];
	$content = $_SESSION['content'];
	$date = $_SESSION['date'];
	$classify = $_SESSION['classify'];
}
?><head>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
//-->
</script>
</head>

<title>Modify a Subject</title><p>&nbsp;</p>
<form name="form1" method="post" action="modify_subject2.php">
  <table width="600" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#006633">
    <tr> 
      <td colspan="2"> <div align="center"><font color="white" size="3"><strong>Modify a Subject - Step 1
	</strong></font></div></td>
    </tr>
    <tr> 
      <td bgcolor="#DDFFED"><div align="center"><font color="#003300" size="2">���D</font></div></td>
      <td bgcolor="white"><input name="title" type="text" id="title" size="30" maxlength="64" value="<?php echo $title;?>"></td>
    </tr>
    <tr> 
      <td bgcolor="#DDFFED"><div align="center"><font color="#003300" size="2">���e</font></div></td>
      <td bgcolor="white"><textarea name="content" cols="75" rows="8" id="content"><?php echo $content;?></textarea></td>
    </tr>
	<tr> 
      <td bgcolor="#DDFFED"><font size="2">����</font></td>
	  <td bgcolor="white"><select name="classify" id="classify">
	  <option value="�t�W�ǳN����" <?php if($classify=="�t�W�ǳN����") echo "selected";?>>�t�W�ǳN����</option>
          <option value="�t�W�@�뤽�i" <?php if($classify=="�t�W�@�뤽�i") echo "selected";?>>�t�W�@�뤽�i</option>
          <option value="�ե~�ǳN����" <?php if($classify=="�ե~�ǳN����") echo "selected";?>>�ե~�ǳN����</option>
        </select></td>
	</tr>
    <tr> 
      <td colspan="2"><div align="center">
          <input name="id" type="hidden" id="bulletin_id" value="<?php echo $bulletin_id; ?>">
	  <input name="date" type="hidden" id="publish_date" value="<?php echo $date; ?>">
	  <input name="back" type="button" value="��^" onClick="MM_goToURL('parent','bulletin_manager.php');return document.MM_returnValue">
          <input type="submit" name="Submit" value="�U�@�B">
        </div></td>
    </tr>
  </table>

</form>
<p align="center"><font color="blue" size="2">Note: �Y���妳�W�s���Шϥ�&lt;link&gt;http://example.com.tw&lt;/link&gt;�A�Y�i�ϥζW�s���C</font></p>
