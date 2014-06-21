<?php

//generate an activation link
function actlink() {
    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 32; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}

echo 'register';
include '../config/db.php';
$email = $_POST['email'];
$username = $_POST['username'];
$password = $_POST['password'];
$result00 = mysql_query("SELECT * FROM user_table WHERE username='$username' || email='$email'");
$row = mysql_fetch_array($result00);

if ($row > 0) {
    $fail = "signup";
    mysql_close();
    header("Location: ../index.php?fail=" . $fail);
} else {
    
    //$actlink = actlink();
    $token = md5(uniqid(rand(), TRUE));
    $query = "INSERT INTO user_table(username, password, email, Rank, Admin, token) VALUES ('$username','$password','$email',1,0,'$token')";

    $link = "<a href=\"http://localhost/debate-local/fillinfo.php?token=$token\">http://localhost/debate-local/fillinfo.php?token=$token</a>";
    $subject = "Debate: Confirmation Email";
    $body = "Welcome " . $username . "!: To activate your link click on the link below" . PHP_EOL . $link . PHP_EOL . "You will be re-directed to fill in your profile information!";

    mail($email, $subject, $body);

    $result = mysql_query($query);


    mysql_close();
    header("Location: ../alert/activate-reminder.php");
}
?>
