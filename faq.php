<?php require 'inc/_global/config.php'; ?>
<?php require 'inc/backend/config.php'; ?>
<?php require 'inc/_global/views/head_start.php'; ?>
<?php require 'inc/_global/views/head_end.php'; ?>
<?php require 'inc/_global/views/page_start.php'; ?>

<!-- Hero -->
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">See the answers to the most common questions.</h1>
            <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Support</li>
                    <li class="breadcrumb-item active" aria-current="page">FAQ</li>
                </ol>
            </nav>
        </div>
   </div>
</div>
<!-- END Hero -->

<!-- Page Content -->
<div class="content">
    <!-- Frequently Asked Questions -->
    <div class="block block-rounded block-bordered">
        <div class="block-header block-header-default">
            <h3 class="block-title">Can not find your answer? <a href="support.php">Click here</a></h3>
        </div>
        <div class="block-content">
            <div class="row items-push">
                <div class="col-lg-12">


                <?php
                $i = 1;
                $SQLGetFAQ = $odb -> query("SELECT * FROM `faq` ORDER BY `id` DESC");
                while ($getInfo = $SQLGetFAQ -> fetch(PDO::FETCH_ASSOC)) {
                $question = $getInfo['question'];
                $answer = $getInfo['answer'];
                ?>
                <div id="faq<?php echo $i; ?>" role="tablist" aria-multiselectable="true">
                    <div class="block block-rounded mb-1">
                        <div class="block-header block-header-default" role="tab" id="faq1_h<?php echo $i; ?>">
                            <a class="font-w600" data-toggle="collapse" data-parent="#faq<?php echo $i; ?>" href="#faq1_q<?php echo $i; ?>" aria-expanded="true" aria-controls="faq1_q<?php echo $i; ?>"><?php echo $question; ?></a>
                        </div>
                        <div id="faq1_q<?php echo $i; ?>" class="collapse" role="tabpanel" aria-labelledby="faq<?php echo $i; ?>_h<?php echo $i; ?>" data-parent="#faq<?php echo $i; ?>">
                            <div class="block-content">
                                <?php echo $answer; ?>
                            </div>
                        </div>
                    </div>
                </div>
              <?php
              $i++;
                }  ?>
                </div>
            </div>
        </div>
    </div>
    <!-- END Frequently Asked Questions -->
</div>
<!-- END Page Content -->

<?php require 'inc/_global/views/page_end.php'; ?>
<?php require 'inc/_global/views/footer_start.php'; ?>
<?php require 'inc/_global/views/footer_end.php'; ?>
