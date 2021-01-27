<?php require 'inc/_global/config.php'; ?>
<?php require 'inc/backend/config.php'; ?>
<?php require 'inc/_global/views/head_start.php'; ?>

<!-- Page JS Plugins CSS -->
<?php $dm->get_css('js/plugins/magnific-popup/magnific-popup.css'); ?>

<?php require 'inc/_global/views/head_end.php'; ?>
<?php require 'inc/_global/views/page_start.php'; ?>

<!-- Hero -->
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">Stock</h1>
            <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Generator</li>
                    <li class="breadcrumb-item active" aria-current="page">Stock</li>
                </ol>
            </nav>
        </div>
   </div>
</div>
<!-- END Hero -->

<!-- Page Content -->
<div class="content">
    <!-- Simple -->
    <h2 class="content-heading">Stock of different generators</h2>
    <div class="row">

      <?php

	$RecupType = $odb->query('SELECT * FROM `type`');
	foreach ($RecupType as $RecupType) {
		$checkstock = $odb->prepare('SELECT COUNT(type) FROM accounts WHERE type = ?');
		$checkstock->execute(array($RecupType['name']));
		$cstock = $checkstock->fetchColumn();

		if ($RecupType['lien'] == "") {
			$lien = "href='javascript:void(0)'";
		}
		else {
			$lien = "href='".$RecupType['lien']."' target='_blank'";
		}

		?>
    <div class="col-md-6 col-xl-4">
        <a class="block block-rounded bg-gd-sea-op" <?=$lien?>>
            <div class="block-content block-content-full d-flex align-items-center justify-content-between">
                <div class="item">
                  <img class="img-avatar img-avatar96 img-avatar-thumb" style="max-width:45px;max-height:45px" src="<?=$RecupType['img']?>" alt="">
                </div>
                <div class="ml-3 text-right">

                    <p class="text-white font-size-lg font-w600 mb-0">
                        <?=$RecupType['name']?>
                    </p>

                    <p class="text-white-75 mb-0">
                        <?php
                        if ($cstock == 0) {
        									if (empty($RecupType['raison'])) {
        										echo "Sold out";
        									}
        									else {
        										echo "".$RecupType['raison']."";
        									}
        								}
      									else {
      										echo "In Stock ($cstock)";
      									}
        								?>
                    </p>

                </div>
            </div>
        </a>
    </div>
        <?php } ?>

    </div>
    <!-- END Simple -->
</div>
<!-- END Page Content -->

<?php require 'inc/_global/views/page_end.php'; ?>
<?php require 'inc/_global/views/footer_start.php'; ?>

<!-- Page JS Plugins -->
<?php $dm->get_js('js/plugins/magnific-popup/jquery.magnific-popup.min.js'); ?>
<?php $dm->get_js('js/plugins/raty-js/jquery.raty.js'); ?>
<?php $dm->get_js('js/pages/be_comp_rating.min.js'); ?>
<!-- Page JS Helpers (Magnific Popup Plugin) -->

<script>jQuery(function(){ Dashmix.helpers('magnific-popup'); });</script>

<?php require 'inc/_global/views/footer_end.php'; ?>
