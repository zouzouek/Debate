<?php

include '../config/db.php';

session_start();

$roomname = $_POST['roomname'];
$cat = $_POST['cat'];
$side = $_POST['side'];
$comment = $_POST['comment'];
$comment = str_replace("'", "''", $comment);

$uid = $_SESSION['id'];

$get_tags = mysql_query("SELECT * FROM `tag_table` WHERE LOWER(`tagname`) = LOWER('$roomname') && `category` = '$cat'") or die(mysql_error());

$tag_rows = mysql_fetch_array($get_tags);

if ($tag_rows > 0) { //if tag + category exists, identical
    $tid = $tag_rows['tid']; 

    $insert_comment = mysql_query("INSERT INTO `comments_table`(`uid`, `tid`, `comment`, `side`, `reports`) 
                VALUES ('$uid','$tid','$comment','$side',0)") or die(mysql_error());
    $cid = mysql_insert_id() or die(mysql_error());

    $update_stat = mysql_query("UPDATE `user_stat` SET `posts` = CASE WHEN `posts` IS NULL THEN 1 ELSE (`posts` + 1) END 
            WHERE `uid` = $uid");
    $tagname = substr($roomname, 1);
    //header("Location: room.php?cat=$cat&tag=$tagname");
    
     //check mentions and add update stats ONCE ONLY
  //   mysql_query("UPDATE `user_stat` SET `mentioned` = CASE WHEN `mentioned` IS NULL THEN 1 ELSE (`mentioned` + 1) END 
      //      WHERE `uid` = $uid");*/

    echo 'identical tag';
} else { //new tag = new category
    //echo 'new tag';
    $insert_tag = mysql_query("INSERT INTO `tag_table`(`tagname`, `uid`, `category`) 
                VALUES ('$roomname','$uid','$cat')");
    $tid = mysql_insert_id(); //get the last inserted id

    $insert_comment = mysql_query("INSERT INTO `comments_table`(`uid`, `tid`, `comment`, `side`, `reports`) 
                VALUES ('$uid','$tid','$comment','$side',0)");

    $cid = mysql_insert_id();

   // $insert_activity = mysql_query("INSERT INTO `activity_table`(`cid`, `uid`)
               // VALUES ('$cid','$uid')");

    $update_stat = mysql_query("UPDATE `user_stat` SET `posts` = CASE WHEN `posts` IS NULL THEN 1 ELSE (`posts` + 1) END 
            WHERE `uid` = $uid");
    $tagname = substr($roomname, 1);
    //header("Location: room.php?cat=$cat&tag=$tagname");
    echo "new tag";
}
mysql_close();
?>
