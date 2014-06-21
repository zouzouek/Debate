<?php

include '../config/db.php';
session_start();
if (!isset($_GET["cid"]) || trim($_GET["cid"]) == "")
    echo 'error';
else {
    $uid = $_SESSION['id'];
    $cid = $_GET["cid"];
    //check if the comment belongs to the user or not
    $check_query = mysql_query("SELECT * FROM `comments_table` WHERE `cid` = $cid");
    $checku = mysql_fetch_array($check_query);
    $co = $checku['uid'];
    if ($co == $uid) {
        $b = TRUE; //belongs to user
    } else {
        $b = FALSE;
    }

    $get_activity = mysql_query("SELECT * FROM `activity_table` WHERE `uid` = $uid AND `cid` = $cid") or die('fuck');
    $exist = mysql_fetch_array($get_activity);

    if ($exist) { //if the user has a previous activity, update
        $like = $exist['LD'];

        if ($like === '2') {
            mysql_query("UPDATE `activity_table` SET `LD`= NULL WHERE `cid` = $cid AND `uid` = $uid");
            if ($b == FALSE) {
                mysql_query("UPDATE `user_stat` SET `dislikes` = CASE WHEN `dislikes` = 1 THEN NULL ELSE (`dislikes` - 1) END 
            WHERE `uid` = $uid");
                mysql_query("UPDATE `user_stat` SET `dislikes_received` = CASE WHEN `dislikes_received` = 1 THEN NULL ELSE (`dislikes_received` - 1) END 
            WHERE `uid` = $co");
            }
            $check_null = mysql_query("SELECT aid FROM `activity_table` WHERE `uid` = $uid 
                AND `cid` = $cid AND `LD` IS NULL AND `shared` IS NULL AND `reported` IS NULL") or die('fuck');
            $check = mysql_fetch_array($check_null);
            if ($check) {
                $aid = $check['aid'];
                mysql_query("DELETE FROM `activity_table` WHERE `aid` = $aid") or die('fuck 2');
            }
            echo 'remove';
        } else if ($like === '1') {
            mysql_query("UPDATE `activity_table` SET `LD`= 2 WHERE `cid` = $cid AND `uid` = $uid");
            trigger($cid, $b, $uid, $co);
            updateActivity($cid, $b, $uid, $co);
            echo 'change';
        } else if (is_null($like)) {
            mysql_query("UPDATE `activity_table` SET `LD`= 2 WHERE `cid` = $cid AND `uid` = $uid");
            trigger($cid, $b, $uid, $co);
            updateActivity($cid, $b, $uid, $co);
            echo 'null';
        }
    } else { //if the user has no previous activity, create new one
        mysql_query("INSERT INTO `activity_table`(`cid`, `uid`, `LD`) 
                VALUES ('$cid','$uid', 2)") or die('oops');

        trigger($cid, $b, $uid, $co);
        updateActivity($cid, $b, $uid, $co);
        echo 'new';
    }
    mysql_close();
}

function trigger($cid, $belongs, $sender, $receiver) {
    if ($belongs == FALSE) {
        //update stats
        mysql_query("UPDATE `user_stat` SET `dislikes` = CASE WHEN `dislikes` IS NULL THEN 1 ELSE (`dislikes` + 1) END 
            WHERE `uid` = $sender");
        mysql_query("UPDATE `user_stat` SET `dislikes_received` = CASE WHEN `dislikes_received` IS NULL THEN 1 ELSE (`dislikes_received` + 1) END 
            WHERE `uid` = $receiver");
        //now send notification
        $type = 'dislike';
        $not = 'disliked your comment';
        mysql_query("INSERT INTO `notification_table`(`recipient_id`, `sender_id`, `notification`, `object_type`, `object_id`) 
            VALUES ('$receiver','$sender','$not','$type','$cid')") or die(mysql_error());
    }
}

function updateActivity($cid, $belongs, $sender, $target) {
    if ($belongs == FALSE) {


        $followers_query = mysql_query("SELECT * FROM followers_table WHERE uid = $sender");
        if (mysql_num_rows($followers_query) > 0) {
            $target_query = mysql_query("SELECT * FROM user_table WHERE uid = $target");
            $target_row = mysql_fetch_array($target_query);
            $target_name = $target_row['username'];
            while ($follower = mysql_fetch_array($followers_query)) {
                $receiver = $follower['follower_id'];
                $type = 'dislike';
                $act = "disliked a comment for $target_name";
                mysql_query("INSERT INTO `user_activity`(`recipient_id`, `sender_id`, `target_id`, `object_type`, `object_id`, `activity`) 
                        VALUES ('$receiver','$sender','$target','$type','$cid','$act')") or die(mysql_error());
            }
        }
    }
}

?>
