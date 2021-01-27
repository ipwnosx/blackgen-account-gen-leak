<?php
require 'inc/_global/config.php';
ob_start();
/*if (!(empty($maintaince))) {
header('Location: maintenance.php');
exit;
}*/
if ($user -> LoggedIn()) {
header('Location: home.php');
exit;
}
//User logged in recently?
if (empty($_COOKIE['username'])) {
header('Location: login.php');
exit;
}
if (!empty($_POST['doLogin'])) {
if (empty($_POST['g-recaptcha-response']) || empty($_POST['login-password'])) {
    $error = "Veuillez remplir tous les champs";
}
if (!($user -> captcha($_POST['g-recaptcha-response'], $google_secret))) {
    $error = "Le captcha est incorrect.";
}
$username = $_COOKIE['username'];
$password = $_POST['login-password'];
$date = strtotime('-1 hour', time());
$attempts = $odb->query("SELECT COUNT(*) FROM `loginlogs` WHERE `ip` = '$ip' AND `username` LIKE '%failed' AND `date` BETWEEN '$date' AND UNIX_TIMESTAMP()")->fetchColumn(0);
if ($attempts > 2) {
    $date = strtotime('+1 hour', $waittime = $odb->query("SELECT `date` FROM `loginlogs` WHERE `ip` = '$ip' ORDER BY `date` DESC LIMIT 1")->fetchColumn(0) - time());
    //$error = 'Too many failed attempts. Please wait '.$date.' seconds and try again.';
}
//Check username exists
$SQLCheckLogin = $odb -> prepare("SELECT COUNT(*) FROM `users` WHERE `username` = :username");
$SQLCheckLogin -> execute(array(':username' => $username));
$countLogin = $SQLCheckLogin -> fetchColumn(0);
if (!($countLogin == 1)) {
    $SQL = $odb -> prepare("INSERT INTO `loginlogs` VALUES(:username, :ip, UNIX_TIMESTAMP(), 'XX')");
    $SQL -> execute(array(':username' => $username." - failed",':ip' => $ip));
    $error = "Le nom d'utilisateur n'existe pas dans notre système.";
}
// Check if password is corredt
$SQLCheckLogin = $odb -> prepare("SELECT COUNT(*) FROM `users` WHERE `username` = :username AND `password` = :password");
$SQLCheckLogin -> execute(array(':username' => $username, ':password' => SHA1(md5($password))));
$countLogin = $SQLCheckLogin -> fetchColumn(0);
if (!($countLogin == 1)) {
    $SQL = $odb -> prepare("INSERT INTO `loginlogs` VALUES(:username, :ip, UNIX_TIMESTAMP(), 'XX')");
    $SQL -> execute(array(':username' => $username." - failed",':ip' => $ip));
    $error = 'Le mot de passe que vous avez entré est incorrect';
}
//Check if the user is banned
$SQL = $odb -> prepare("SELECT `status` FROM `users` WHERE `username` = :username");
$SQL -> execute(array(':username' => $username));
$status = $SQL -> fetchColumn(0);
if ($status == 1) {
    $ban = $odb -> query("SELECT `reason` FROM `bans` WHERE `username` = '$username'") -> fetchColumn(0);
    if (empty($ban)) {
        $ban = "BAN.";
    }
    $error = 'Vous êtes banni. Raison : '.htmlspecialchars($ban);
}
//Insert login log and log in
if (empty($error)) {
    $SQL = $odb -> prepare("SELECT * FROM `users` WHERE `username` = :username");
    $SQL -> execute(array(':username' => $username));
    $userInfo = $SQL -> fetch();
    $ipcountry = json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip)) -> {'geoplugin_countryName'};
    if (empty($ipcountry)) {
        $ipcountry = 'XX';
    }
    $SQL = $odb -> prepare('INSERT INTO `loginlogs` VALUES(:username, :ip, UNIX_TIMESTAMP(), :ipcountry)');
    $SQL -> execute(array(':ip' => $ip, ':username' => $username, ':ipcountry' => $ipcountry));
    $_SESSION['username'] = $userInfo['username'];
    $_SESSION['ID'] = $userInfo['ID'];
    $_SESSION['rank'] = $userInfo['rank'];
    setcookie("username", $userInfo['username'], time() + 720000);
    header('Location: home.php');
    exit;
}
}
?>
<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

        <title><?php echo $dm->title; ?></title>

        <meta name="description" content="<?php echo $dm->description; ?>">
        <meta name="author" content="<?php echo $dm->author; ?>">
        <meta name="robots" content="<?php echo $dm->robots; ?>">

        <!-- Open Graph Meta -->
        <meta property="og:title" content="<?php echo $dm->title; ?>">
        <meta property="og:site_name" content="<?php echo $dm->name; ?>">
        <meta property="og:description" content="<?php echo $dm->description; ?>">
        <meta property="og:type" content="website">
        <meta property="og:url" content="<?php echo $dm->og_url_site; ?>">
        <meta property="og:image" content="<?php echo $dm->og_url_image; ?>">

        <!-- Icons -->
        <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
        <link rel="shortcut icon" href="<?php echo $dm->assets_folder; ?>/media/favicons/favicon.png">
        <link rel="icon" type="image/png" sizes="192x192" href="<?php echo $dm->assets_folder; ?>/media/favicons/favicon-192x192.png">
        <link rel="apple-touch-icon" sizes="180x180" href="<?php echo $dm->assets_folder; ?>/media/favicons/apple-touch-icon-180x180.png">
        <!-- END Icons -->
        <script src='https://www.google.com/recaptcha/api.js'></script>
		<!--Google AdSens -->
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
  (adsbygoogle = window.adsbygoogle || []).push({
    google_ad_client: "ca-pub-1385406617572117",
    enable_page_level_ads: true
  });
</script>
        <!-- Stylesheets -->

<?php require 'inc/_global/views/head_end.php'; ?>
<?php require 'inc/_global/views/page_start.php'; ?>

<!-- Page Content -->
<!-- jQuery Vide for video backgrounds, for more examples you can check out https://github.com/VodkaBears/Vide -->
<div class="bg-video" data-vide-bg="<?php echo $dm->assets_folder; ?>/media/videos/city_night" data-vide-options="posterType: jpg">
    <div class="row no-gutters bg-danger-op">
        <!-- Meta Info Section -->
        <div class="hero-static col-md-6 d-none d-md-flex align-items-md-center justify-content-md-center text-md-center">
            <div class="p-3">
                <p class="display-4 font-w700 text-white mb-0">
                    Plus qu'un simple générateur
                </p>
                <p class="font-size-h1 font-w600 text-white-75 mb-0">
                    ..une révolution
                </p>
            </div>
        </div>
        <!-- END Meta Info Section -->

        <!-- Main Section -->
        <div class="hero-static col-md-6 d-flex align-items-center bg-white">
            <div class="p-3 w-100">
                <!-- Header -->
                <div class="text-center">
                    <a class="link-fx text-danger font-w700 font-size-h1" href="index.php">
                        <span class="text-dark">Black</span><span class="text-danger">gen</span>
                    </a>
                    <p class="text-uppercase font-w700 font-size-sm text-muted">Écran de verrouillage</p>
                </div>
                <!-- END Header -->

                <!-- User -->
                <div class="py-4 text-center">
                    <?php $dm->get_avatar(10, '', 96); ?>
                    <p class="mt-3 mb-0 font-w600 font-size-lg">
                        <?=$_COOKIE['username'];?>
                    </p>
                </div>
                <!-- END User -->

                <!-- Unlock Form -->
                <!-- jQuery Validation (.js-validation-lock class is initialized in js/pages/op_auth_lock.min.js which was auto compiled from _es6/pages/op_auth_lock.js) -->
                <!-- For more info and examples you can check out https://github.com/jzaefferer/jquery-validation -->
                <div class="row no-gutters justify-content-center">
                    <div class="col-sm-8 col-xl-6">
                      <?php
                      if (!empty($error)) {
                          echo '<div class="animated fadeIn">'.error($error).'</div>';
                      }
                      ?>
                        <form class="js-validation-lock" method="post">
                            <div class="form-group py-3">
                                <input type="password" class="form-control form-control-lg form-control-alt" id="lock-password" name="login-password" placeholder="Mot de passe..">
                            </div>
                            <div class="col-xs-12" style="text-align:center;padding-bottom:20px">
                                <div style='display: inline-block;' class="g-recaptcha" data-sitekey=<?php echo $google_site; ?>></div>
                            </div>
                            <div class="form-group text-center">
                                <button name="doLogin" value="login" type="submit" class="btn btn-block btn-hero-lg btn-hero-danger">
                                    <i class="fa fa-fw fa-lock-open mr-1"></i> Déverouiller
                                </button>
                                <p class="mt-3 mb-0 d-lg-flex justify-content-lg-between">
                                    <!--<a class="btn btn-sm btn-light d-block d-lg-inline-block mb-1" href="reminder.php">
                                        <i class="fa fa-exclamation-triangle text-muted mr-1"></i> Mot de passe oublié
                                    </a>-->
                                    <a class="btn btn-sm btn-light d-block d-lg-inline-block mb-1" href="logout.php">
                                        <i class="fa fa-sign-out-alt text-muted mr-1"></i> Déconnexion
                                    </a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- END Unlock Form -->
            </div>
        </div>
        <!-- END Main Section -->
    </div>
</div>
<!-- END Page Content -->

<?php require 'inc/_global/views/page_end.php'; ?>
<?php require 'inc/_global/views/footer_start.php'; ?>

<!-- Page JS Plugins -->
<?php $dm->get_js('js/plugins/vide/jquery.vide.min.js'); ?>
<?php $dm->get_js('js/plugins/jquery-validation/jquery.validate.min.js'); ?>

<!-- Page JS Code -->
<?php $dm->get_js('js/pages/op_auth_lock.min.js'); ?>

<?php require 'inc/_global/views/footer_end.php'; ?>
