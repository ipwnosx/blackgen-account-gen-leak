<?php require '../inc/_global/config.php'; ?>
<?php require '../inc/dashboards/modern/config.php'; ?>
<?php require '../inc/_global/views/head_start.php'; ?>
<?php require '../inc/dashboards/modern/views/check.php'; ?>
<?php
if (isset($_POST['update'])){
  $updateName = $_POST['name'.$_POST['update']];
  $updateUnit = $_POST['unit'.$_POST['update']];
  $updateLength = $_POST['length'.$_POST['update']];
  $updateLimit = $_POST['limit'.$_POST['update']];
  $updateAccounts = $_POST['accounts'.$_POST['update']];
  $updatePrice = floatval($_POST['price'.$_POST['update']]);
  $updateprivate = $_POST['private'.$_POST['update']];
  $updatecolor = $_POST['color'.$_POST['update']];
  if (empty($updatePrice) || empty($updateName) || empty($updateUnit) || empty($updateLength) || empty($updateLimit) || empty($updateAccounts)){
    $notify = error('Values ​​are missing!');
  }		else {
    $SQLinsert = $odb -> prepare("UPDATE `plans` SET `name` = ?, `accounts` = ?, `limit` = ?, `unit` = ?, `length` = ?, `price` = ?, `private` = ?, `color` = ? WHERE `ID` = ?");
    $SQLinsert -> execute(array($updateName, $updateAccounts, $updateLimit,$updateUnit, $updateLength, $updatePrice, $updateprivate, $updatecolor,$_POST['update']));
    $notify = success('The subscription has been updated');
  }
}
if(isset($_POST['delete'])){
		$deleteSQL = $odb->prepare("DELETE FROM `plans` WHERE `ID` = :id");
		$deleteSQL->execute(array(':id' => $_POST['delete']));
		$notify = success('Plan deleted');
}
if (isset($_POST['addplan'])){
		$name = $_POST['name'];		$limit = $_POST['limit'];		$accounts = $_POST['accounts'];
		$unit = $_POST['unit'];
		$length = $_POST['length'];
		$price = floatval($_POST['price']);
		$private = $_POST['private'];
    $grade = $_POST['grade'];
    $color = $_POST['color'];
		if (empty($price) || empty($name) || empty($unit) || empty($length) || empty($limit) || empty($accounts)){
			$notify = error('Please complete all fields');
		} else{
			$SQLinsert = $odb -> prepare("INSERT INTO `plans` VALUES(NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
			$SQLinsert -> execute(array($name, $accounts, $limit, $unit, $length, $price, $private,$grade,$color));

			$notify = success('The new subscription has been added !');
		}
}
function selectedUnit($check, $currentUnit){
	if ($currentUnit == $check){
		return 'selected="selected"';
	}
}

?>
<?php $dm->get_css('js/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css'); ?>
<?php $dm->get_css('js/plugins/datatables/dataTables.bootstrap4.css'); ?>
<?php $dm->get_css('js/plugins/datatables/buttons-bs4/buttons.bootstrap4.min.css'); ?>
<?php require '../inc/_global/views/head_end.php'; ?>
<?php require '../inc/_global/views/page_start.php'; ?>

<?php include 'bandeau.php'; ?>

<div class="content">
      <?php		if(isset($notify)){			echo '<div class="col-md-12">' . $notify . "</div>";		}		?>
  <div class="block block-rounded block-fx-pop block-themed">
      <div class="block-header bg-gd-sublime">
          <h3 class="block-title">Manage subscription plans</h3>
      </div>
      <div class="block-content block-content-full">
          <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _es6/pages/be_tables_datatables.js -->
          <table class="table js-dataTable-full">
                <tbody>
                <tr>
                  <th style="font-size: 12px;">Subscription name</th>
                  <th class="text-center" style="font-size: 12px;">Color</th>
                  <th class="text-center" style="font-size: 12px;">Price</th>
                  <th class="text-center" style="font-size: 12px;">duration</th>
                  <th class="text-center" style="font-size: 12px;">Account/day</th>
                  <th class="text-center" style="font-size: 12px;">Accounts type</th>
                  <th class="text-center" style="font-size: 12px;">Private</th>
                  <th class="text-center" style="font-size: 12px;">Sold</th>
                  <th class="text-center" style="font-size: 12px;">Users</th>
                </tr>
                <?php
                $getPlans = $odb->query('SELECT * FROM plans ORDER BY price ASC');
                foreach ($getPlans as $dPlans) {
                  if ($dPlans['private'] == 0) { $private = 'Non'; } else { $private = 'Oui'; }
                  $id = $dPlans['ID'];
                  $sales = $odb->query("SELECT COUNT(*) FROM `payments` WHERE `plan` = '$id'")->fetchColumn(0);
                  $people = $odb->query("SELECT COUNT(*) FROM `users` WHERE `membership` = '$id'")->fetchColumn(0);
                  ?>
                  <tr>
                      <td style="font-size: 12px;">
                        <a class="link-fx" href="#" data-toggle="modal" data-target="#modal-block-slideup<?php echo $id; ?>"><?=$dPlans['name']?></a>
                      </td>
                      <td class="text-center" style="font-size: 12px;"><i class="fa fa-circle" style='color:<?=$dPlans['color']?>'></i></td>
                      <td class="text-center" style="font-size: 12px;"><?=$dPlans['price']?> €</td>
                      <td class="text-center" style="font-size: 12px;"><?=$dPlans['length']?> <?=$dPlans['unit']?></td>
                      <td class="text-center" style="font-size: 12px;"><?=$dPlans['limit']?></td>
                      <td class="text-center" style="font-size: 12px;"><?=$dPlans['accounts']?></td>
                      <td class="text-center" style="font-size: 12px;"><?=$private?></td>
                      <td class="text-center" style="font-size: 12px;"><?=$sales?></td>
                      <td class="text-center" style="font-size: 12px;"><?=$people?></td>
                  </tr>

                  <div class="modal fade" id="modal-block-slideup<?php echo $id; ?>" tabindex="-1" role="dialog" aria-labelledby="modal-block-slideup" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-slideup" role="document">
                          <div class="modal-content">
                              <div class="block block-themed block-transparent mb-0">
                                  <div class="block-header bg-primary-dark">
                                      <h3 class="block-title">Edit pack:
                                        <?=$dPlans['name']?></h3>
                                      <div class="block-options">
                                          <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                              <i class="fa fa-fw fa-times"></i>
                                          </button>
                                      </div>
                                  </div>
                                  <form method="post">
                                  <div class="block-content">
                                    <div class="row items-push">
                                        <div class="col-lg-12">

                                            <div class="form-group">
                                                <label for="val-username">Name</label>
                                                <input type="text" class="form-control" id="name2" name="name<?php echo $id; ?>" value="<?=$dPlans['name']?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="val-email">Price</label>
                                                <input type="text" class="form-control" id="price2" name="price<?php echo $id; ?>" value="<?=$dPlans['price']?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="val-password">Duration</label>
                                                <input type="text" class="form-control" id="length2" name="length<?php echo $id; ?>" value="<?=$dPlans['length']?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="val-skill">Time unit <span class="text-danger">*</span></label>
                                                <select class="form-control" id="val-skill" name="unit<?php echo $id; ?>">
                                                    <option value="Days" <?php echo selectedUnit('Days',$dPlans['unit']); ?>>Days</option>
        																						<option value="Weeks" <?php echo selectedUnit('Weeks',$dPlans['unit']); ?> >Week</option>
        																						<option value="Months" <?php echo selectedUnit('Months',$dPlans['unit']); ?>>Month</option>
        																						<option value="Years" <?php echo selectedUnit('Years',$dPlans['unit']); ?>>Year</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="val-password">Account per day</label>
                                                <input type="text" class="form-control" id="length2" name="limit<?php echo $id; ?>" value="<?=$dPlans['limit']?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="val-password">Account type</label>
                                                <input type="text" class="form-control" id="length2" name="accounts<?php echo $id; ?>" value="<?=$dPlans['accounts']?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="val-skill">Private <span class="text-danger">*</span></label>
                                                <select class="form-control" id="val-skill" name="private<?php echo $id; ?>">
                                                  <option value="1" <?php echo selectedUnit(1,$dPlans['private']); ?>>Yes</option>
                                                  <option value="0" <?php echo selectedUnit(0,$dPlans['private']); ?>>No</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                    <label for="example-colorpicker3">Color</label>
                                                    <input type="text" class="js-colorpicker form-control" id="example-colorpicker3" data-format="rgba" name="color<?php echo $id; ?>" value="<?=$dPlans['color']?>">
                                            </div>

                                        </div>
                                    </div>

                                  </div>
                                  <div class="block-content block-content-full text-right bg-light">
                                    <button name="update" value="<?php echo $id; ?>" class="btn btn-sm btn-primary" type="submit">Update</button>
                                    <button name="delete" value="<?php echo $id; ?>" class="btn btn-sm btn-danger" type="submit">Remove</button>
                                  </div>
                                </form>
                              </div>
                          </div>
                      </div>
                  </div>
                <?php }
                ?>

              </tbody>
            </table>
      </div>
  </div>
  <div class="block block-rounded block-fx-pop block-themed">
      <div class="block-header bg-gd-sublime">
          <h3 class="block-title">Add a new subscription</h3>
      </div>
      <div class="block-content block-content-full">
        <form class="form-horizontal push-10-t" method="post">
          <div class="form-group">
              <label for="name">Name</label>
              <input type="text" class="form-control" id="name" name="name">
          </div>
          <div class="form-group">
              <label for="price">Price</label>
              <input type="text" class="form-control" id="price" name="price">
          </div>
          <div class="form-group">
              <label for="length">Duration</label>
              <input type="text" class="form-control" id="length" name="length">
          </div>
          <div class="form-group">
              <label for="unit">Unit Duration</label>
              <select class="form-control" id="unit" name="unit">
                <option value="Days">Days</option>
                <option value="Weeks">Weeks</option>
                <option value="Months">Months</option>
                <option value="Years">Years</option>
              </select>
          </div>
          <div class="form-group">
              <label for="limit">Number of generations</label>
              <input type="number" class="form-control" id="limit" name="limit">
          </div>

          <div class="form-group">
              <label for="accounts">accounts type separated by a comma ','</label>
              <input type="text" class="form-control" id="accounts" name="accounts">
          </div>
          <div class="form-group">
              <label for="private">Private</label>
              <select class="form-control" id="private" name="private">
                <option value="1">Yes</option>
                <option value="0">No</option>
              </select>
          </div>
          <div class="form-group">
                  <label for="example-colorpicker3">Color</label>
                  <input type="text" class="js-colorpicker form-control" id="example-colorpicker3" data-format="rgba" name="color" value="rgba(6, 101, 208, 1)">
          </div>
          <div class="form-group">
              <button name="addplan" value="do" class="btn btn-sm btn-primary" type="submit">Add</button>
          </div>
        </form>
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
<?php $dm->get_js('js/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js'); ?>

<!-- Page JS Code -->
<?php $dm->get_js('js/pages/be_tables_datatables.min.js'); ?>
<script>jQuery(function(){ Dashmix.helpers(['colorpicker']); });</script>
<?php require '../inc/_global/views/footer_end.php'; ?>
