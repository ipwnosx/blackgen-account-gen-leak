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
<div class="hero-static bg-white">
    <div class="content content-full">
        <div class="px-3 py-5">
            <div class="mb-5 text-center">
                <a class="link-fx font-w700 font-size-h1" href="index.php">
                    <span class="text-dark">Black</span><span class="text-primary">Generator</span>
                </a>
                <p class="text-uppercase font-w700 font-size-sm text-muted">Status of services</p>
            </div>
            <div class="row no-gutters d-flex justify-content-center">
                <div class="col-md-6 col-xl-4">
                    <div class="d-flex justify-content-between">
                        <a class="btn btn-hero-sm btn-hero-secondary" href="home.php">
                            <i class="fa fa-arrow-left mr-1"></i> Home
                        </a>
                    </div>
                    <hr>
                    <!-- <div class="alert alert-danger d-flex align-items-center justify-content-between" role="alert">
                        <div class="flex-fill mr-3">
                            <p class="mb-0"></p>
                        </div>
                        <div class="flex-00-auto">
                            <i class="fa fa-fw fa-2x fa-bug"></i>
                        </div>
                    </div> -->
                    <ul class="list-group push">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Backend
                            <span class="badge badge-pill badge-success">Functional</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Frontend
                            <span class="badge badge-pill badge-success">Functional</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            payments
                            <span class="badge badge-pill badge-success">Functional</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Supports
                            <span class="badge badge-pill badge-success">Functional</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Discord
                            <span class="badge badge-pill badge-success">Functional</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END Page Content -->

<?php require 'inc/_global/views/page_end.php'; ?>
<?php require 'inc/_global/views/footer_start.php'; ?>
<?php require 'inc/_global/views/footer_end.php'; ?>
