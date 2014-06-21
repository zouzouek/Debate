<?php

include '../config/db.php';
session_start();

$first = $_POST['first'];
$last = $_POST['last'];
$age = $_POST['age'];
$gender = $_POST['gender'];
$work = $_POST['work'];
$work = str_replace("'", "''", $work);
$country = $_POST['country'];
$country = str_replace("'", "''", $country);
$education = $_POST['education'];
$education = str_replace("'", "''", $education);
$bio = $_POST['biography'];
$bio = str_replace("'", "''", $bio);
$imgsrc=$_POST['hala'];
$imgsrc=str_replace(".", "\.", $imgsrc);


$uid = $_SESSION['id'];
if($imgsrc ==''){
$query = "UPDATE `info_table` 
             SET 
               `firstname`=IF(LENGTH('$first')=0, firstname, '$first'),
               `lastname`=IF(LENGTH('$last')=0, lastname, '$last'),
               `age`=IF(LENGTH('$age')=0, age, '$age'), 
               `gender`=IF(LENGTH('$gender')=0, gender, '$gender'),
               `location`=IF(LENGTH('$country')=0, location, '$country'),
               `work`=IF(LENGTH('$work')=0, work, '$work'), 
               `education`=IF(LENGTH('$education')=0, education, '$education'), 
               `bio`=IF(LENGTH('$bio')=0, bio, '$bio')
           WHERE `uid` = '$uid'";
}
else{
    $query = "UPDATE `info_table` 
             SET 
               `firstname`=IF(LENGTH('$first')=0, firstname, '$first'),
               `lastname`=IF(LENGTH('$last')=0, lastname, '$last'),
               `age`=IF(LENGTH('$age')=0, age, '$age'), 
               `gender`=IF(LENGTH('$gender')=0, gender, '$gender'),
               `location`=IF(LENGTH('$country')=0, location, '$country'),
               `work`=IF(LENGTH('$work')=0, work, '$work'), 
               `education`=IF(LENGTH('$education')=0, education, '$education'), 
               `bio`=IF(LENGTH('$bio')=0, bio, '$bio'),`profilepic`= '$imgsrc'
           WHERE `uid` = '$uid'";
}

$result = mysql_query($query) or die($result . "<br/><br/>" . mysql_error());

mysql_close();
header("Location: ../home.php");
?>
