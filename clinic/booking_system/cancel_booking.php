<?php
include '../../connect_db.php';
session_start();
@$_SESSION['booked_date'] = $_GET['d'];
@$_SESSION['location'] = $_GET['location'];
@$_SESSION['order'] = $_GET['order'];
@$_SESSION['tutor'] = $_GET['tutor'];
?>

<meta http-equiv="Content-Type" content="text/html; charset=big5">
<style type="text/css">
<!--
.style1 {font-size: 13px;color: #FFFFFF;}
.style2 {font-size: 13px;color: #003366;}
-->
</style>
<p align=center><?php echo @$_SESSION['message']; $_SESSION['message'] = ""; unset($_SESSION['message']);?></p>
<form name="form1" method="post" action="cancel_booking2.php">
  <table width="300"  border="0" align="center" bgcolor="#990000">
    <tr>
      <td align="center"><p class="style1">You can cancel this booking,<br>
        but you have to input the booking Code.</p></td>
    </tr>
    <tr>
      <td align="center" bgcolor="#FFFFFF" class=style2><p><br>        
			Code:
          <input name="code" type="password" id="code">
      </p>
      <p>
        <input type="submit" name="Submit" value="確定">    
          </p></td>
    </tr>
  </table>
</form>
<?php
mysql_close($conn);
?>