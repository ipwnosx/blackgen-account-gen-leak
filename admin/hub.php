<?php require '../inc/_global/config.php'; ?>
<?php require '../inc/dashboards/modern/config.php'; ?>
<?php require '../inc/_global/views/head_start.php'; ?>
<?php require '../inc/dashboards/modern/views/check.php'; ?>
<?php

if (isset($_POST['update'])){
		$updateRaison = $_POST['raison'];
		$updateId = $_POST['update'];
		$updateLien = $_POST['lien'];
		$SQLinsert = $odb -> prepare("UPDATE `type` SET `raison` = ?, `lien` = ? WHERE `id` = ?");
		$SQLinsert -> execute(array($updateRaison, $updateLien, $updateId));
		$notify = success('Link and reason updated !');
}

if (isset($_POST['delete'])) {
    $delete = $_POST['delete'];
    $SQL = $odb -> prepare("SELECT * FROM `type` WHERE `id` = ?");
    $SQL -> execute(array($delete));
    $name = $SQL -> fetch(PDO::FETCH_ASSOC)['name'];
    $SQL = $odb -> prepare("DELETE FROM `type` WHERE `id` = ?");
    $SQL -> execute(array($delete));
    $SQL = $odb -> prepare("DELETE FROM `accounts` WHERE `type` = ?");
    $SQL -> execute(array($name));
    $notify = success('The generator has been removed');
}

if (isset($_POST['addmethod'])) {
    if (empty($_POST['name'])) {
        $notify = error('Please verify all fields');
    }
		else {
        $name = $_POST['name'];
				$img = $_POST['img'];
        $SQLinsert = $odb -> prepare("INSERT INTO `type` VALUES(NULL, ?, ?, ?, ?)");
        $SQLinsert -> execute([$name, $img, "", ""]);
				echo $name;
				echo $img;
        $notify = success('The generator has been added');
    }
}

if (isset($_POST['add'])) {
    switch ($_POST['add']) {
        case 'single':
            $email = $_POST['email1'];
            $pass = $_POST['pass1'];
            $type = $_POST['type1'];
            $insert = $odb -> prepare("INSERT INTO `accounts` VALUES(NULL, ?, ?, ?)");
            $insert -> execute([$email, $pass, $type]);
            $notify = success('Account has been successfully added');
        break;
        case 'bulk':
            $comboz = $_POST['combo'];
            $type = $_POST['type2'];
            $combos = preg_split('/[\r\n]+/', $comboz, -1, PREG_SPLIT_NO_EMPTY);
            foreach ($combos as $combo1) {
                $combo = explode(':', $combo1);
                $email = $combo[0];
                $pass = $combo[1];
                $insert = $odb -> prepare("INSERT INTO `accounts` VALUES(NULL, ?, ?, ?)");
                $insert -> execute([$email, $pass, $type]);
            }
            $notify = success('Accounts have been added');
        break;
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

  <div class="content content-narrow">

  <div class="row">

    <div class="col-md-6">
      <div class="block block-rounded block-fx-pop block-themed">
        <div class="block-header bg-gd-sublime">
          <h3 class="block-title">Accounts type</h3>
        </div>
        <div class="block-content block-content-full">
          <table class="table">
            <tr>
              <th style="font-size: 12px;">Website</th>
              <th style="font-size: 12px;">Remove</th>
            </tr>
            <tr>
                <?php
                $SQLGetMethods = $odb -> query("SELECT * FROM `type`");
                while ($getInfo = $SQLGetMethods -> fetch(PDO::FETCH_ASSOC)) {
                    $id = $getInfo['id'];
                    $name = $getInfo['name'];
                    $raison = $getInfo['raison'];
                    $lien = $getInfo['lien'];
                    echo '
                    <form method="post">
                      <tr>
                        <td style="font-size: 12px;">
                          <a class="link-fx" href="#" data-toggle="modal" data-target="#modal-block-slideup'. $id .'" >'.htmlspecialchars($name).'</a>
                        </td>
                        <td style="font-size: 12px;">
                          <div class="btn-group btn-group-sm mr-2 mb-2" role="group">
                            <button name="delete" value="'.$id.'" type="submit" class="btn btn-outline-danger"><i class="far fa-trash-alt"></i></button>
                          </div>
                        </td>
                      </tr>
                    </form>';

                    ?>
                    <div class="modal fade" id="modal-block-slideup<?php echo $id; ?>" tabindex="-1" role="dialog" aria-labelledby="modal-block-slideup" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-slideup" role="document">
                            <div class="modal-content">
                                <div class="block block-themed block-transparent mb-0">
                                    <div class="block-header bg-primary-dark">
                                      <h3 class="block-title">Edit type :
                                        <?php echo htmlspecialchars($name); ?>
                                      </h3>
                                        <div class="block-options">
                                            <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                                <i class="fa fa-fw fa-times"></i>
                                            </button>
                                        </div>
                                    </div>

                                      <form class="form-horizontal push-10-t" method="post">
                                    <div class="block-content">
                                      <div class="block-content block block-content">
                                          <div class="form-group">
                                            <div class="col-sm-12">
                                              <div class="form-material">
                                                <input placeholder="Leave empty if no particular reason" class="form-control" type="text" id="raison" name="raison" value="<?php echo htmlspecialchars($raison); ?>">
                                                <label for="raison">Reason for the break</label>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <div class="col-sm-12">
                                              <div class="form-material">
                                              <input placeholder="Leave blank if no link has to be filled" class="form-control" type="text" id="lien" name="lien" value="<?php echo htmlspecialchars($lien); ?>">
                                              <label for="lien">Website Link</label>
                                              </div>
                                            </div>
                                          </div>

                                      </div>

                                    </div>
                                    <div class="block-content block-content-full text-right bg-light">
                                      <div class="col-sm-9"> <button name="update" value="<?php echo $id; ?>" class="btn btn-sm btn-primary" type="submit">Update</button> </div>
                                    </div>
                                  </form>
                                </div>
                            </div>
                        </div>
                    </div>
                  </div>
                </div>
                <?php
                }
                if (empty($SQLGetMethods)) {
                    echo error('No Types');
                }
                ?>
            </tr>
          </table>
        </div>
      </div>
    </div>


    <div class="col-md-6">
      <div class="block block-rounded block-fx-pop block-themed">
        <div class="block-header bg-gd-sublime">
          <h3 class="block-title">Add an account</h3>
        </div>
        <div class="block-content block-content-full">
          <form class="form-horizontal push-10-t push-10" method="POST">
            <div class="form-group">
              <div class="col-sm-12">
                <div class="form-material">
                  <label for="email1">Email</label>
                  <input class="form-control" id="email1" name="email1" placeholder="Email">
                </div>
              </div></br>
              <div class="col-sm-12">
                <div class="form-material">

                  <label for="pass1">Password</label>
                  <input class="form-control" id="pass1" name="pass1" placeholder="Password">
                </div>
              </div>
            </div>
          	<div class="form-group">
              <div class="col-sm-12">
                <div class="form-material floating open">
                  <label for="pass1">Type of account</label>
                  <select class="form-control" id="type" name="type1" size="1">
                    <?php
                                          $SQLGetLogs = $odb->query("SELECT * FROM `type` ORDER BY `id` ASC");
                                          while ($getInfo = $SQLGetLogs->fetch(PDO::FETCH_ASSOC)) {
                                              $name = $getInfo['name'];
                                              echo '<option value="' . htmlentities($name) . '">' . htmlentities($name) . '</option>';
                                          }
                                          ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-12 text-center">
                <button class="btn btn-sm btn-success" type="submit" name="add" value="single">
                  <i class="fa fa-plus push-5-r"></i> Add
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="block block-rounded block-fx-pop block-themed">
        <div class="block-header bg-gd-sublime">
          <h3 class="block-title">Add multiple accounts</h3>
        </div>
        <div class="block-content block-content-full">
          <form class="form-horizontal push-10-t push-10" method="POST">
            <div class="form-group">
              <div class="col-sm-12">
                <div class="form-material floating open">
                  <textarea class="form-control" name="combo" placeholder="kirikoo@kirikoo.pw:password2781" rows="5"></textarea>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-12">
                <div class="form-material floating open">
                  <select class="form-control" id="type" name="type2" size="1">
                    <?php
                                          $SQLGetLogs = $odb->query("SELECT * FROM `type` ORDER BY `id` ASC");
                                          while ($getInfo = $SQLGetLogs->fetch(PDO::FETCH_ASSOC)) {
                                              $name = $getInfo['name'];
                                              echo '<option value="' . htmlentities($name) . '">' . htmlentities($name) . '</option>';
                                          }
                                          ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-12 text-center">

                <button class="btn btn-sm btn-success" type="submit" name="add" value="bulk">

                    <i class="fa fa-plus push-5-r"></i> Add
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="block block-rounded block-fx-pop block-themed">
        <div class="block-header bg-gd-sublime">
          <h3 class="block-title">Add a generator</h3>
        </div>
        <div class="block-content block-content-full">
          <form class="form-horizontal push-10-t" method="post">
            <div class="form-group">
              <div class="col-sm-12">
                <div class="form-material">
                  <label for="name">Name</label>
                  <input class="form-control" type="text" id="name" name="name">
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-12">
                <div class="form-material">
                  <label for="img">Picture Link</label>
                  <input class="form-control" type="text" id="img" name="img">
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-12 text-center">

                <button class="btn btn-sm btn-success" type="submit" name="addmethod" value="do">

                    <i class="fa fa-plus push-5-r"></i> Add
                </button>
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
<?php $dm->get_js('js/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js'); ?>

<!-- Page JS Code -->
<?php $dm->get_js('js/pages/be_tables_datatables.min.js'); ?>
<script>jQuery(function(){ Dashmix.helpers(['colorpicker']); });</script>
<?php require '../inc/_global/views/footer_end.php'; ?>
