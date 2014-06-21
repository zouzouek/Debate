<?php

include '../config/db.php';
include '../fetch/getAverage.php';
$name = $_GET['name'];
$get_news = mysql_query("SELECT C.tid AS tid,tagname,category , COUNT(C.cid) AS comments, COUNT(DISTINCT C.uid)AS users FROM comments_table AS C 
    INNER JOIN tag_table ON C.tid = tag_table.tid WHERE category = '$name' AND C.Date > DATE_SUB(NOW(), INTERVAL 24 HOUR)
  AND C.Date <= NOW() GROUP BY tagname ORDER BY comments DESC limit 2");
$json = array();
$percentage = array();
if (mysql_num_rows($get_news) > 0) {


    while ($news = mysql_fetch_array($get_news)) {
        $tid = $news['tid'];
        $get_stats = mysql_query("SELECT C.cid,C.tid,C.comment AS comments,COUNT(A.LD) "
                . "AS likes,U.username AS username ,C.side AS side,U.uid AS uid"
                . ",COUNT(A.shared)AS shared FROM activity_table AS A "
                . "JOIN comments_table AS C ON A.cid=C.cid,user_table AS U "
                . "WHERE tid='$tid' AND U.uid = C.uid AND A.LD ='1'  GROUP BY C.cid ORDER BY likes DESC limit 1  ");

        $side1 = 0;
        $side2 = 0;
        $stats_query = mysql_query("SELECT reports, uid, MIN(Date) AS Date, side FROM `comments_table` WHERE `tid` = '$tid' AND `reports` < 1 GROUP BY `uid` ORDER BY `side`");
        $total_users = mysql_num_rows($stats_query);
        while ($row = mysql_fetch_array($stats_query)) {
            if ($row['side'] == 1)
                $side1++;
            else
                $side2++;
        }
        if (mysql_num_rows($get_stats) > 0) {
            while ($stats = mysql_fetch_array($get_stats)) {
                $json[] = array('category' => $news['category'], 'tagname' => $news['tagname'], 'users' => $news['users'], 'number' => $news['comments'], 'cid' => $stats['cid'], 'comment' => $stats['comments'], 'uid' => $stats['uid'], 'username' => $stats['username'], 'side' => $stats['side'], 'side1' => $side1, 'side2' => $side2, 'total' => $total_users);
            }
        } else {
         $json[] = array('category' => $news['category'], 'tagname' => $news['tagname'], 'users' => $news['users'], 'number' => $news['comments'], 'side1' => $side1, 'side2' => $side2, 'total' => $total_users);  
        }
    }
}

mysql_close();
echo json_encode($json);
?>

