<?php require '../inc/_global/config.php'; ?>
<?php require '../inc/dashboards/modern/config.php'; ?>
<?php require '../inc/_global/views/head_start.php'; ?>
<?php require '../inc/dashboards/modern/views/check.php'; ?>
<?php

if (isset($_POST['delete'])) {
    $delete = $_POST['delete'];
    $SQL = $odb -> prepare("DELETE FROM `accounts` WHERE `id` = ?");
    $SQL -> execute(array($delete));
    $notify = success('Account has been successfully deleted');
}

?>
<?php $dm->get_css('js/plugins/datatables/dataTables.bootstrap4.css'); ?>
<?php $dm->get_css('js/plugins/datatables/buttons-bs4/buttons.bootstrap4.min.css'); ?>
<?php require '../inc/_global/views/head_end.php'; ?>
<?php require '../inc/_global/views/page_start.php'; ?>

<?php include 'bandeau.php'; ?>
<div class="content">
      <?php		if(isset($notify)){			echo '<div class="col-md-12">' . $notify . "</div>";		}		?>
  <div class="block block-rounded block-bordered">
      <div class="block-header block-header-default">
          <h3 class="block-title">List of all accounts</h3>
      </div>
      <div class="block-content block-content-full">
          <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _es6/pages/be_tables_datatables.js -->
          <table class="table table-bordered table-striped table-vcenter js-dataTable-full">
              <thead>
                  <tr>
                      <th class="text-center" style="width: 80px;">#</th>
                      <th class="d-none d-sm-table-cell" style="width: 15%;">Email</th>
                      <th class="d-none d-sm-table-cell" style="width: 15%;">Password</th>
                      <th class="d-none d-sm-table-cell" style="width: 15%;">Type</th>
                      <th class="d-none d-sm-table-cell" style="width: 15%;">Remove</th>
                  </tr>
              </thead>
              <tbody>

                  <?php
                  $rAccount = $odb->query('SELECT * FROM accounts ORDER BY id ASC LIMIT 20000');
                  foreach ($rAccount as $rAccount) {
                    ?>
                    <tr>
                        <td class="text-center"><?php echo $rAccount['id']; ?></td>
                        <td class="d-none d-sm-table-cell">
                          <?=$rAccount['email']?>
                        </td>
                        <td class="d-none d-sm-table-cell">
                          <?=$rAccount['password']?> $
                        </td>
                        <td class="d-none d-sm-table-cell">
                          <?=$rAccount['type']?>
                        </td>
                        <form method="post">
                          <td class="d-none d-sm-table-cell">
                            <div class="btn-group btn-group-sm mr-2 mb-2" role="group">
                              <button name="delete" value="<?=$rAccount['id']?>" type="submit" class="btn btn-outline-danger"><i class="far fa-trash-alt"></i></button>
                            </div>
                          </td>
                        </form>
                    </tr>
                  <?php }
                  ?>
              </tbody>
          </table>
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
