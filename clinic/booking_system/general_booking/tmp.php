<?php
include '../../../connect_db.php';
$str = addslashes("�E �d�������[ �E �d���ǳƤu�@�ӽЬy�{ �E �d���ӽЦ��\����E �ӽЬ����s�Ҥ��Ҷq���I *�ѥ[���y�̥i��۾��@�ӻ\�@�ӳ�? �{���Ʀ��I�� �w��ѥ[ ");
$sql = "Update general_booking set description='$str' Where id='20090421152319'";
mysql_query($sql, $conn);
mysql_close($conn);
?>