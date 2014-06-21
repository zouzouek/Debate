<?php

include '../config/db.php';
session_start();
if (!isset($_GET["cid"]) || trim($_GET["cid"]) == "")
    echo 'error';
else {
    $uid = $_SESSION['id'];
    $cid = $_GET["cid"];
    $get_comment = mysql_query("SELECT uid FROM `comments_table` WHERE `uid` = $uid AND `cid` = $cid") or die('fuck');
    $comment_uid = mysql_fetch_row($get_comment);
    if ($comment_uid) {
        mysql_query("DELETE FROM `comments_table` WHERE `cid` = $cid AND `uid` = $uid");
        mysql_query("UPDATE `user_stat` SET `posts` = CASE WHEN `posts` = 1 THEN NULL ELSE (`posts` - 1) END 
            WHERE `uid` = $uid");
        echo 'success';
    }else
        echo 'not permitted';
}
?>
