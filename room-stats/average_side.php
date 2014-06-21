<?php

include '../config/db.php';
include '../fetch/getAverage.php';
session_start();
if (!isset($_GET['t']))
    header("Location: ../alert/error.php");


$tid = $_GET['t'];


$result=  getAverage($tid);
echo json_encode($result);

mysql_close();
?>
