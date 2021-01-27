<?php require 'inc/_global/config.php'; ?>
<?php require 'inc/backend/config.php'; ?>
<?php require 'inc/_global/views/head_start.php'; ?>
<?php require 'inc/_global/views/head_end.php'; ?>
<?php require 'inc/_global/views/page_start.php'; ?>


<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">Partnership</h1>
        </div>
    </div>
</div>
<div class="content">
    <div class="block block-rounded block-bordered">
        <div class="block-content block-content-full">
            <div class="row row-deck">
                <?php
                $getPartner = $odb->query('SELECT * FROM partner');
                foreach ($getPartner as $ePartner){
                ?>
                    <div class="col-md-6 col-xl-4">
                        <div class="block block-rounded block-fx-pop">
                            <div class="block-header">
                                <div class="flex-fill text-muted font-size-sm font-w600">
                                    <i class="fa fa-clock mr-1"></i> Since <?php echo date("j F Y", $ePartner['date']); ?>
                                </div>
                            </div>
                            <div class="block-content bg-body text-center">
                                <h3 class="font-size-h4 font-w700 mb-1">
                                    <a href=""><?=$ePartner['nom']?></a>
                                </h3>
                                <h4 class="font-size-h6 text-muted mb-3"><?=$ePartner['description']?></h4>
                            </div>
                            <div class="block-content text-center" style="padding: 1.25rem 0 0 0 !important;">
                                <img class="img-fluid" src="<?=$ePartner['gif']?>" alt="">
                            </div>
                            <div class="block-content block-content-full">
                                <div class="row gutters-tiny">
                                    <div class="col-12">
                                        <a class="btn btn-block btn-primary" href="<?=$ePartner['lien']?>" target="_blank">
                                            <i class="fa fa-eye mr-1"></i> Go to the Website
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php }
                ?>
            </div>
        </div>
    </div>
</div>

<?php $dm->get_js('js/pages/be_tables_datatables.min.js'); ?>
<?php require 'inc/_global/views/page_end.php'; ?>
<?php require 'inc/_global/views/footer_start.php'; ?>
<?php require 'inc/_global/views/footer_end.php'; ?>
