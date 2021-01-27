<?php
session_start();
unset($_SESSION['username']);
unset($_SESSION['ID']);
setcookie('username','',time());
session_destroy();
header('location: login.php');
?>
