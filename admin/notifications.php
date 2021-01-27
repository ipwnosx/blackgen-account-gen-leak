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
<?php                       if (isset($_SESSION['success'])) {
                          echo '<div class="animated fadeIn">'.success($_SESSION['success']).'</div>';
                          unset($_SESSION['success']);
                      } ?>
  <div class="block block-rounded block-bordered">
      <div class="block-header block-header-default">
          <h3 class="block-title">List of all notifications</h3>
      </div>
      <div class="block-content block-content-full">
          <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _es6/pages/be_tables_datatables.js -->
          <table class="table table-bordered table-striped table-vcenter js-dataTable-full">
              <thead>
                  <tr>
                      <th class="text-center" style="width: 80px;">#</th>
                      <th class="d-none d-sm-table-cell" style="width: 15%;">Users</th>
                      <th>Message</th>
                      <th class="d-none d-sm-table-cell" style="width: 15%;">Read</th>
                      <th class="d-none d-sm-table-cell" style="width: 15%;">Date</th>
                  </tr>
              </thead>
              <tbody>

                  <?php
                  $rNotif = $odb->query('SELECT * FROM notif INNER JOIN users ON notif.id_member = users.ID INNER JOIN allnotifications ON notif.id_notif = allnotifications.id');
                  foreach ($rNotif as $rNotif) {
                    if ($rNotif['view'] == 1) {
                      $view = "Yes";
                    }
                    elseif ($rNotif['view'] == 0) {
                      $view = "No";
                    }
                    ?>
                    <tr>
                        <td class="text-center"><?php echo $rNotif['id']; ?></td>
                        <td class="font-w600">
                            <?=$rNotif['username']?>
                        </td>
                        <td class="d-none d-sm-table-cell">
                          <i class="fa <?=$rNotif['icone']?>" style="color:<?=$rNotif['color']?>"></i>  <?=$rNotif['message']?>
                        </td>
                        <td>
                          <?=$view?>
                        </td>
                        <td>
                          <?php echo date('d-m-Y (H:i)', $rNotif['date']); ?>
                        </td>
                    </tr>
                  <?php }
                  ?>
                  <?php for ($i = 1; $i < 21; $i++) { ?>

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
