<?php

function getAverage($tid){
$result = array();
$side1 = 0;
$side2 = 0;
$stats_query = mysql_query("SELECT reports, uid, MIN(Date) AS Date, side FROM `comments_table` WHERE `tid` = '$tid' AND `reports` < 1 GROUP BY `uid` ORDER BY `side`");
$total_users = mysql_num_rows($stats_query);
while ($row = mysql_fetch_array($stats_query)) {
    if($row['side'] == 1)
        $side1++;
    else
        $side2++;
}
$result[] = array('side1'  => $side1);
$result[] = array('side2'  => $side2);
$result[] = array('total' => $total_users);
return $result;
}