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
          <h3 class="block-title">List of all users</h3>
      </div>
      <div class="block-content block-content-full">
          <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _es6/pages/be_tables_datatables.js -->
          <table class="table table-bordered table-striped table-vcenter js-dataTable-full">
              <thead>
                  <tr>
                      <th class="text-center" style="width: 80px;">#</th>
                      <th>Username</th>
                      <th class="d-none d-sm-table-cell" style="width: 30%;">Email</th>
                      <th class="d-none d-sm-table-cell" style="width: 15%;">Rank</th>
                      <th class="d-none d-sm-table-cell" style="width: 15%;">Subscription</th>
                  </tr>
              </thead>
              <tbody>

                  <?php
                  $rUser = $odb->query('SELECT * FROM users');
                  foreach ($rUser as $rUser) {
                    if ($rUser['membership'] != 0) {
                      $rAbo = $odb->prepare('SELECT * FROM plans WHERE ID = ?');
                      $rAbo->execute(array($rUser['membership']));
                      $rAbo = $rAbo->fetch();
                      $abo = "<span class='badge badge-danger' style='background:".$rAbo['color']."'>".$rAbo['name']."</span>";
                    }
                    else {
                      $abo = "No subscription";
                    }
                    if ($rUser['rank'] == 1) {
                      $grade = "<span class='badge badge-danger'>Administrateur</span>";
                    }
                    elseif ($rUser['rank'] == 2) {
                        $grade = "<span class='badge badge-success'>Support</span>";
                    }
                    elseif ($rUser['rank'] == 3) {
                        $grade = "<span class='badge badge-success' style='background: black;'>Modérateur</span>";
                    }

                    else {
                      $grade = "Membre";
                    }
                    //
                    ?>
                    <tr>
                        <td class="text-center"><?php echo $rUser['ID']; ?></td>
                        <td class="font-w600">
                            <a href="edit_user.php?id=<?=$rUser['ID']?>"><?=$rUser['username']?></a>
                        </td>
                        <td class="d-none d-sm-table-cell">
                            <em class="text-muted"><?=$rUser['email']?></em>
                        </td>
                        <td class="d-none d-sm-table-cell">
                            <?=$grade?>
                        </td>
                        <td>
                          <?=$abo?>
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
