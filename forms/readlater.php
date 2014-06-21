<?php

include '../config/db.php';
session_start();
$tid = $_POST['tid'];
$uid = $_SESSION['id'];
$mark_query = mysql_query("SELECT * FROM `readlater_table` WHERE `tid` = $tid AND `uid` = $uid");
$marked = mysql_fetch_array($mark_query);
if ($marked > 0) {
    mysql_query("DELETE FROM `readlater_table` WHERE `tid` = $tid AND `uid` = $uid");
    echo 'remove';
} else {
    mysql_query("INSERT INTO `readlater_table`(`uid`, `tid`) 
                VALUES ('$uid','$tid')") or die('oops');
    echo 'new';
}
mysql_close();
?>
