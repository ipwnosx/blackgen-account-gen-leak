<?php require 'inc/_global/config.php'; ?>
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

        <!-- Stylesheets -->

<?php require 'inc/_global/views/head_end.php'; ?>
<?php require 'inc/_global/views/page_start.php'; ?>

<!-- Page Content -->
<div class="bg-image" style="background-image: url('<?php echo $dm->assets_folder; ?>/media/photos/photo24@2x.jpg');">
    <div class="hero bg-black-90">
        <div class="hero-inner">
            <div class="content content-full">
                <div class="px-3 py-5 text-center">
                    <div class="mb-3">
                        <a class="link-fx font-w700 font-size-h1" href="index.php">
                            <span class="text-white">Black</span><span class="text-primary">gen</span>
                        </a>
                        <p class="text-uppercase font-w700 font-size-sm text-muted"><i class="fa fa-cog fa-spin"></i> Maintenance <i class="fa fa-cog fa-spin"></i></p>
                    </div>
                    <h1 class="text-white font-w700 mt-5 mb-3">Nous travaillons sur quelques modifications..</h1>
                    <h2 class="h3 text-white-75 font-w400 text-muted mb-5">Ne vous inquiétez pas, nous serons de retour bientôt !</h2>
                    <a class="btn btn-hero-primary mb-3" href="status.php">
                        <i class="fa fa-flask mr-1"></i> Consultez la page d'état des services
                    </a>
                    <br>
                    <a class="btn btn-sm btn-dark" href="home.php">
                        <i class="fa fa-arrow-left mr-1"></i> Actualiser
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END Page Content -->

<?php require 'inc/_global/views/page_end.php'; ?>
<?php require 'inc/_global/views/footer_start.php'; ?>
<?php require 'inc/_global/views/footer_end.php'; ?>
