<?php
// This file is the step 2 of 'add a subject'. It is used to attach files for a subject. It will store the uploaded files and add them into the database records.

$target = "../login.htm";
include '../../../check_login.php';
include '../../../connect_db.php';

if( isset($_POST['id']) && @$_POST['id'] != "" )
{
	$bulletin_id = $_POST['id'];
	$title = $_POST['title'];
	$content = $_POST['content'];
	$date = $_POST['date'];
	$classify = $_POST['classify'];
	$_SESSION['bulletin_id'] = $bulletin_id;
	$_SESSION['title'] = $title;
	$_SESSION['content'] = $content;
	$_SESSION['date'] = $date;
	$_SESSION['classify'] = $classify;
}
else
{
	$bulletin_id = $_SESSION['bulletin_id'];
	$title = $_SESSION['title'];
	$content = $_SESSION['content'];
	$date = $_SESSION['date'];
	$classify = $_SESSION['classify'];

	// If the request doesn't come from 'delete_file.php', deal with file transfer
	if( !isset($_SESSION['del_file']) || (@$_SESSION['del_file'] == "") )
	{
		$uploaddir = '../../../../bulletin_upfiles/';
		// Generate file name randomly.
		$basename = basename($_FILES['file']['name']);
		while(1)
		{
			$filename = date('YmdHis') . rand(10,99) . substr($basename,(strlen($basename)-4),4);
			$sql = "Select file_name From bulletin_files Where file_name='$filename'";
			$result_n = mysql_query($sql, $conn) or die(mysql_error());
			$n = mysql_num_rows($result_n);
			if( !$n )
				break;
		}

		$uploadfile = $uploaddir . $filename;

		if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile) && $_FILES['file']['name'] != "")
		{
			echo "<div align=center><font color=blue size=2>Upload $filename successfully!</font></div>";
			$sql = "Insert Into bulletin_files values('$bulletin_id', '$filename')";
			mysql_query($sql, $conn) or die(mysql_error());
		}
		else
		{
			echo "Possible file upload attack!\n";
		}

	}
	unset($_SESSION['del_file']);
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

<p>&nbsp;</p>
<form action="modify_subject2.php" method="post" enctype="multipart/form-data" name="form1">
  <table width="600" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#006633">
    <tr> 
      <td colspan="2"> <div align="center"><font color="white" size="3"><strong>Modify a Subject - Step 2 (Attach files)</strong></font></div></td>
    </tr>
    <tr> 
      <td bgcolor="#DDFFED"><div align="center"><font color="#003300" size="2">標題</font></div></td>
      <td bgcolor="white"><?php echo "<font color=green size=2>" . $title . "</font>";?></td>
    </tr>
    <tr> 
      <td bgcolor="#DDFFED"><div align="center"><font color="#003300" size="2">內容</font></div></td>
      <td bgcolor="white"><?php echo "<font color=green size=2>" . str_replace("\n", "<br>", $content) . "</font>";?></td>
    </tr>
    <tr> 
      <td bgcolor="#DDFFED"><div align="center"><font color="#003300" size="2">分類</font></div></td>
      <td bgcolor="white"><?php echo "<font color=green size=2>" . $classify . "</font>";?></td>
    </tr>
    <tr>
      <td bgcolor="#DDFFED"><div align="center"><font color="#003300" size="2">檔案</font></div></td>
      <td bgcolor="white"> 
        <?php
$sql = "Select * From bulletin_files Where bulletin_id='$bulletin_id'";
$result = mysql_query($sql, $conn) or die(mysql_error());

$i = 1;
while( $row = mysql_fetch_array($result) )
{
	echo "<font color=green size=2>(" . $i . ")" . $row['file_name'];
	echo "[<a href=delete_file.php?id=" . $row['bulletin_id'];
	echo "&fn=" . $row['file_name'] . "><font color=red>DEL</font></a>]</font><br>";
	$i++;
}
?>
        <p> 
          <input type="file" name="file">
          <input type="submit" name="Submit" value="Add">
          <font color="blue" size="2">(請先選擇檔案，再按下Add鍵)<br>
          </font></p>
        </td>
    </tr>
    <tr><td colspan=2 align=center>
    <input name="back" type="button" value="上一步" onClick="MM_goToURL('parent','modify_subject1.php');return document.MM_returnValue">
<input name="finish" type="button" value="完成" onClick="MM_goToURL('parent','modify_subject3.php');return document.MM_returnValue">
    </td></tr>
  </table>

</form>

<?php
mysql_close($conn);
?>
