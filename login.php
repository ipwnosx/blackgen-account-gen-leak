<?php require 'inc/_global/config.php';
    ob_start();
/*    if (!empty($maintaince)) {
    header('Location: maintenance.php');
    die('Maintenance'. $maintaince);
}*/

    $ip = $user -> realIP();
    if ($user -> LoggedIn()) {
    header('Location: home.php');
    exit;
}
    //User logged in recently?
    if (!empty($_COOKIE['username'])) {
    header('Location: relogin.php');
    exit;
}
    if (!empty($_POST['doLogin'])) {
    $username = $_POST['login-username'];
    $password = $_POST['login-password'];
    $date = strtotime('-1 hour', time());
    $attempts = $odb->query("SELECT COUNT(*) FROM `loginlogs` WHERE `ip` = '$ip' AND `username` LIKE '%failed' AND `date` BETWEEN '$date' AND UNIX_TIMESTAMP()")->fetchColumn(0);
    if ($attempts > 2) {
        $date = strtotime('+1 hour', $waittime = $odb->query("SELECT `date` FROM `loginlogs` WHERE `ip` = '$ip' ORDER BY `date` DESC LIMIT 1")->fetchColumn(0) - time());
        //$error = 'Too many failed attempts. Please wait '.$date.' seconds and try again.';
    }
    if (empty($_POST['g-recaptcha-response']) || empty($username) || empty($password)) {
        $error = "Please complete all fields";
    }
    if (!($user -> captcha($_POST['g-recaptcha-response'], $google_secret))) {
        $error = "The captcha was incorrect.";
    }
    //Check username exists
    $SQLCheckLogin = $odb -> prepare("SELECT COUNT(*) FROM `users` WHERE `username` = :username");
    $SQLCheckLogin -> execute(array(':username' => $username));
    $countLogin = $SQLCheckLogin -> fetchColumn(0);
    if (!($countLogin == 1)) {
        $SQL = $odb -> prepare("INSERT INTO `loginlogs` VALUES(:username, :ip, UNIX_TIMESTAMP(), 'XX')");
        $SQL -> execute(array(':username' => $username." - failed",':ip' => $ip));
        $error = "The username does not exist in our system.";
    }
    // Check if password is corredt
    $SQLCheckLogin = $odb -> prepare("SELECT COUNT(*) FROM `users` WHERE `username` = :username AND `password` = :password");
    $SQLCheckLogin -> execute(array(':username' => $username, ':password' => SHA1(md5($password))));
    $countLogin = $SQLCheckLogin -> fetchColumn(0);
    if (!($countLogin == 1)) {
        $SQL = $odb -> prepare("INSERT INTO `loginlogs` VALUES(:username, :ip, UNIX_TIMESTAMP(), 'XX')");
        $SQL -> execute(array(':username' => $username." - failed",':ip' => $ip));
        $error = 'The password you entered is incorrect';
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
        $error = 'You are banned. Reason : '.htmlspecialchars($ban);
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
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
		<meta name="description" content="Black-Generator your #1 Account generator template">
        <meta name="author" content="Black-Generator">

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
        <!-- Stylesheets -->
<?php require 'inc/_global/views/head_end.php'; ?>

<!-- Page Content -->
<div class="bg-image" style="background-image: url('<?php echo $dm->assets_folder; ?>/media/photos/photo22@2x.jpg');">
    <div class="row no-gutters bg-primary-op">
        <!-- Main Section -->
        <div class="hero-static col-md-6 d-flex align-items-center bg-white">
            <div class="p-3 w-100">
                <!-- Header -->
                <div class="mb-3 text-center">
                    <a class="link-fx font-w700 font-size-h1">
                        <span class="text-dark">Black</span><span class="text-primary">Generator</span>
                    </a>
                    <p class="text-uppercase font-w700 font-size-sm text-muted">Login</p>
                </div>
                <!-- END Header -->

                <!-- Sign In Form -->
                <!-- jQuery Validation (.js-validation-signin class is initialized in js/pages/op_auth_signin.min.js which was auto compiled from _es6/pages/op_auth_signin.js) -->
                <!-- For more info and examples you can check out https://github.com/jzaefferer/jquery-validation -->
                <div class="row no-gutters justify-content-center">

                    <div class="col-sm-8 col-xl-6">
                      <?php
                      if (!empty($error)) {
                          echo '<div class="animated fadeIn">'.error($error).'</div>';
                      }
                      if (isset($_SESSION['success'])) {
                          echo '<div class="animated fadeIn">'.success($_SESSION['success']).'</div>';
                          unset($_SESSION['success']);
                      }
                      if (!empty($maintaince)) {
                          echo '<div class="alert alert-danger" style="text-align: center"><a href="maintenance.php"><strong>A maintenance is in progress</strong></a></div>';
                      }

                      ?>
                        <form class="js-validation-signin" method="post">
                            <div class="py-3">
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-lg form-control-alt" id="login-username" name="login-username" placeholder="Username">
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-lg form-control-alt" id="login-password" name="login-password" placeholder="Password">
                                </div>
                                <div class="col-xs-12" style="text-align:center">
                                    <div style='display: inline-block;' class="g-recaptcha" data-sitekey=<?php echo $google_site; ?>></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" name="doLogin" value="login" value="create" class="btn btn-block btn-hero-lg btn-hero-primary">
                                    <i class="fa fa-fw fa-sign-in-alt mr-1"></i> Login
                                </button>
                                    <a class="btn btn-block btn-hero-lg btn-hero-primary" href="register.php">
                                        <i class="fa fa-plus mr-1"></i> Register
                                    </a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- END Sign In Form -->
            </div>
        </div>
        <!-- END Main Section -->

        <!-- Meta Info Section -->
        <div class="hero-static col-md-6 d-none d-md-flex align-items-md-center justify-content-md-center text-md-center">
            <div class="p-3">
                <p class="display-4 font-w700 text-white mb-3">
                    Welcome to Black-Generator your #1 Account generator Template
                </p>
                <p class="font-size-lg font-w600 text-white-75 mb-0">
                    Copyright &copy; <span class="js-year-copy">2019</span>
                </p>
            </div>
        </div>
        <!-- END Meta Info Section -->
    </div>
</div>
<!-- END Page Content -->

<?php require 'inc/_global/views/page_end.php'; ?>
<?php require 'inc/_global/views/footer_start.php'; ?>

<!-- Page JS Plugins -->
<?php $dm->get_js('js/plugins/jquery-validation/jquery.validate.min.js'); ?>

<!-- Page JS Code -->
<?php $dm->get_js('js/pages/op_auth_signin.min.js'); ?>

<?php require 'inc/_global/views/footer_end.php'; ?>
