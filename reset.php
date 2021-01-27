<?php require 'inc/_global/config.php';
ob_start();
if ($user -> LoggedIn()) {
    header('Location: home.php');
    exit;
}
if (isset($_GET['code'])){
    $code = htmlspecialchars($_GET['code']);

    $rUser = $odb->prepare('SELECT * FROM reminder WHERE code = ? AND used = 0');
    $rUser->execute(array($code));

    $rowUser = $rUser->rowCount();
    if ($rowUser == 1){
        $rUser = $rUser->fetch();

    } else {
        header('Location: index.php');
        die();
    }
} else {
    header('Location: index.php');
    die();
}

if (isset($_POST['reminder'])){
    $code = htmlspecialchars($_POST['code1']);

    $rUser = $odb->prepare('SELECT * FROM reminder WHERE code = ? AND used = 0');
    $rUser->execute(array($code));

    $rowUser = $rUser->rowCount();
    if ($rowUser == 1){
        $rUser = $rUser->fetch();
    } else {
        header('Location: index.php');
        die();
    }

    $password = SHA1(md5($_POST['reminder-password']));

    $cPassword = $odb->prepare('UPDATE users SET password = ? WHERE ID = ?');
    $cPassword->execute(array($password,$rUser['id_member']));
    $sReminder = $odb->prepare('UPDATE reminder SET used = 1 WHERE id_member = ?');
    $sReminder->execute(array($rUser['id_member']));
    $_SESSION['success'] = "Mot de passe modifié avec succès !";
    header('Location: login.php');



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
    <!-- Stylesheets -->

    <?php require 'inc/_global/views/head_end.php'; ?>
    <?php require 'inc/_global/views/page_start.php'; ?>

    <!-- Page Content -->
    <div class="bg-image" style="background-image: url('<?php echo $dm->assets_folder; ?>/media/photos/photo19@2x.jpg');">

    <!-- Page Content -->
    <div class="row no-gutters justify-content-center bg-body-dark">
        <div class="hero-static col-sm-10 col-md-8 col-xl-6 d-flex align-items-center p-2 px-sm-0">
            <!-- Reminder Block -->
            <div class="block block-rounded block-transparent block-fx-pop w-100 mb-0 overflow-hidden bg-image" style="background-image: url('<?php echo $dm->assets_folder; ?>/media/photos/photo19.jpg');">
                <div class="row no-gutters">
                    <div class="col-md-6 order-md-1 bg-white">
                        <div class="block-content block-content-full px-lg-5 py-md-5 py-lg-6">
                            <!-- Header -->
                            <div class="mb-2 text-center">
                                <a class="link-fx text-warning font-w700 font-size-h1" href="index.php">
                                    <span class="text-dark">Black</span><span class="text-warning">gen</span>
                                </a>
                                <p class="text-uppercase font-w700 font-size-sm text-muted">Nouveau mot de passe</p>
                            </div>
                            <!-- END Header -->

                            <!-- Reminder Form -->
                            <!-- jQuery Validation (.js-validation-reminder class is initialized in js/pages/op_auth_reminder.min.js which was auto compiled from _es6/pages/op_auth_reminder.js) -->
                            <!-- For more info and examples you can check out https://github.com/jzaefferer/jquery-validation -->
                            <form class="js-validation-reminder" method="POST">
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-alt" id="reminder-password" name="reminder-password" placeholder="nouveau mot de passe">
                                    <input type="hidden" name="code1" value="<?=$_GET['code']?>">
                                </div>
                                <div class="form-group text-center">
                                    <button type="submit" class="btn btn-block btn-hero-warning" name="reminder">
                                        <i class="fa fa-fw fa-reply mr-1"></i> Mettre à jour le mot de passe
                                    </button>
                                </div>
                            </form>
                            <!-- END Reminder Form -->
                        </div>
                    </div>
                    <div class="col-md-6 order-md-0 bg-gd-sun-op d-flex align-items-center">
                        <div class="block-content block-content-full px-lg-5 py-md-5 py-lg-6 text-center">
                            <p class="font-size-h2 font-w700 text-white mb-0">
                            </p>
                            <p class="font-size-h3 font-w600 text-white-75 mb-0">

                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END Reminder Block -->
        </div>
    </div>
    <!-- END Page Content -->

<?php require 'inc/_global/views/page_end.php'; ?>
<?php require 'inc/_global/views/footer_start.php'; ?>

    <!-- Page JS Plugins -->
<?php $dm->get_js('js/plugins/jquery-validation/jquery.validate.min.js'); ?>

    <!-- Page JS Code -->
<?php $dm->get_js('js/pages/op_auth_reminder.min.js'); ?>

<?php require 'inc/_global/views/footer_end.php'; ?>
