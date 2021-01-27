<?php
if (!isset($_SERVER['HTTP_REFERER'])){
  die;
}
ob_start();

	require_once '../../../_global/config.php';

  if (!($user -> LoggedIn()) || !($user -> notBanned($odb)) || !($user->isAdmin($odb))){
    die();
  }
  $username = $_GET['username'];
  if(empty($username)){
    die();	}
    $update = $odb->prepare("UPDATE `users` SET `activity` = :time WHERE `username` = :username");
    $update->execute(array(':time' => time(), ':username' => $username));?>
