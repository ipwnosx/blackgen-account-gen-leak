<?php require '../inc/_global/config.php'; ?>
<?php require '../inc/dashboards/modern/config.php'; ?>
<?php require '../inc/_global/views/head_start.php'; ?>
<?php require '../inc/dashboards/modern/views/check.php'; ?>
<?php $dm->get_css('js/plugins/datatables/dataTables.bootstrap4.css'); ?>
<?php $dm->get_css('js/plugins/datatables/buttons-bs4/buttons.bootstrap4.min.css'); ?>
<?php require '../inc/_global/views/head_end.php'; ?>
<?php require '../inc/_global/views/page_start.php'; ?>

<?php include 'bandeau.php'; ?>
<div class="content">

  <div class="block block-rounded block-bordered">
      <div class="block-header block-header-default">
          <h3 class="block-title">List of all generations</h3>
      </div>
      <div class="block-content block-content-full">
          <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _es6/pages/be_tables_datatables.js -->
          <table class="table table-bordered table-striped table-vcenter js-dataTable-full">
              <thead>
                  <tr>
                      <th class="text-center" style="width: 80px;">#</th>
                      <th>Email</th>
                      <th>Password</th>
                      <th class="d-none d-sm-table-cell">Type</th>
                      <th class="d-none d-sm-table-cell">Customer</th>
                      <th>Date</th>
                  </tr>
              </thead>
              <tbody>
                  <?php
                  $rGene = $odb->query("SELECT * FROM `logs` ORDER BY `date` DESC LIMIT 2500");
                  $rGene = $rGene->fetchAll();
                  foreach ($rGene as $row) {
                    ?>
                    <tr>
                        <td class="text-center"><?php echo $row['id']; ?></td>
                        <td class="d-none d-sm-table-cell">
                          <?=$row['email']?>
                        </td>
                        <td class="d-none d-sm-table-cell">
                          <?=$row['password']?>
                        </td>
                        <td class="d-none d-sm-table-cell">
                          <?=$row['type']?>
                        </td>
                        <td class="d-none d-sm-table-cell">
                          <?=$row['username']?>
                        </td>
                        <td class="d-none d-sm-table-cell">
                          <?php echo date("m-d-Y, h:i:s a" ,$row['date']);	 ?>
                        </td>
                    </tr>
                  <?php } ?>
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
