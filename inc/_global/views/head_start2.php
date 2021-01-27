<?php
/**
 * head_start.php
 *
 * Author: pixelcave
 *
 * The first block of code used in every page of the template
 *
 */

if (basename($_SERVER['SCRIPT_FILENAME']) == basename(__FILE__)) die("Access refusé");
ob_start();

if (!$user->LoggedIn() || !$user->notBanned($odb))
	{
	$lien = dirname($_SERVER['SCRIPT_NAME']);
	$lien = str_replace("/v.3.1/","",$lien);
	if ($lien == "admin") {
		header('Location: ../relogin.php');
	}else {
		header('Location: relogin.php');
	}
	die('Meant to be redirected to the login page');
	}
if (isset($_SESSION['username'])) {
	$SQL = $odb->prepare("SELECT `membership` FROM `users` WHERE `ID` = ?");
	$SQL->execute(array($_SESSION['ID']));
	$gradenum = $SQL->fetch();
	$_SESSION['grade'] = $gradenum['membership'];
}
if (isset($_SESSION['username'])) {
	$rSession = $odb->prepare('SELECT * FROM users WHERE username = ?');
	$rSession->execute(array($_SESSION['username']));
	$rSession = $rSession->fetch();
    $_SESSION['rank'] = $rSession['rank'];
}
if (!empty($maintaince))
{
    if ($_SESSION['rank'] > 0){
        $msg_maintenance = true;
    } else {
        $lien = dirname($_SERVER['SCRIPT_NAME']);
        if ($lien == "/v.3.1/admin") {
            header('Location: ../maintenance.php');
            die('Maintenance' . $maintaince);
        } else {
            header('Location: maintenance.php');
            die('Maintenance' . $maintaince);
        }

    }

} else {
    $msg_maintenance = false;
}


$recupallnotif = $odb->prepare('SELECT * FROM allnotifications WHERE target = ? OR target = ?');
$recupallnotif->execute(array("all",$_SESSION['ID']));

foreach ($recupallnotif as $recupallnotif) {

	if ($recupallnotif['target'] != "all") {
		if ($recupallnotif['target'] == $_SESSION['ID']) {
			$checkNotif = $odb->prepare('SELECT * FROM notif WHERE id_notif = ?');
			$checkNotif->execute(array($recupallnotif['id']));
			$rowcNotif = $checkNotif->rowCount();
			if($rowcNotif != 1)
			{
				$insertNotif = $odb->prepare('INSERT INTO notif(id_notif,id_member,view) VALUES(?,?,?)');
				$insertNotif->execute(array($recupallnotif['id'],$_SESSION['ID'],0));
			}
		}
	}
	elseif ($recupallnotif['target'] == "all") {
		$checkNotif = $odb->prepare('SELECT * FROM notif WHERE id_notif = ? AND id_member = ?');
		$checkNotif->execute(array($recupallnotif['id'],$_SESSION['ID']));
		$rowcNotif = $checkNotif->rowCount();
		if($rowcNotif != 1)
		{
			$insertNotif = $odb->prepare('INSERT INTO notif(id_notif,id_member,view) VALUES(?,?,?)');
			$insertNotif->execute(array($recupallnotif['id'],$_SESSION['ID'],0));
		}
	}

}
$lien = dirname($_SERVER['SCRIPT_NAME']);
if ($lien != "/v.3.1/admin") {
    if ($_SESSION['rank'] == 0){
        unset($dm->main_nav[21]);
        unset($dm->main_nav[22]);
    }
    if ($gen_free == 0){
        unset($dm->main_nav[8]);
        unset($dm->main_nav[9]);
        unset($dm->main_nav[10]);
        unset($dm->main_nav[11]);
    }
}

?>
