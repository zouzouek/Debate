<?php

session_start();
include './config/db.php';
$get_user = mysql_query("SELECT * FROM user_table ");
$usernames= array();
while ($user = mysql_fetch_array($get_user)){
    $usernames[]=array('username'=>$user['username']);
}

echo json_encode($usernames);

?>

