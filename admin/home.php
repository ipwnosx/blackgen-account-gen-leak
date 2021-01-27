<?php require '../inc/_global/config.php'; ?>
<?php require '../inc/dashboards/modern/config.php'; ?>
<?php require '../inc/_global/views/head_start.php'; ?>
<?php require '../inc/dashboards/modern/views/check.php'; ?>
<?php require '../inc/_global/views/head_end.php'; ?>
<?php require '../inc/_global/views/page_start.php'; ?>

<!-- Quick Menu -->
<?php include 'bandeau.php'; ?>

<!-- Page Content -->
<div class="content">
    <?php
    if (isset($_SESSION['success_report'])) {
        echo '<div class="animated fadeIn">'.success($_SESSION['success_report']).'</div>';
        unset($_SESSION['success_report']);
    }
    ?>
    <div class="row invisible" data-toggle="appear">
        <!-- Statistics -->
        <div class="col-md-6">
            <div class="block" href="javascript:void(0)">
                <div class="block-content block-content-full bg-white-90 overflow-hidden">
                    <div class="py-3">
                        <span class="js-sparkline" data-type="line"
                                                    data-points="[<?php
                                                        $chaine = "";
                                                    		$recupNbGen = $odb->query('SELECT * FROM stats ORDER BY id DESC LIMIT 8');
                                                    		foreach ($recupNbGen as $recupNbGen) {
                                                          $chaine = "".$chaine.$recupNbGen['gen'].",";
                                                          }echo substr($chaine, 0, -1);
                                                        ?>]"
                                                    data-width="100%"
                                                    data-height="200px"
                                                    data-line-color="#6a82fb"
                                                    data-fill-color="transparent"
                                                    data-spot-color="transparent"
                                                    data-min-spot-color="transparent"
                                                    data-max-spot-color="transparent"
                                                    data-highlight-spot-color="#6a82fb"
                                                    data-highlight-line-color="#6a82fb"
                                                    data-tooltip-suffix="Générations"></span>
                    </div>
                </div>
                <div class="block-content block-content-full d-flex align-items-end justify-content-between bg-body-light">
                    <div class="mr-3">
                        <p class="font-w600 text-uppercase mb-0">
                            Generate per day
                        </p>
                        <p class="font-size-h3 font-w300 text-muted mb-0">
                            ~
                            <?php
                            $recupMoyGen = $odb->query('SELECT AVG(gen) AS gen_moyenne FROM stats ORDER BY id DESC LIMIT 8');
                            foreach ($recupMoyGen as $recupMoyGen) {
                              echo $recupMoyGen['gen_moyenne'];
                            }

                            ?>
                        </p>
                    </div>
                    <div>
                        <i class="fa fa-2x fa-code text-muted"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="block">
                <div class="block-content block-content-full bg-white-90 overflow-hidden">
                    <!-- <div class="py-3">
                        <span class="js-sparkline" data-type="line"
                                                    data-points="[13,12,16,17,12,18,10]"
                                                    data-width="100%"
                                                    data-height="200px"
                                                    data-line-color="#e65c00"
                                                    data-fill-color="transparent"
                                                    data-spot-color="transparent"
                                                    data-min-spot-color="transparent"
                                                    data-max-spot-color="transparent"
                                                    data-highlight-spot-color="#e65c00"
                                                    data-highlight-line-color="#e65c00"
                                                    data-tooltip-suffix="Tickets"></span>
                    </div> -->
                </div>
                <div class="block-content block-content-full d-flex align-items-end justify-content-between bg-body-light">
                    <div class="mr-3">
                        <p class="font-w600 text-uppercase mb-0">
                            Tickets per day
                        </p>
                        <p class="font-size-h3 font-w300 text-muted mb-0">
                            ~
                        </p>
                    </div>
                    <div>
                        <i class="fa fa-2x fa-life-ring text-muted"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row invisible" data-toggle="appear">

        <div class="col-md-6 col-xl-6">
            <div class="block">
                <div class="block-content block-content-full">
                    <p class="text-uppercase font-w600 text-center mt-2 mb-4">
                        The least filled generators
                    </p>
                    <?php
                    $RecupType = $odb->query('SELECT *,COUNT(*) FROM accounts GROUP BY type ORDER BY COUNT(*) LIMIT 4');

                    foreach ($RecupType as $RecupType) {
                      $recupDetails = $odb->prepare('SELECT * FROM type WHERE name = ?');
                      $recupDetails->execute(array($RecupType['type']));
                      $recupDetails = $recupDetails->fetch();
                      ?>


                      <a class="block block-rounded block-link-rotate bg-body-dark mb-2" href="javascript:void(0)">
                          <div class="block-content block-content-sm block-content-full d-flex align-items-center justify-content-between">
                              <div class="mr-3">
                                  <p class="font-size-h3 font-w300 mb-0">
                                      <?=$RecupType['COUNT(*)']?>
                                  </p>
                                  <p class="text-muted font-italic mb-0">
                                      <?=$RecupType['type']?>
                                  </p>
                              </div>
                              <div class="item">
                                <img class="img-avatar img-avatar96 img-avatar-thumb" style="max-width:45px;max-height:45px" src="<?=$recupDetails['img']?>" alt="">
                              </div>
                          </div>
                      </a>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-6">
            <div class="block">
                <div class="block-content block-content-full">
                    <p class="text-uppercase font-w600 text-center mt-2 mb-4">
                        Latest sales
                    </p>
                    <?php
                    $recupLastP = $odb->query('SELECT * FROM payments LEFT JOIN plans ON payments.plan = plans.ID ORDER BY payments.ID DESC LIMIT 4 ');
                    foreach ($recupLastP as $recupLastP) {
                      ?>
                      <a class="block block-rounded block-link-rotate bg-body-dark mb-2" href="javascript:void(0)">
                          <div class="block-content block-content-sm block-content-full d-flex align-items-center justify-content-between">
                              <div class="mr-3">
                                  <p class="font-size-h3 font-w300 mb-0">
                                      <?=$recupLastP['paid']?> $
                                  </p>
                                  <p class="text-muted font-italic mb-0">
                                      Rank <span class="badge badge-danger" style="background:<?=$recupLastP['color']?>"><?=$recupLastP['name']?></span>
                                  </p>
                              </div>
                              <div class="item">
                                  <i class="fa fa-2x fa-euro-sign text-muted"></i>
                              </div>
                          </div>
                      </a>
                    <?php } ?>

                </div>
            </div>
        </div>
    </div>
</div>

<?php require '../inc/_global/views/page_end.php'; ?>
<?php require '../inc/_global/views/footer_start.php'; ?>

<!-- Page JS Plugins -->
<?php $dm->get_js('js/plugins/jquery-sparkline/jquery.sparkline.min.js'); ?>

<!-- Page JS Helpers (jQuery Sparkline plugin) -->
<script>jQuery(function(){ Dashmix.helpers('sparkline'); });</script>

<?php require '../inc/_global/views/footer_end.php'; ?>
