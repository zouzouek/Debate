<?php

session_start();
$_SESSION['status'] = FALSE;
session_destroy();
header("Location:index.php");
?>
