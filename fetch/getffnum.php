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
$follows = mysql_query("SELECT * FROM followers_table WHERE follower_id = $uid");
$followers = mysql_query("SELECT * FROM followers_table WHERE uid = $uid");

$results[] = array('follows' => mysql_num_rows($follows),
    'followers' => mysql_num_rows($followers));

echo json_encode($results);

mysql_close();
?>
