<?php require 'inc/_global/config.php'; ?>
<?php require 'inc/backend/config.php'; ?>
<?php require 'inc/_global/views/head_start.php'; ?>
<?php require 'inc/_global/views/head_end.php'; ?>
<?php require 'inc/_global/views/page_start.php'; ?>

<div class="bg-image" style="background-image: url('<?php echo $dm->assets_folder; ?>/media/photos/photo11@2x.jpg');">
    <div class="bg-black-75">
        <div class="content content-boxed text-center">
            <div class="py-5">
                <h1 class="font-size-h2 font-w400 text-white mb-2">
                    <i class="fa fa-arrow-up mr-1"></i> The subscriptions
                </h1>
                <h2 class="font-size-h4 font-w400 text-white-75">Need a boost ?</h2>
            </div>
        </div>
    </div>
</div>
<div class="content content-boxed overflow-hidden">
    <div class="row py-5">
      <?php
              $SQLGetPlans = $odb -> query("SELECT * FROM `plans` WHERE `private` = 0 ORDER BY `price` ASC");
              while ($getInfo = $SQLGetPlans -> fetch(PDO::FETCH_ASSOC)){
                $name = $getInfo['name'];
                $price = $getInfo['price'];
                $length = $getInfo['length'];
                $unit = $getInfo['unit'];
                if ($unit == "Months") {
                  $unite = "Months";
                }
                if ($unit == "Days") {
                  $unite = "Days";
                }
                if ($unit == "Weeks") {
                  $unite = "Weeks";
                }

                $ID = $getInfo['ID'];
                $couleur = $getInfo['color'];
                if($paypal == 1) $PayPalAccepted = '<button type="submit" class="btn btn-hero-warning mr-1 mb-3" data-toggle="popover" data-placement="bottom" title="BTC" data-content="Secure payment by cryptocurrency."><i class="fab fa-btc mr-1"></i></button>';
                if($bitcoin == 1) $BitcoinAccepted = '<button type="submit" class="btn btn-hero-info mr-1 mb-3" data-toggle="popover" data-placement="bottom" title="Paypal" data-content="Secure payment by Paypal."><i class="fab fa-paypal mr-1"></i></button>';
                $PSFAccepted = '<a href="inc/form/form.php?id='.$ID.'&paiementpsc"><button type="button" class="btn btn-hero-danger mr-1 mb-3" data-toggle="popover" data-placement="bottom" title="PSC" data-content="Payment by PaySafeCard"><i class="fas fa-ticket-alt mr-1"></i></button></a>';
                if($bitcoin == 0 && $paypal == 0 && $paysafecard == 0) $NeitherAccepted = 'Sales are currently closed';
                echo "
                <div class='col-md-6 col-xl-3 invisible' data-toggle='appear' data-class='animated fadeInDown' data-timeout='600'>
                      <!-- Default Position -->
                      <div class='block block-bordered block-rounded'>
                          <div class='block-content block-content-full ribbon ribbon-primary'>
                              <div class='ribbon-box'>
                                  <i class='fa fa-shopping-cart mr-1'></i> ".htmlspecialchars($price)." $
                              </div>
                              <div class='text-center py-4'>
                                  <div class='item item-circle mx-auto push' style='margin-bottom: 0px;'>
                                    <div class='block-header'>
                                        <span class='badge badge-success' style='font-size: 120%;background-color:$couleur'>".htmlspecialchars($name)."</span>
                                    </div>
                                  </div>

                                  <p class='h6 text-muted'>".$getInfo['limit']." accounts / day</p>
                                  <p class='h6 text-muted'>".htmlentities($length)." ".htmlspecialchars($unite)."</p>
                                  <form action='inc/form/form.php?parrain=".$ID."' method='post'>
                                      $PayPalAccepted
                                      $BitcoinAccepted
                                      $PSFAccepted
                                  </form>
                                  <button type='button' class='btn btn-hero-secondary' data-toggle='modal' data-target='#modal-default-slideleft$ID'>More</button>
                              </div>
                          </div>
                      </div>
                      <!-- END Default Position -->
                  </div>

                  <div class='modal fade' id='modal-default-slideleft$ID' tabindex='-1' role='dialog' aria-labelledby='modal-default-slideleft' aria-hidden='true'>
                      <div class='modal-dialog modal-dialog-slideleft' role='document'>
                          <div class='modal-content'>
                              <div class='modal-header'>
                                  <h5 class='modal-title'>List of available generators</h5>
                                  <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                      <span aria-hidden='true'>&times;</span>
                                  </button>
                              </div>
                              <div class='modal-body pb-1'>
                              <table class='table table-sm table-vcenter'>
                                  <thead>
                                      <tr>
                                          <th class='text-center' style='width: 50px;'></th>
                                          <th>Generator</th>
                                          <th class='d-none d-sm-table-cell' style='width: 15%;'>Available</th>
                                      </tr>
                                  </thead>
                                  <tbody>";
                                  $recupType = $odb->query('SELECT * FROM type');
                                  foreach ($recupType as $recupType) { ?>
                                    <tr>
                                        <th class='text-center' scope='row'></th>
                                        <td class='font-w600'>
                                            <a href=''><?=$recupType['name']?></a>
                                        </td>
                                        <?php
                                        $accounts_array = explode(',', $getInfo['accounts']);
                                        foreach ($accounts_array as $acc) {
                                          if ($acc == $recupType['name']) {
                                            echo "<td class='d-none d-sm-table-cell'>
                                                <span class='badge badge-success'>Yes</span>
                                            </td>";
                                            $dispo = 0;
                                            break;
                                          }
                                          else {
                                            $dispo = 1;
                                          }
                                        }
                                        if ($dispo == 1) {
                                          echo "<td class='d-none d-sm-table-cell'>
                                              <span class='badge badge-danger'>No</span>
                                          </td>";
                                        }
                                    ?>
                                    </tr>
                                  <?php }
                              echo"
                              </tbody>
                              </table>
                              </div>
                              <div class='modal-footer'>
                                  <button type='button' class='btn btn-sm btn-primary' data-dismiss='modal'>Close</button>
                              </div>
                          </div>
                      </div>
                  </div>
                  ";
              }
              ?>

    </div>
</div>
<?php require 'inc/_global/views/page_end.php'; ?>
<?php require 'inc/_global/views/footer_start.php'; ?>
<?php
if (isset($_SESSION['achat'])){
    echo $_SESSION['achat'];
    echo "<script>jQuery('#modal-block-slideup').modal('show');</script>";
    unset($_SESSION['achat']);
}
?>
<?php require 'inc/_global/views/footer_end.php'; ?>
