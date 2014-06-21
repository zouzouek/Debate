<?php

include '../config/db.php';
session_start();
$results = array();
$uid = $_SESSION['id'];
$query = mysql_query("SELECT * FROM `notification_table` WHERE `recipient_id` = $uid ORDER BY UNIX_TIMESTAMP(time_sent) DESC");
if (mysql_num_rows($query) > 0) {
    while ($not = mysql_fetch_array($query)) {
        $sender_id = $not['sender_id'];
        $uquery = mysql_query("SELECT * FROM `user_table` WHERE `uid` = $sender_id");
        $user = mysql_fetch_array($uquery);
        if ($user > 0) {
            $nid = $not['nid'];
            $bool = $not['is_unread'];
            $text = $not['notification'];
            $time = date('d M y', strtotime($not['time_sent']));
            $target_id = $not['object_id'];
            if ($not['object_type'] != 'follow') {
                //comment id
                $room_query = mysql_query("SELECT t.tagname, t.category, c.side FROM tag_table t, comments_table c WHERE c.cid = $target_id
                        AND c.tid = t.tid");
                $roominfo = mysql_fetch_array($room_query);
                if ($roominfo > 0) {
                    $rn = substr($roominfo['tagname'], 1);
                    $cat = $roominfo['category'];
                    $side = $roominfo['side'];
                    $link = 'room.php?cat=' . $cat . '&tag=' . $rn . '&not=' . $side . $target_id; //highlight comment on pageload
                    $link = '<a href="' . $link . '">comment</a>';
                    $linknot = 'room.php?cat=' . $cat . '&tag=' . $rn;
                    $linknot = '<a href="' . $linknot . '">#' . $rn . '</a> ';
                    $text = preg_replace('/comment/', $link, $text);
                    $username = '<a id="u_' . $target_id . '" href="#">' . $user["username"] . '</a>';
                    $subfinal = '<span>' . $username . ' ' . $text . ' | ' . $time . '</span><br><span>Tag: ' . $linknot . '<span>';
                }
            } else {
                //user id
                $username = '<a id="u_' . $target_id . '" href="#">' . $user["username"] . '</a>';
                $subfinal = '<span>' . $username . ' ' . $text . ' | ' . $time . '</span>';
            }
            if ($bool == 1) {
                $final = '<div class = "unread" id="unread_' . $nid . '" >' . $subfinal . '</div>';
            } else {
                $final = '<div class = "read" id="read_' . $nid . '">' . $subfinal . '</div>';
            }

            $results[] = array('not' => $final);
        }
    }
    echo json_encode($results);
} else {
    $results[] = array('none' => 'You have no notifications');
    echo json_encode($results);
}

mysql_close();
?>
