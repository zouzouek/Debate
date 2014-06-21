<?php

include '../config/db.php';

echo "working";
$username = $_POST['username'];
$password = $_POST['password'];
$result00 = mysql_query("SELECT * FROM user_table WHERE username='$username' && password='$password'");
$row = mysql_fetch_array($result00);
#echo $row;

if ($row > 0) {
    if ($row['IsApproved'] && $row['IsComplete']) {
        session_start();
    
        $_SESSION['username'] = $username;
        $_SESSION['id'] = $row['uid'];
        $_SESSION['status'] = TRUE;
        mysql_close();
        echo 'success';
        header("Location: ../home.php");
    } else if (!$row['IsApproved']) {
        mysql_close();
        echo 'not activated';
        header("Location: ../alert/activate-reminder.php");
    } else if ($row['IsApproved'] && !$row['IsComplete']) {
        $token = $row['token'];
        mysql_close();
        echo 'not complete';
        header("Location: ../fillinfo.php?token=". $token);
    }
} else {
    echo "false";
    $fail = "login";
    mysql_close();
    header("Location: ../index.php?fail=" . $fail);
}
?>
