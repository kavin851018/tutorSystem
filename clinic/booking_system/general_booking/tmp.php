<?php
include '../../../connect_db.php';
$str = addslashes("‧ 留美面面觀 ‧ 留美準備工作申請流程 ‧ 留美申請成功關鍵‧ 申請美國研究所之考量重點 *參加講座者可於自學護照蓋一個章? 現場備有點心 歡迎參加 ");
$sql = "Update general_booking set description='$str' Where id='20090421152319'";
mysql_query($sql, $conn);
mysql_close($conn);
?>