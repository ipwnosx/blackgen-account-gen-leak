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
            <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">The News</h1>
            <div class="flex-sm-00-auto ml-sm-3 py-3 d-none d-xl-block">
                <!-- Toggle Timeline Mode -->
                <button class="btn btn-sm btn-dark" data-toggle="class-toggle" data-target=".timeline" data-class="timeline-centered">
                    <i class="fa fa-arrows-alt-h mr-1"></i> Lock the news bar
                </button>
            </div>
        </div>
   </div>
</div>
<!-- END Hero -->

<!-- Page Content -->
<div class="content">
    <!-- Timeline -->
    <!--
        Available classes for timeline list:

        'timeline'                                      A normal timeline with icons to the left in all screens
        'timeline timeline-centered timeline-alt'       A centered timeline with odd events to the left and even events to the right (screen width > 1200px)
        'timeline timeline-centered'                    A centered timeline with all events to the left. You can add the class 'timeline-event-alt'
                                                        to 'timeline-event' elements to position them to the right (screen width > 1200px) (useful, if you
                                                        would like to have multiple events to the left or to the right section)
    -->
    
    <ul class="timeline timeline-centered timeline-alt">
        <li class="timeline-event">
            <div class="timeline-event-icon bg-dark">
                <i class="fa fa-cogs"></i>
            </div>
            <div class="timeline-event-block block block-rounded block-fx-pop invisible" data-toggle="appear">
                <div class="block-header block-header-default">
                    <h3 class="block-title">General</h3>
                    <div class="block-options">
                        <div class="timeline-event-time block-options-item font-size-sm font-w600">
                            24/07/19
                        </div>
                    </div>
                </div>
                <div class="block-content">
                    <div class="alert alert-success d-flex align-items-center justify-content-between" role="alert">
                        <div class="flex-fill mr-3">
                            <p class="mb-0">Thank you for your <a class="alert-link" href="javascript:void(0)">purchase</a> Black-Generator</p>
                        </div>
                        <div class="flex-00-auto">
                            <i class="fa fa-fw fa-check-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </li>
    </ul>




    <!-- END Timeline -->
</div>
<!-- END Page Content -->

<?php require 'inc/_global/views/page_end.php'; ?>
<?php require 'inc/_global/views/footer_start.php'; ?>

<!-- Page JS Plugins -->
<?php $dm->get_js('js/plugins/magnific-popup/jquery.magnific-popup.min.js'); ?>

<!-- Page JS Helpers (Magnific Popup Plugin) -->
<script>jQuery(function(){ Dashmix.helpers('magnific-popup'); });</script>

<?php require 'inc/_global/views/footer_end.php'; ?>
