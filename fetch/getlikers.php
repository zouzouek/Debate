<?php

include '../config/db.php';
session_start();
if (!isset($_GET["cid"])) {
    echo 'error';
} else {
    $results = array();
    $cid = $_GET['cid'];
    $query = mysql_query("SELECT uid FROM `activity_table` WHERE `cid` = $cid AND `LD` = 1");
    if (mysql_num_rows($query) > 0) {
        while ($liker = mysql_fetch_array($query)) {
            $uid = $liker['uid'];
            $uquery = mysql_query("SELECT * FROM `user_table` WHERE `uid` = $uid");
            $user = mysql_fetch_array($uquery);
            if ($user > 0)
                $results[] = array('user' => $user['username']);
        }
        echo json_encode($results);
    }else {
        $results[] = array('none' => 'none');
        echo json_encode($results);
    }
}
mysql_close();
?>
