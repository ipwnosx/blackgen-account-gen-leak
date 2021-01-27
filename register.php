<?php
    require 'inc/_global/config.php';
    ob_start();
    if (!(empty($maintaince))) {
    die($maintaince);
}
    if ($user -> LoggedIn()) {
    header('Location: home.php');
}
    //User logged in recently?
    if (!empty($_COOKIE['username'])) {
    header('Location: relogin.php');
    exit;
}
    if (!empty($_POST['doCreate'])) {
    $username = $_POST['signup-username'];
    $email = $_POST['signup-email'];
    $password = $_POST['signup-password'];
    $rpassword = $_POST['signup-password-confirm'];
    if (empty($_POST['g-recaptcha-response']) || empty($username) || empty($email) || empty($password) || empty($rpassword)) {
        $error = "Please complete all fields";
    }
    if (!($user -> captcha($_POST['g-recaptcha-response'], $google_secret))) {
        $error = "The captcha was incorrect.";
    }
    //Check if the username is legit
    if (!ctype_alnum($username) || strlen($username) < 4 || strlen($username) > 15) {
        $error = 'Username must be  alphanumberic and 4-15 characters in length';
    }
    //Check referral
    $referral='0';
    //Check if user is available
    $SQL = $odb -> prepare("SELECT COUNT(*) FROM `users` WHERE `username` = :username");
    $SQL -> execute(array(':username' => $username));
    $countUser = $SQL -> fetchColumn(0);
    if ($countUser > 0) {
        $error = 'Already existing user';
    }
    //Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email address';
    }
    //Compare first to second password
    if ($password != $rpassword) {
        $error = 'Passwords do not match';
    }
    //Check if email already exists



    $SQL = $odb->prepare("SELECT COUNT(*) FROM `users` WHERE `email` = :email");
    $SQL->execute(array(':email' => $email));
    $EmailCount = $SQL->fetchColumn(0);
    if ($EmailCount > 0) {
        $error = 'This email is already used';
    }
    //Make registeration
    if (empty($error)) {
        $insertUser = $odb -> prepare("INSERT INTO `users` VALUES(NULL, :username, :password, :email, 0, 0, 0, 0, :referral, 0, 0, 0,0,0)");
        $insertUser -> execute(array(':username' => $username, ':password' => SHA1(md5($password)), ':email' => $email, ':referral' => $referral));
        $_SESSION['success'] = "You have successfully created your account.";
        header('Location: login.php');
    }
}
?>

<!doctype html>
<html lang="en">
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
<div class="bg-image" style="background-image: url('<?php echo $dm->assets_folder; ?>/media/photos/photo12@2x.jpg');">
    <div class="row no-gutters justify-content-center bg-black-75">
        <!-- Main Section -->
        <div class="hero-static col-md-6 d-flex align-items-center bg-white">
            <div class="p-3 w-100">
                <!-- Header -->
                <div class="mb-3 text-center">
                    <a class="link-fx text-success font-w700 font-size-h1" href="index.php">
                        <span class="text-dark">Black</span><span class="text-success">Generator</span>
                    </a>
                    <p class="text-uppercase font-w700 font-size-sm text-muted">Creating a new account</p>
                </div>
                <!-- END Header -->

                <!-- Sign Up Form -->
                <!-- jQuery Validation (.js-validation-signup class is initialized in js/pages/op_auth_signup.min.js which was auto compiled from _es6/pages/op_auth_signup.js) -->
                <!-- For more info and examples you can check out https://github.com/jzaefferer/jquery-validation -->
                <div class="row no-gutters justify-content-center">
                    <div class="col-sm-8 col-xl-6">
                        <form class="js-validation-signup" method="post">
                          <?php
                          if (!empty($error)) {
                              echo '<div class="animated fadeIn">'.error($error).'</div>';
                          }
                          ?>
                            <div class="py-3">
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-lg form-control-alt" id="signup-username" name="signup-username" placeholder="Username">
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-lg form-control-alt" id="signup-email" name="signup-email" placeholder="Email">
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-lg form-control-alt" id="signup-password" name="signup-password" placeholder="Password">
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-lg form-control-alt" id="signup-password-confirm" name="signup-password-confirm" placeholder="Confirm Password">
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox custom-control-primary">
                                        <input type="checkbox" class="custom-control-input" id="signup-terms" name="signup-terms">
                                        <label class="custom-control-label" for="signup-terms">I have read and accept the rules</label>
                                    </div>
                                </div>
                                <div class="col-xs-12" style="text-align:center">
                                    <div style='display: inline-block;' class="g-recaptcha" data-sitekey=<?php echo $google_site; ?>></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" name="doCreate" value="create" class="btn btn-block btn-hero-lg btn-hero-success">
                                    <i class="fa fa-fw fa-plus mr-1"></i> Register
                                </button>
                                <p class="mt-3 mb-0 d-lg-flex justify-content-lg-between">
                                    <a class="btn btn-sm btn-light d-block d-lg-inline-block mb-1" href="login.php">
                                        <i class="fa fa-sign-in-alt text-muted mr-1"></i> Login
                                    </a>
                                    <a class="btn btn-sm btn-light d-block d-lg-inline-block mb-1" href="#" data-toggle="modal" data-target="#modal-terms">
                                        <i class="fa fa-book text-muted mr-1"></i> Read the rules
                                    </a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- END Sign Up Form -->
            </div>
        </div>
        <!-- END Main Section -->
    </div>
</div>
<!-- END Page Content -->

<?php require 'inc/_global/views/page_end.php'; ?>

<!-- Terms Modal -->
<div class="modal fade" id="modal-terms" tabindex="-1" role="dialog" aria-labelledby="modal-terms" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="block block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title">Conditions of use</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content">
                  <p>1.) rule number one.</p>
                  <p>2.) rule number two.</p>
                  <p>3.) rule number three.</p>
                  <p>4.) rule number four.</p>
                  <p>5.) rule number five.</p>
				  <p>6.) rule number six.</p>
				  <p>7.) rule number seven.</p>
				  <p>8.) rule number eight.</p>

                </div>
                <div class="block-content block-content-full text-right bg-light">
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END Terms Modal -->

<?php require 'inc/_global/views/footer_start.php'; ?>

<!-- Page JS Plugins -->
<?php $dm->get_js('js/plugins/jquery-validation/jquery.validate.min.js'); ?>

<!-- Page JS Code -->
<?php $dm->get_js('js/pages/op_auth_signup.min.js'); ?>

<?php require 'inc/_global/views/footer_end.php'; ?>
