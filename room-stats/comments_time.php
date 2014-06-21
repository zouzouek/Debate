<?php

include '../config/db.php';
session_start();
if (!isset($_GET['t']))
    header("Location: ../alert/error.php");

$tid = $_GET['t'];

$result = array();

$stats_query = mysql_query("SELECT MONTH(Date) MONTH,
    SUM(side = 1) AS side1,
    SUM(side = 2) AS side2
FROM      `comments_table` 
WHERE     YEAR(Date) = '2014' AND `tid` = '$tid' AND `reports` < 1
GROUP BY  MONTH(Date)");

while ($stats = mysql_fetch_array($stats_query)) {
    $month = $stats['MONTH'];
    $month = convertMonth($month);

    $result[] = array(
        'side1' => $stats['side1'],
        'side2' => $stats['side2'],
        'month' => $month
    );
}

echo json_encode($result);
mysql_close();

function convertMonth($month) {
    switch ($month) {
        case '1':
            $month = "January";
            break;
        case '2':
            $month = "February";
            break;
        case '3':
            $month = "March";
            break;
        case '4':
            $month = "April";
            break;
        case '5':
            $month = "May";
            break;
        case '6':
            $month = "June";
            break;
        case '7':
            $month = "July";
            break;
        case '8':
            $month = "August";
            break;
        case '9':
            $month = "September";
            break;
        case '10':
            $month = "October";
            break;
        case '11':
            $month = "November";
            break;
        case '12':
            $month = "December";
            break;
    }
    return $month;
}
?>

