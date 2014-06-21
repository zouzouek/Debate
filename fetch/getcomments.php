<?php

include '../config/db.php';
session_start();
if (!isset($_GET["tid"]) || !isset($_GET['side'])) {
    echo 'error';
} else {
    $currentuser = $_SESSION['id'];
    $tid = $_GET["tid"];
    $side = $_GET['side'];
    $get_comments = mysql_query("SELECT * FROM `comments_table` 
                                            WHERE `tid` = $tid && `side` = $side ORDER BY UNIX_TIMESTAMP(Date) DESC");
    $general = array();
    $related_which = array();
    $results = array();
    
    if (mysql_num_rows($get_comments) > 0) {
        while ($comment = mysql_fetch_array($get_comments)) {
            $commentator_id = $comment['uid'];
            $user_query = mysql_query("SELECT * FROM `user_table` WHERE `uid` = $commentator_id");
            $user = mysql_fetch_array($user_query);
            $cid = $comment['cid'];

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
        }
      
        echo json_encode($general);
    } else {
        
        echo json_encode($general);
    }
}
mysql_close();
?>
