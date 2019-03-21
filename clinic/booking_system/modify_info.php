<?php
$target = "login.htm";
include 'check_login.php';

if( $valid )
{

include '../../connect_db.php';
$sql = "Select * From user Where id='" . $_SESSION['id'] . "'";
$row = mysql_fetch_array(mysql_query($sql, $conn));
mysql_close($conn);

?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=big5">
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
//-->
</script>
</head>

<body>
<p>&nbsp;</p>
<form name="form1" method="post" action="modify_info2.php">
  <table width="400" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#000066">
    <tr bgcolor="white"> 
      <td bgcolor="#CECEFF" class="table_title">ID<span class="star">*</span></td>
      <td><input name="id" type="text" id="id2" value="<?php echo $row['id'];?>" size="16" maxlength="16"></td>
    </tr>
    <tr bgcolor="white"> 
      <td bgcolor="#CECEFF" class="table_title">Passwd<span class="star">*</span></td>
      <td><input name="passwd" type="password" id="passwd" value="<?php echo $row['passwd'];?>" size="16" maxlength="16"></td>
    </tr>
    <tr bgcolor="white"> 
      <td bgcolor="#CECEFF" class="table_title">Name</td>
      <td><input name="name" type="text" id="name" value="<?php echo $row['name'];?>" size="20" maxlength="32"></td>
    </tr>
    <tr bgcolor="white"> 
      <td bgcolor="#CECEFF" class="table_title">Email</td>
      <td><input name="email" type="text" id="email" value="<?php echo $row['email'];?>" size="35" maxlength="64"></td>
    </tr>
    <tr bgcolor="white"> 
      <td bgcolor="#CECEFF" class="table_title">Phone</td>
      <td><input name="phone" type="text" id="phone" value="<?php echo $row['phone'];?>" size="16" maxlength="16"></td>
    </tr>
    <tr bgcolor="#CECEFF"> 
      <td colspan="2" align=right><input type="submit" name="Submit" value="Modify"> <font size=2 color=blue>[<a href=show_management.php>Back</a>]</font>
    </tr>
  </table>
  </form>
<p align="center"></p>
</body>
</html>
<?php
} // login check
?>