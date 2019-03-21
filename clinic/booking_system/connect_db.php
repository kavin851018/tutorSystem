<?php
// This file is used to connect to mysql and select the database;

$conn = mysql_connect('localhost', 'root', 'Zephyr_mysql_serveR') or die(mysql_error());
mysql_select_db('splendid', $conn) or die(mysql_error());
?>
