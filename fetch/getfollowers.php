<?php

include '../config/db.php';
session_start();
$results = array();
if (!isset($_GET['username']))
    header("Location: ../alert/error.php");

$username = $_GET['username'];
$user_query = mysql_query("SELECT * FROM `user_table` WHERE `username` = '$username'");
$user = mysql_fetch_array($user_query);
$uid = $user['uid'];
$query = mysql_query("SELECT u.username FROM user_table u, followers_table f WHERE f.uid = $uid AND f.follower_id = u.uid");
if (mysql_num_rows($query) > 0) {
    while ($read = mysql_fetch_array($query)) {
        $results[] = array('user' => $read['username']);
    }
    echo json_encode($results);
} else {
    $results[] = array('none' => 'none');
    echo json_encode($results);
}

mysql_close();
?>