<?php
ob_start();
    require_once '../../../_global/config.php';

  		if (!$user->LoggedIn() || !$user->notBanned($odb) || empty($_GET['type'])){
  		    die();
  		}
  		$type     = $_GET['type'];
  		$username = $_SESSION['username'];
  		$SQLCount = $odb -> query("SELECT * FROM `plans_free`");
  		$show = $SQLCount -> fetch(PDO::FETCH_ASSOC);
  		$limit = $show['limit'];
  		$accounts = $show['accounts'];
  		$SQLCheck = $odb -> prepare("SELECT COUNT(*) FROM `logs_free` WHERE `username` = ? AND `date` > ?");
  		$SQLCheck -> execute(array($username, strtotime(date('d-m-Y 00:00:00'))));
  		if($SQLCheck -> fetchColumn(0) >= $limit){
  		    die(error('Trop de comptes générés aujourd\'hui à partir de votre compte.'));
  		}
  		$SQLCount = $odb -> prepare("SELECT COUNT(*) FROM `accounts_free` WHERE `type` = ?");
  		$SQLCount -> execute(array($type));
        if($SQLCount -> fetchColumn(0) == 0) {
            die(error('Plus aucun compte n\'est disponible'));
        }
        $SQLGen = $odb -> prepare("SELECT * FROM `accounts_free` WHERE `type` = ? ORDER BY RAND() LIMIT 1");
        $SQLGen -> execute(array($type));
        $info = $SQLGen -> fetch(PDO::FETCH_BOTH);
        $SQLog = $odb -> prepare("INSERT INTO `logs_free` VALUES (NULL, ?, ?, ?, ?, ?, ?, ?)");
        $SQLog -> execute(array($info['email'], $info['password'], $type, $username, time(), 0, 0));	die('success');
  ?>
