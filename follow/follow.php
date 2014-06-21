<?php

session_start();
include '../config/db.php';

$follower = $_SESSION['username'];
$username = $_GET['username'];
$get_user_id = mysql_query("SELECT * FROM user_table WHERE username ='$username' ");
$userid = mysql_fetch_array($get_user_id);
$uid = $userid['uid'];
$get_user_id = mysql_query("SELECT * FROM user_table WHERE username ='$follower' ");
$userid = mysql_fetch_array($get_user_id);
$follower_id = $userid['uid'];
$get_user_id = mysql_query("insert into followers_table (uid,follower_id) values ($uid,$follower_id) ");
$userid = mysql_fetch_array($get_user_id);
$b = FALSE;
trigger($uid, $b, $follower_id, $uid);
updateActivity($uid, $b, $follower_id, $uid);

function trigger($cid, $belongs, $sender, $receiver) {
    if ($belongs == FALSE) {
        
        //now send notification
        $type = 'follow';
        $not = 'is now following you';
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
                $type = 'follow';
                $act = "followed $target_name";
                mysql_query("INSERT INTO `user_activity`(`recipient_id`, `sender_id`, `target_id`, `object_type`, `object_id`, `activity`) 
                        VALUES ('$receiver','$sender','$target','$type','$cid','$act')") or die(mysql_error());
            }
        }
    }
}

?>