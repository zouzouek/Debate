<?php

include '../config/db.php';

session_start();

$uid = $_SESSION['id'];
$tagname = $_POST['tagname'];
$cat = $_POST['cat'];
$side = $_POST['side'];
$reptyto = "";
if ($side == "1") {
    $comment = $_POST["comment1"];
    $comment = str_replace("'", "''", $comment);
    if (isset($_POST['reply1']) && $_POST['reply1'] != "")
        $reptyto = $_POST['reply1'];
} else if ($side == "2") {
    $comment = $_POST["comment2"];
    $comment = str_replace("'", "''", $comment);
    if (isset($_POST['reply2']) && $_POST['reply2'] != "")
        $reptyto = $_POST['reply2'];
}
$get_tags = mysql_query("SELECT * FROM `tag_table` WHERE LOWER(`tagname`) = LOWER('$tagname') && `category` = '$cat'") or die(mysql_error());

$tag_rows = mysql_fetch_array($get_tags);

if ($tag_rows > 0) {
    $tid = $tag_rows['tid'];

    $insert_comment = mysql_query("INSERT INTO `comments_table`(`uid`, `tid`, `comment`, `side`, `replyto`, `reports`) 
                VALUES ('$uid','$tid','$comment','$side',IF(LENGTH('$reptyto')=0, NULL, '$reptyto'),0)");
    $cid = mysql_insert_id();

    mysql_query("UPDATE `user_stat` SET `posts` = CASE WHEN `posts` IS NULL THEN 1 ELSE (`posts` + 1) END 
            WHERE `uid` = $uid");

    //check mentions and add update stats ONCE ONLY
    $arr = preg_split('/\s+/', $comment);
    $matches = preg_grep('/@[A-Za-z0-9_-]+/', $arr);
    foreach ($matches as $i) {
        $target_mention = substr($i, 1); //remove @
        $get_user = mysql_query("SELECT * FROM `user_table` WHERE `username` = '$target_mention'");
        $user_arr = mysql_fetch_array($get_user);
        if ($user_arr > 0) {
            $id = $user_arr['uid'];
            if ($id != $uid) {
                mysql_query("UPDATE `user_stat` SET `mentioned` = CASE WHEN `mentioned` IS NULL THEN 1 ELSE (`mentioned` + 1) END 
          WHERE `uid` = $id");
                //trigger notification
                $type = 'mention';
                if ($reptyto == "")
                    $not = 'mentioned you in a comment';
                elseif ($reptyto[0] == 'x') {
                    $not = 'replied against your comment';
                } else {
                    $not = 'replied with your comment';
                }
                mysql_query("INSERT INTO `notification_table`(`recipient_id`, `sender_id`, `notification`, `object_type`, `object_id`) 
            VALUES ('$id','$uid','$not','$type','$cid')") or die(mysql_error());
                
                //save all $id's in array and update activity to join all mentions
                updateActivity($cid, $reptyto, $uid, $id);
            }
        }
    }

    echo $cid;
} else {
    echo 'error posting';
}
mysql_close();

function updateActivity($cid, $reply, $sender, $target) {
    $followers_query = mysql_query("SELECT * FROM followers_table WHERE uid = $sender");
    if (mysql_num_rows($followers_query) > 0) {
        $target_query = mysql_query("SELECT * FROM user_table WHERE uid = $target");
        $target_row = mysql_fetch_array($target_query);
        $target_name = $target_row['username'];
        while ($follower = mysql_fetch_array($followers_query)) {
            $receiver = $follower['follower_id'];
            $type = 'mention';
            if ($reply === "")
                $act = 'mentioned '.$target_name.' in a comment';
            elseif ($reply[0] == 'x') {
                $act = 'replied against '.$target_name.' in a comment';
            } else {
                $act = 'replied with '.$target_name.' in a comment';
            }
            mysql_query("INSERT INTO `user_activity`(`recipient_id`, `sender_id`, `target_id`, `object_type`, `object_id`, `activity`) 
                        VALUES ('$receiver','$sender','$target','$type','$cid','$act')") or die(mysql_error());
        }
    }
}

?>
