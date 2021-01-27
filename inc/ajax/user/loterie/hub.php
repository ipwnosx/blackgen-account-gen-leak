<?php
ob_start();
    require_once '../../../_global/config.php';

  		if (!$user->LoggedIn() || !$user->notBanned($odb) || empty($_GET['type'])){
  		    die();
  		}
  		/*
  		 * TYPE 1 : Génération
		+ 1 Générations  >> 60%
		+ 3 Générations >> 16%
		+ 5 Générations >> 10%
		+ 10 Générations >> 5%
		+ 15 générations >> 3%

  		* TYPE 2 : Grade
		x1 Grade Basique >> 4%
  		x1 Grade VIP >> 2%
  		x 1 Grade Legende >> 1%
  		*/
  		$username = $_SESSION['username'];
  		$limit = 1;
  		$SQLCheck = $odb -> prepare("SELECT COUNT(*) FROM `logs_loterie` WHERE `username` = ? AND `date` > ?");
  		$SQLCheck -> execute(array($username, strtotime(date('d-m-Y 00:00:00'))));
  		if($SQLCheck -> fetchColumn(0) >= $limit){
  		    die(error('Vous avez déjà participé aujourd\'hui, revenez demain !'));
  		}
		$lot = random_int(0,99);
		$rLot = $odb->prepare('SELECT * FROM lots WHERE pourcentage <= ? LIMIT 1');
		$rLot->execute(array($lot));
		$rLot = $rLot->fetch();
		if ($rLot['type'] == 1){
			$used = 0;
			if ($rLot['id_lot'] == 1) {
				$nbGen = 1;
			} elseif ($rLot['id_lot'] == 2) {
				$nbGen = 3;
			} elseif ($rLot['id_lot'] == 3) {
				$nbGen = 5;
			} elseif ($rLot['id_lot'] == 4) {
				$nbGen = 10;
			} elseif ($rLot['id_lot'] == 5) {
				$nbGen = 15;
			}
		} else if ($rLot['type'] == 2) {
			if ($rLot['id_lot'] == 6) {
				$planID = 21;
			} elseif ($rLot['id_lot'] == 7) {
				$planID = 22;
			} elseif ($rLot['id_lot'] == 8) {
				$planID = 35;
			}
			$SQL = $odb -> prepare("SELECT * FROM `plans` WHERE `ID` = :id");
			$SQL -> execute(array(':id' => $planID));
			$plan = $SQL -> fetch();
			$unit = $plan['unit'];
			$length = $plan['length'];
			$newExpire = strtotime("+{$length} {$unit}");
			$updateSQL = $odb -> prepare("UPDATE `users` SET `expire` = :expire, `membership` = :plan WHERE `username` = :username");
			$updateSQL -> execute(array(':expire' => $newExpire, ':plan' => $planID, ':username' => $username));
			$used = 1;
			$nbGen = 0;
		}
        $SQLog = $odb -> prepare("INSERT INTO `logs_loterie` VALUES (NULL, ?, ?, ?, ?, ?, ?)");
        $SQLog -> execute(array($username, $rLot['id_lot'], time(), $used, $nbGen, $nbGen));


        die(success('You just won '.$rLot['nom'].', well done! '));


  ?>
