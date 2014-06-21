<?php 
session_start();
include '../config/db.php';

$follower = $_SESSION['username'];
$username=$_GET['username'];
$get_user_id = mysql_query("SELECT * FROM user_table WHERE username ='$username' ");
$userid = mysql_fetch_array($get_user_id);
$uid = $userid['uid'];
$get_user_id = mysql_query("SELECT * FROM user_table WHERE username ='$follower' ");
$userid = mysql_fetch_array($get_user_id);
$follower_id=$userid['uid'];
$get_user_id = mysql_query("delete from followers_table where uid='$uid' AND follower_id='$follower_id' ");
$userid = mysql_fetch_array($get_user_id);
?>