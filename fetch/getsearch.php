<?php

include '../config/db.php';
session_start();

if (!isset($_GET['q']) || trim($_GET['q']) == "")
    header('Location: ../alert/error.php');
else {
    $q = strtolower(urldecode($_GET['q']));
    $q = str_replace("'", "''", $q);
}

$results = array();
$users_array = array();
$tags_array = array();

$user_query = mysql_query("SELECT * FROM user_table WHERE `username` LIKE '%" . $q . "%' ORDER BY username");
$tag_query = mysql_query("SELECT * FROM tag_table WHERE `tagname` LIKE '%" . $q . "%' ORDER BY tagname");
if (mysql_num_rows($user_query) > 0) {
    while ($user = mysql_fetch_array($user_query)) {
        $users_array[] = array('user' => $user['username']);
    }
} else {
    $users_array[] = array("none" => "No users were found.");
}
if (mysql_num_rows($tag_query) > 0) {
    while ($tag = mysql_fetch_array($tag_query)) {
        $tags_array[] = array('tag' => $tag['tagname'],
            'cat' => $tag['category']);
    }
} else {
    $tags_array[] = array("none" => "No tags were found.");
}

$results[] = array('users' => $users_array,
    'tags' => $tags_array);
echo json_encode($results);
mysql_close();
?>
