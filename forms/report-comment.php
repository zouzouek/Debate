<?php

include '../config/db.php';
session_start();
if (!isset($_GET["cid"]) || trim($_GET["cid"]) == "")
    echo 'error';
else {
    $uid = $_SESSION['id'];
    $cid = $_GET["cid"];
    $get_activity = mysql_query("SELECT * FROM `activity_table` WHERE `uid` = $uid AND `cid` = $cid") or die('fuck');
    $exist = mysql_fetch_array($get_activity);

    if ($exist) { //if the user has a previous activity, update
        $reported = $exist['reported'];

        if (is_null($reported)) {
            mysql_query("UPDATE `activity_table` SET `reported`= 1 WHERE `cid` = $cid AND `uid` = $uid");
            mysql_query("UPDATE `comments_table` SET `reports`= CASE WHEN `reports` = 0 THEN 1 ELSE (`reports` + 1) END 
                WHERE `cid` = $cid");
            echo 'null';
        }
    } else { //if the user has no previous activity, create new one
        mysql_query("INSERT INTO `activity_table`(`cid`, `uid`, `reported`) 
                VALUES ('$cid','$uid', 1)") or die('oops');
        mysql_query("UPDATE `comments_table` SET `reports`= CASE WHEN `reports` = 0 THEN 1 ELSE (`reports` + 1) END 
                WHERE `cid` = $cid");
        echo 'new';
    }
}
?>
