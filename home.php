<?php require 'inc/_global/config.php'; ?>
<?php require 'inc/backend/config.php'; ?>
<?php require 'inc/_global/views/head_start.php'; ?>
<?php require 'inc/_global/views/head_end.php'; ?>
<?php
if (!$user->hasMembership($odb)) {
}
 ?>
<?php require 'inc/_global/views/page_start.php'; ?>

<div class="bg-image" style="background-image: url('<?php echo $dm->assets_folder; ?>/media/various/bg_dashboard.jpg');">
    <div class="bg-white-90">
        <div class="content content-full">
            <div class="row">
                <div class="col-md-12 d-md-flex align-items-md-center">
                    <div class="py-4 py-md-0 text-center text-md-left invisible" data-toggle="appear">
						<div class="alert alert-danger" role="alert">
                                        <p class="mb-0">Welcome to BlackGenerator <a class="alert-link" href="#">Your #1 Account generator template</a> !</p>
                                    </div>
                        <h1 class="font-size-h2 mb-2">Home</h1>
						
                        <?php
                        $getMembership = $odb->prepare('SELECT * FROM users WHERE ID = ?');
                        $getMembership->execute(array($_SESSION['ID']));
                        $getMembership = $getMembership->fetch();
                        if ($getMembership['membership'] != 0) {
                          $rPlan = $odb->prepare('SELECT * FROM plans WHERE ID = ?');
                          $rPlan->execute(array($getMembership['membership']));
                          $rPlan = $rPlan->fetch();
                          $periode = date("d-m-Y à h:i:s" ,$getMembership['expire']);
                          $abo = "<span class='badge badge-danger' style='background:".$rPlan['color']."'>".$rPlan['name']."</span>";
                          $date = "Until $periode";
                        }
                        else {
                          $abo = "You have no subscription.";
                          $date = "";
                        }
                        $rPA = $odb->prepare('SELECT SUM(plan) as somme FROM parrain WHERE pseudo_member = ? and etat = 2');
                        $rPA->execute(array($_SESSION['username']));
                        $rc = $rPA->fetch();

                        $rPA2 = $odb->prepare('SELECT SUM(plan) as somme FROM parrain WHERE pseudo_parrain = ? and etat = 2');
                        $rPA2->execute(array($_SESSION['username']));
                        $rc1 = $rPA2->fetch();

                        $pts1 = $rc['somme'] + $rc1['somme'];
                        $pts1 = $pts1/100*5;
                        if ($pts1 == 0 || $pts1 == 1){
                            $pts = "<span class='badge badge-danger' style='background:rgb(6, 101, 208)'>".$pts1." point</span>";
                        } else {
                            $pts = "<span class='badge badge-danger' style='background:rgb(6, 101, 208)'>".$pts1." points</span>";
                        }

                        ?>

						
                        <h2 class="font-size-lg font-w400 text-muted mb-0">Current subscription : <?=$abo?> <small><?=$date?></small></h2>
                        <h2 class="font-size-lg font-w400 text-muted mb-0">Affiliation Points : <?=$pts?> <small>(5% of purchases made via a referral code from another user, allows to buy grades by contacting us by doing
                                <a href="new_ticket.php" target="_blank">ticket</a>)</small>
                    </div>
            </div>
            </div>
       </div>
    </div>
</div>
<div class="content">
  <div class="row row-deck">
      <div class="col-xl-6 invisible" data-toggle="appear">
          <!-- Users -->
          <div class="block block-rounded block-mode-loading-refresh">
              <div class="block-header block-header-default">
                  <h3 class="block-title">Twitter news feed</h3>
                  <div class="block-options">
                      <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                          <i class="si si-refresh"></i>
                      </button>
                  </div>
              </div>
              <div class="block-content">
			   <!-- Your Twitter Account -->
                  <a class="twitter-timeline"  data-height="600" data-lang="fr" href="https://twitter.com/BlackGen_">Tweets by BlackGenerator</a> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
              </div>
          </div>
      </div>
      <div class="col-xl-6 invisible" data-toggle="appear">
          <!-- Users -->
          <div class="block block-rounded block-mode-loading-refresh">
              <div class="block-header block-header-default">
                  <h3 class="block-title">Twitch Channel</h3>
                  <div class="block-options">
                      <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                          <i class="si si-refresh"></i>
                      </button>
                  </div>
              </div>
              <div class="block-content">
                  <div id="twitch-embed"></div>

                  <!-- Load the Twitch embed script -->
                  <script src="https://embed.twitch.tv/embed/v1.js"></script>

                  <!-- Create a Twitch.Embed object that will render within the "twitch-embed" root element. -->
                  <script type="text/javascript">
                      new Twitch.Embed("twitch-embed", {
                          width: 1200,
                          height: 480,
                          channel: "blackgenv3", // Your Twitch Channel
                          layout: "video",
                          width: "100%",
                          theme: "dark"
                      });
                  </script>
              </div>
          </div>
          <!-- END Users -->
      </div>
      <div class="col-xl-6 invisible" data-toggle="appear" data-timeout="200">
          <!-- Purchases -->
          <div class="block block-rounded block-mode-loading-refresh">
              <div class="block-header block-header-default">
                  <h3 class="block-title">Recent purchases</h3>
                  <div class="block-options">
                      <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                          <i class="si si-refresh"></i>
                      </button>
                  </div>
              </div>
              <div class="block-content">
                  <table class="table table-striped table-hover table-borderless table-vcenter font-size-sm">
                      <thead>
                          <tr class="text-uppercase">
                              <th class="font-w700">Subscription</th>
                              <th class="d-none d-sm-table-cell font-w700">Date</th>
                              <th class="font-w700">Status</th>
                              <th class="d-none d-sm-table-cell font-w700 text-right" style="width: 120px;">Price</th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php
                        $get5lastpurchase = $odb->prepare('SELECT * FROM payments WHERE user = ?');
                        $get5lastpurchase->execute(array($_SESSION['ID']));



                        foreach ($get5lastpurchase as $last) {
                          $rPlan = $odb->prepare('SELECT * FROM plans WHERE ID = ?');
                          $rPlan->execute(array($last['plan']));
                          $rPlan = $rPlan->fetch();
                          $abo = "<span class='badge badge-danger' style='background:".$rPlan['color']."'>".$rPlan['name']."</span>";?>
                          <tr>
                              <td>
                                  <span class="font-w600"><?=$abo?></span>
                              </td>
                              <td class="d-none d-sm-table-cell">
                                  <span class="font-size-sm text-muted"><?php echo date("m-d-Y, h:i:s" ,$last['date']);	 ?></span>
                              </td>
                              <td>
                                  <span class="font-w600 text-success">Completed</span>
                              </td>
                              <td class="d-none d-sm-table-cell text-right">
                                  <?=$last['paid']?> $
                              </td>
                          </tr>
                        <?php }
                        ?>

                      </tbody>
                  </table>
              </div>
          </div>
          <!-- END Purchases -->
      </div>
  </div>
</div>

					

<?php require 'inc/_global/views/page_end.php'; ?>
<?php require 'inc/_global/views/footer_start.php'; ?>

<!-- Page JS Plugins -->
<?php $dm->get_js('js/plugins/jquery-sparkline/jquery.sparkline.min.js'); ?>

<!-- Page JS Helpers (jQuery Sparkline Plugin) -->
<script>jQuery(function(){ Dashmix.helpers(['sparkline']); });</script>
<?php require 'inc/_global/views/footer_end.php'; ?>
