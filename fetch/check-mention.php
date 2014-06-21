<?php

include '../config/db.php';
session_start();

//$uid = $_SESSION['id'];
$result = array();
$arr = $_POST['mentions'];

foreach ($arr as $m) {
    $mention = substr($m, 1);
    $search_query = mysql_query("SELECT * FROM user_table WHERE `username` = '$mention'");
    $exist = mysql_fetch_array($search_query);
    if ($exist > 0) {
        $result[] = array('mention' => $mention);
    }
}

/*$uid = $exist['uid'];
mysql_query("UPDATE `user_stat` SET `mentioned` = CASE WHEN `mentioned` IS NULL THEN 1 ELSE (`mentioned` + 1) END 
            WHERE `uid` = $uid");*/

//$result[] = array('mention' => 'fuck');
echo json_encode($result);
?>