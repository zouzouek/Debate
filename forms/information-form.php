<?php

include '../config/db.php';
$first = trim($_POST['first']);
$last = trim($_POST['last']);
$age = $_POST['age'];
$gender = $_POST['gender'];
$country = $_POST['country'];
$country = str_replace("'", "''", $country);
$work = trim($_POST['work']);
$work = str_replace("'", "''", $work);
$education = trim($_POST['education']);
$education = str_replace("'", "''", $education);
$bio = trim($_POST['biography']);
$bio = str_replace("'", "''", $bio);
$imgsrc=$_POST['hala'];
$token = $_POST['token'];


$completequery = "UPDATE `user_table` 
             SET 
               `IsComplete`=1
            WHERE `token` = '$token'";
$completed = mysql_query($completequery);

$userquery = mysql_query("SELECT `uid`, `username` FROM `user_table` WHERE `token`= '$token'");

$user = mysql_fetch_array($userquery) or die($user . "<br/><br/>" . mysql_error());
$uid = $user['uid'];

$query = "INSERT INTO `info_table`(`uid`, `firstname`, `lastname`, `age`, `gender`, `location`, `work`, `education`, `bio`,`profilepic`) VALUES  
   ('$uid','$first','$last','$age','$gender','$country',
                IF(LENGTH('$work')=0, NULL, '$work'),
                    IF(LENGTH('$education')=0, NULL, '$education'),
                        IF(LENGTH('$bio')=0, NULL, '$bio'),'$imgsrc')";
$updatequery = mysql_query($query) or die($updatequery . "<br/><br/>" . header("Location: ../alert/error.php"));
$stat_query = mysql_query("INSERT INTO `user_stat` (`uid`) VALUES ('$uid')");
mysql_close();

session_start();
$_SESSION['username'] = $user['username'];
$_SESSION['id'] = $uid;
$_SESSION['status'] = TRUE;

header("Location: ../home.php");
?>
