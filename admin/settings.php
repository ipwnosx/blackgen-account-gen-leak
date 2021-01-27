<?php require '../inc/_global/config.php'; ?>
<?php require '../inc/dashboards/modern/config.php'; ?>
<?php require '../inc/_global/views/head_start.php'; ?>
<?php require '../inc/dashboards/modern/views/check.php'; ?>
<?php
$updated = false;
if (isset($_POST['website'])) {
    if ($sitename != $_POST['sitename']) {
        $SQL = $odb->prepare("UPDATE `settings` SET `sitename` = :sitename");
        $SQL->execute(array(
            ':sitename' => $_POST['sitename']
        ));
        $sitename = $_POST['sitename'];
        $updated  = true;
    }
    if ($description != $_POST['description']) {
        $SQL = $odb->prepare("UPDATE `settings` SET `description` = :description");
        $SQL->execute(array(
            ':description' => $_POST['description']
        ));
        $description = $_POST['description'];
        $updated     = true;
    }
    if ($siteurl != $_POST['url']) {
        $SQL = $odb->prepare("UPDATE `settings` SET `url` = :url");
        $SQL->execute(array(
            ':url' => $_POST['url']
        ));
        $siteurl = $_POST['url'];
        $updated = true;
    }
    if ($siteurl != $_POST['maintenance']) {
        $SQL = $odb->prepare("UPDATE `settings` SET `maintaince` = :maintenance");
        $SQL->execute(array(
            ':maintenance' => $_POST['maintenance']
        ));
        $maintaince = $_POST['maintenance'];
        $updated    = true;
    }
    if ($google_site != $_POST['google_site']) {
        $SQL = $odb->prepare("UPDATE `settings` SET `google_site` = :google_site");
        $SQL->execute(array(
            ':google_site' => $_POST['google_site']
        ));
        $google_site = $_POST['google_site'];
        $updated     = true;
    }
    if ($google_secret != $_POST['google_secret']) {
        $SQL = $odb->prepare("UPDATE `settings` SET `google_secret` = :google_secret");
        $SQL->execute(array(
            ':google_secret' => $_POST['google_secret']
        ));
        $google_secret = $_POST['google_secret'];
        $updated       = true;
    }
    if ($updated == true) {
        $done = "Website settings have been updated";
    }
}
if (isset($_POST['billing'])) {
    if ($coinpayments != $_POST['coinpayments']) {
        $SQL = $odb->prepare("UPDATE `settings` SET `coinpayments` = :coinpayments");
        $SQL->execute(array(
            ':coinpayments' => $_POST['coinpayments']
        ));
        $coinpayments = $_POST['coinpayments'];
        $updated      = true;
    }
    if ($ipnSecret != $_POST['ipnSecret']) {
        $SQL = $odb->prepare("UPDATE `settings` SET `ipnSecret` = :ipnSecret");
        $SQL->execute(array(
            ':ipnSecret' => $_POST['ipnSecret']
        ));
        $ipnSecret = $_POST['ipnSecret'];
        $updated   = true;
    }
    if (isset($_POST['paypal'])) {
        $SQL     = $odb->query("UPDATE `settings` SET `paypal` = '1'");
        $paypal  = 1;
        $updated = true;
    } else {
        $SQL     = $odb->query("UPDATE `settings` SET `paypal` = '0'");
        $paypal  = 0;
        $updated = true;
    }
    if (isset($_POST['bitcoin'])) {
        $SQL     = $odb->query("UPDATE `settings` SET `bitcoin` = '1'");
        $bitcoin = 1;
        $updated = true;
    } else {
        $SQL     = $odb->query("UPDATE `settings` SET `bitcoin` = '0'");
        $bitcoin = 0;
        $updated = true;
    }
    if ($updated == true) {
        $done = "Website settings have been updated";
    }
}
if (isset($_POST['generateur_valider'])) {
    $gen = $_POST['generateur'];
    $SQL     = $odb->prepare("UPDATE `settings` SET `gen_free` = ?");
    $SQL->execute(array($gen));
    if ($gen == 1){
        $_SESSION['success_report'] = "The free generator has just been activated";
    } else {
        $_SESSION['success_report'] = "The free generator has just been disabled";
    }
    header('Location: index.php');

}
?>
<?php $dm->get_css('js/plugins/datatables/dataTables.bootstrap4.css'); ?>
<?php $dm->get_css('js/plugins/datatables/buttons-bs4/buttons.bootstrap4.min.css'); ?>
<?php require '../inc/_global/views/head_end.php'; ?>
<?php require '../inc/_global/views/page_start.php'; ?>

<?php include 'bandeau.php'; ?>
<div class="content">
  <div class="row">
  	<div class="col-md-6">
  		<div class="block">
        <div class="block block-rounded block-fx-pop block-themed">
            <div class="block-header bg-gd-sublime">
                <h3 class="block-title">settings Black-Generator</h3>
            </div>
            <div class="block-content block-content-full">
  				<form class="form-horizontal push-10-t" method="post">
  					<div class="form-group">
  						<div class="col-sm-12">
  							<div class="form-material">
                  <label for="site-name">Name</label>
  								<input class="form-control" type="text" id="site-name" name="sitename" value="<?php echo htmlspecialchars($sitename); ?>">
  							</div>
  						</div>
  					</div>
  					<div class="form-group">
  						<div class="col-sm-12">
								<div class="form-material">
                  <label for="site-desc">Description</label>
									<input class="form-control" type="text" id="site-desc" name="description" value="<?php echo htmlspecialchars($description);  ?>">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-12">
								<div class="form-material">
                  <label for="site-url">Website URL</label>
									<input class="form-control" type="text" id="site-url" name="url" value="<?php echo htmlspecialchars($siteurl); ?>">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-12">
								<div class="form-material">
                  <label for="maintenance">Maintenance</label>
									<input class="form-control" type="text" id="maintenance" name="maintenance" value="<?php echo htmlspecialchars($maintaince); ?>" placeholder="Leave empty to disable">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-12">
								<div class="form-material">
                  <label for="google_site">Google ReCaptcha Public</label>
									<input class="form-control" type="text" id="google_site" name="google_site" value="<?php echo htmlspecialchars($google_site); ?>" placeholder="Find these details in Google ReCaptcha">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-12">
								<div class="form-material">
                  <label for="google_secret">Google ReCaptcha Secret</label>
									<input class="form-control" type="text" id="google_secret" name="google_secret" value="<?php echo htmlspecialchars($google_secret); ?>" placeholder="Find these details in Google ReCaptcha">

								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-9">
								<button name="website" value="do" class="btn btn-sm btn-primary" type="submit">Save</button>
							</div>
						</div>
					</form>
				</div>
  		 </div>
  	 </div>
  	</div>
    <div class="col-md-6">
      <div class="block">
        <div class="block block-rounded block-fx-pop block-themed">
            <div class="block-header bg-gd-sublime">
                <h3 class="block-title">Coin Payments</h3>
            </div>
        <div class="block-content block-content-narrow">
          <form class="form-horizontal push-10-t" method="post">
            <div class="form-group">
              <div class="col-sm-12">
                <div class="form-material">
                  <label for="merchant">Merchant ID</label>
                  <input class="form-control" type="text" id="merchant" name="coinpayments" value="<?php echo htmlspecialchars($coinpayments);?>">
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-12">
                <div class="form-material">
                  <label for="secret">Secret Key</label>
                  <input class="form-control" type="text" id="secret" name="ipnSecret" value="<?php echo htmlspecialchars($ipnSecret);?>">
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-12">
                    <label class="css-input css-checkbox css-checkbox-info">
                      <input name="bitcoin" type="checkbox" <?php
                                                             if ($bitcoin == 1) {
                                                                 echo 'checked';
                                                             }?>>
                                                             <span></span>  Bitcoin
                   </label>
                 </div>
                 <div class="col-xs-12">
                   <label class="css-input css-checkbox css-checkbox-info">
                     <input name="paypal" type="checkbox" <?php
                                                           if ($paypal == 1) {
                                                               echo 'checked';
                                                           }?>><span></span>  PayPal
                   </label>
                 </div>
               </div>
               <div class="form-group">
                 <div class="col-sm-9">
                   <button name="billing" value="do" class="btn btn-sm btn-primary" type="submit">Save</button>
                 </div>
               </div>
             </form>
           </div>
         </div>
       </div>
      <div class="block">
          <?php
          if($gen_free == 1){
              $on = "checked";
              $off = "";
          } elseif ($gen_free == 0){
              $on = "";
              $off = "checked";
          }
          ?>
        <div class="block block-rounded block-fx-pop block-themed">
            <div class="block-header bg-gd-sublime">
                <h3 class="block-title">Free Generator</h3>
            </div>
            <div class="block-content block-content-narrow">
                <form class="form-horizontal push-10-t" method="post">
                    <div class="form-group row items-push mb-0">
                        <div class="col-md-6">
                            <div class="custom-control custom-block custom-control-success" data-children-count="1">
                                <input type="radio" class="custom-control-input" id="example-cb-custom-block3" name="generateur" value="1" <?=$on?>>
                                <label class="custom-control-label" for="example-cb-custom-block3">
                                    <span class="d-block text-center">
                                        <i class="fa fa-check fa-2x mb-2 text-black-50"></i><br>
                                        Activate the generator
                                    </span>
                                </label>
                                <span class="custom-block-indicator">
                            <i class="fa fa-check"></i>
                        </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="custom-control custom-block custom-control-danger" data-children-count="1">
                                <input type="radio" class="custom-control-input" id="example-cb-custom-block10" name="generateur" value="0" <?=$off?>>
                                <label class="custom-control-label" for="example-cb-custom-block10">
                                    <span class="d-block text-center">
                                        <i class="fa fa-times fa-2x mb-2 text-black-50"></i><br>
                                        Disable the generator
                                    </span>
                                </label>
                                <span class="custom-block-indicator">
                                    <i class="fa fa-check"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-9">
                            <button name="generateur_valider" value="do" class="btn btn-sm btn-primary" type="submit">Save</button>
                        </div>
                    </div>

                </form>
            </div>
         </div>
       </div>
     </div>
   </div>
 </div>
<?php require '../inc/_global/views/page_end.php'; ?>
<?php require '../inc/_global/views/footer_start.php'; ?>

<!-- Page JS Plugins -->
<?php $dm->get_js('js/plugins/datatables/jquery.dataTables.min.js'); ?>
<?php $dm->get_js('js/plugins/datatables/dataTables.bootstrap4.min.js'); ?>
<?php $dm->get_js('js/plugins/datatables/buttons/dataTables.buttons.min.js'); ?>
<?php $dm->get_js('js/plugins/datatables/buttons/buttons.print.min.js'); ?>
<?php $dm->get_js('js/plugins/datatables/buttons/buttons.html5.min.js'); ?>
<?php $dm->get_js('js/plugins/datatables/buttons/buttons.flash.min.js'); ?>
<?php $dm->get_js('js/plugins/datatables/buttons/buttons.colVis.min.js'); ?>

<!-- Page JS Code -->
<?php $dm->get_js('js/pages/be_tables_datatables.min.js'); ?>

<?php require '../inc/_global/views/footer_end.php'; ?>
