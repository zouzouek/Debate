<?php

//echo 'running';
include '../config/db.php';
session_start();
if (!isset($_GET["cid"])) {
    echo 'error';
} else {
    
    $currentuser = $_SESSION['id'];
    $temp = $_GET["cid"];
    if (substr($temp, 4)[0] == 'x')
        $cid = substr($temp, 6);
    else {
        $cid = substr($temp, 4);
    }
    
    $get_comment = mysql_query("SELECT * FROM `comments_table` 
                                            WHERE `cid` = '$cid'") or die(mysql_error());
    $general = array();
    $related_which = array();
    if (mysql_num_rows($get_comment) > 0) {
        $comment = mysql_fetch_array($get_comment);
        $commentator_id = $comment['uid'];
        $user_query = mysql_query("SELECT * FROM `user_table` WHERE `uid` = $commentator_id");
        $user = mysql_fetch_array($user_query);

        //for num rows
        $likes_query = mysql_query("SELECT * FROM `activity_table` WHERE `cid` = $cid AND `LD` = 1");
        $dislikes_query = mysql_query("SELECT * FROM `activity_table` WHERE `cid` = $cid AND `LD` = 2");
        $share_query = mysql_query("SELECT * FROM `activity_table` WHERE `cid` = $cid AND `shared` = 1");

        //get all user related comments stats
        $related_query = mysql_query("SELECT * FROM `activity_table` WHERE `cid` = $cid AND `uid` = $currentuser");
        $related = mysql_fetch_array($related_query);

        if ($related > 1) {
            $ld = NULL;
            if ($related['LD'] == 1)
                $ld = 1;
            else if ($related['LD'] == 2)
                $ld = 2;

            $related_which[] = array('ld' => $ld,
                'shared' => $related['shared'],
                'reported' => $related['reported']);
        }

        //count likes and other stats
        $likes_num = mysql_num_rows($likes_query);
        $dislikes_num = mysql_num_rows($dislikes_query);
        $shares_num = mysql_num_rows($share_query);
        $reports_num = $comment['reports'];


        $date = date('d M y', strtotime($comment['Date']));
        $general[] = array('username' => $user['username'],
            'comment' => $comment,
            'date' => $date,
            'likes' => $likes_num,
            'dislikes' => $dislikes_num,
            'shares' => $shares_num,
            'reports' => $reports_num,
            'related' => $related_which);
        $related_which = array();

        echo json_encode($general);
    } else {
        $general[] = array('nf' => 'not found');
        echo json_encode($general);
    }
}
?>
