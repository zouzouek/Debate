<?php

session_start();
if (!isset($_GET['username']))
    header("Location: ../alert/error.php");

include './config/db.php';

#####################################
$username = $_GET['username'];

$get_user = mysql_query("SELECT s.* FROM user_table u, user_stat s WHERE u.username='$username' AND u.uid = s.uid");
$json = array();

while ($user = mysql_fetch_array($get_user)) {
    $json[] = array('Name' => 'Likes Received', 'Occurance' => $user["likes_received"]);
    $json[] = array('Name' => 'Dislikes Received', 'Occurance' => $user["dislikes_received"]);
    $json[] = array('Name' => 'Liked', 'Occurance' => $user["likes"]);
    $json[] = array('Name' => 'Disliked', 'Occurance' => $user["dislikes"]);
    $json[] = array('Name' => 'Posts', 'Occurance' => $user["posts"]);
    $json[] = array('Name' => 'Mentioned', 'Occurance' => $user["mentioned"]);
}
echo json_encode($json);
?>