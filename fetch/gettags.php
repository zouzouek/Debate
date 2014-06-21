<?php

include '../config/db.php';
session_start();
$results = array();
$uid = $_SESSION['id'];
$query = mysql_query("SELECT t.tagname, t.category FROM readlater_table r, tag_table t WHERE r.uid = $uid AND r.tid = t.tid");
if (mysql_num_rows($query) > 0) {
    while ($read = mysql_fetch_array($query)) {
        $results[] = array('tag' => $read['tagname'],
            'cat' => $read['category']);
    }
    echo json_encode($results);
} else {
    $results[] = array('none' => 'You have no marked tags!');
    echo json_encode($results);
}

mysql_close();
?>
