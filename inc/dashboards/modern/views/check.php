<?php
$path = $_SERVER['PHP_SELF'];
$file = basename($path);

if(!isset($_SESSION['id'])){
	if (!($user -> LoggedIn()) || !($user -> notBanned($odb))){
	header('Location: ../relogin.php');
	die();
	}
    if ($_SESSION['ID'] != 2){
        unset($dm->main_nav[3]['sub'][2]);
        unset($dm->main_nav[4]['sub'][2]);
        unset($dm->main_nav[6]);
    }
	if ($_SESSION['rank'] > 0){

		if ($_SESSION['rank'] == 2) {
		    unset($dm->main_nav[1]); // Settings
            unset($dm->main_nav[3]); // Générateurs
            unset($dm->main_nav[4]); // Générateurs gratuit
            unset($dm->main_nav[5]); // Notifications
            unset($dm->main_nav[6]); // Notifications
            unset($dm->main_nav[7]); // Utilisateurs
            unset($dm->main_nav[8]); // Paiements
            unset($dm->main_nav[9]); // Boutique
            unset($dm->main_nav[11]); // Partenariat
            //unset($dm->main_nav[11]); // FAQ
            unset($dm->main_nav[13]); // Historique
            unset($dm->main_nav[14]); // Actions
            unset($dm->main_nav[15]); // Actions
            unset($dm->main_nav[16]); // Logins
			switch ($file) {
			    case "home.php":
			        break;
			    case "ticket.php":
			        break;
			    case "tickets.php":
			        break;
				case "logs.php":
			        break;
				case "log_report.php":
			        break;
			    case "index.php":
			        break;
			    default:
			    	header('Location: ../home.php');
			    	die();
			}
		}
        if ($_SESSION['rank'] == 3) {
            unset($dm->main_nav[1]); // Settings
            unset($dm->main_nav[3]); // Générateurs
            unset($dm->main_nav[4]); // Générateurs gratuit
            unset($dm->main_nav[5]); // Notifications
            unset($dm->main_nav[6]); // Notifications
            unset($dm->main_nav[8]); // Paiements
            unset($dm->main_nav[9]); // Boutique
            unset($dm->main_nav[11]); // Partenariat
            //unset($dm->main_nav[11]); // FAQ
            unset($dm->main_nav[13]); // Historique
            unset($dm->main_nav[14]); // Actions
            unset($dm->main_nav[15]); // Actions
            unset($dm->main_nav[16]); // Logins
            switch ($file) {
				case "log_report.php":
			        break;
                case "home.php":
                    break;
                case "ticket.php":
                    break;
                case "tickets.php":
                    break;
                case "logs.php":
                    break;
                case "index.php":
                    break;
                case "users.php":
                    break;
                case "edit_user.php":
                    break;
                default:
                    header('Location: ../home.php');
                    die();
            }
        }
	} else {
		header('Location: ../login.php');
		die();
	}

}

else {
	header('Location: ../login.php');
	die();
}
?>
