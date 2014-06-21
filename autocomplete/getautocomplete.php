<?php

include '../config/db.php';
$termh = $_GET["term"];

$term = substr(strtolower($termh), 1);

$query = mysql_query("SELECT * FROM tag_table where tagname like '%" . $term . "%' order by tagname");
$json = array();

while ($tag = mysql_fetch_array($query)) {
    $json[] = array(
        'value' => $tag["tagname"],
        'label' => $tag["tagname"] . " - " . $tag["category"],
        'category' => $tag['category']
    );
}

echo json_encode($json);
?>
