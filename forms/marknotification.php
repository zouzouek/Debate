<?php

include '../config/db.php';
session_start();
if (!isset($_GET["nid"]) || trim($_GET["nid"]) == "")
    echo 'error';
else {
    
    $nid = $_GET["nid"];
    mysql_query("UPDATE `notification_table` SET `is_unread`= 0 WHERE `nid` = $nid");
    echo 'success';

    mysql_close();
}
?>
