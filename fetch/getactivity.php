<?php

include '../config/db.php';
session_start();
$results = array();
$uid = $_SESSION['id'];
$query = mysql_query("SELECT * FROM `user_activity` WHERE `recipient_id` = $uid ORDER BY UNIX_TIMESTAMP(time_sent) DESC");
if (mysql_num_rows($query) > 0) {
    while ($act = mysql_fetch_array($query)) {
        $act_id = $act['act_id'];
        $sender_id = $act['sender_id'];
        $target_id = $act['target_id'];
        $target_object = $act['object_id'];
        $type = $act['object_type'];
        $text = $act['activity'];
        $time = date('d M y', strtotime($act['time_sent']));

        $sender_query = mysql_query("SELECT * FROM `user_table` WHERE `uid` = $sender_id");
        $sender_user = mysql_fetch_array($sender_query);

        $target_query = mysql_query("SELECT * FROM `user_table` WHERE `uid` = $target_id");
        $target_user = mysql_fetch_array($target_query);

        if ($sender_user > 0 && $target_user > 0) {
            if ($type != 'follow') {
                //comment based activity
                $room_query = mysql_query("SELECT t.tagname, t.category, c.side, c.comment FROM tag_table t, comments_table c WHERE c.cid = $target_object
                        AND c.tid = t.tid");
                $roominfo = mysql_fetch_array($room_query);
                if ($roominfo > 0) {
                    $rn = substr($roominfo['tagname'], 1);
                    $cat = $roominfo['category'];
                    $side = $roominfo['side'];
                    $comment = $roominfo['comment'];
                    $link = 'room.php?cat=' . $cat . '&tag=' . $rn . '&not=' . $side . $target_object; //highlight comment on pageload
                    $link = '<a target="_parent" href="' . $link . '">comment</a>';
                    $linknot = 'room.php?cat=' . $cat . '&tag=' . $rn;
                    $linknot = '<a target="_parent" href="' . $linknot . '">#' . $rn . '</a> ';
                    $text = preg_replace('/comment/', $link, $text);

                    $target_name = $target_user["username"];
                    $target_link = '<a href="profile.php?username=' . $target_name . '">' . $target_name . '</a>';
                    $text = preg_replace('/' . $target_name . '/', $target_link, $text);
                    if ($type == 'share') {
                        $text = $text . ':<br> <mark style="padding-left: 5px">' . $comment . '</mark>';
                    }
                    $sender = '<a style="padding-left: 5px" href="profile.php?username=' . $sender_user["username"] . '"> ' . $sender_user["username"] . '</a>';
                    $subfinal = '<span> ' . $sender . ' ' . $text . ' </span>';
                    $final = '<h6 class="feed-div">' . $subfinal . '</h6><div style="padding-left: 5px" class="feed-div-info"> ' . $time . ' - Tag: ' . $linknot . '<div>';
                }
            } else {
                //follow activity
                $target_name = $target_user["username"];
                $target_link = '<a href="profile.php?username=' . $target_name . '">' . $target_name . '</a>';
                $text = preg_replace('/' . $target_name . '/', $target_link, $text);
                $sender = '<a style="padding-left: 5px" href="profile.php?username=' . $sender_user["username"] . '"> ' . $sender_user["username"] . '</a>';
                $subfinal = '<span> ' . $sender . ' ' . $text . ' </span>';
                $final = '<h6 class="feed-div">' . $subfinal . '</h6><div style="padding-left: 5px" class="feed-div-info"> ' . $time;
            }

            $results[] = array('act' => $final, 'time' => strtotime($act['time_sent']));
        }
    }
    echo json_encode($results);
} else {
    $results[] = array('none' => 'You have no activity');
    echo json_encode($results);
}
mysql_close();
?>
