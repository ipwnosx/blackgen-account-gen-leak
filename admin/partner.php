<?php require '../inc/_global/config.php'; ?>
<?php require '../inc/dashboards/modern/config.php'; ?>
<?php require '../inc/_global/views/head_start.php'; ?>
<?php require '../inc/dashboards/modern/views/check.php'; ?>

<?php $dm->get_css('js/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css'); ?>
<?php $dm->get_css('js/plugins/datatables/dataTables.bootstrap4.css'); ?>
<?php $dm->get_css('js/plugins/datatables/buttons-bs4/buttons.bootstrap4.min.css'); ?>
<?php require '../inc/_global/views/head_end.php'; ?>
<?php require '../inc/_global/views/page_start.php'; ?>

<?php include 'bandeau.php'; ?>

<div class="content">
    <?php
    if (isset($_SESSION['success_report'])) {
        echo '<div class="animated fadeIn">'.success($_SESSION['success_report']).'</div>';
        unset($_SESSION['success_report']);
    }
    ?>
  <div class="block block-rounded block-fx-pop block-themed">
      <div class="block-header bg-gd-sublime">
          <h3 class="block-title">Manage partnerships</h3>
      </div>
      <div class="block-content block-content-full">
          <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _es6/pages/be_tables_datatables.js -->
          <table class="table js-dataTable-full">
                <tbody>
                <tr>
                  <th style="font-size: 12px;">Name of the partner</th>
                  <th class="text-center" style="font-size: 12px;">Website link</th>
                  <th class="text-center" style="font-size: 12px;">Starting date</th>
                  <th class="text-center" style="font-size: 12px;">G.I.F or Banner link</th>
                    <th></th>
                </tr>
                <?php
                $getPartner = $odb->query('SELECT * FROM partner ORDER BY id ASC');
                foreach ($getPartner as $dPartner) {
                    ?>
                  <tr>
                      <td style="font-size: 12px;">
                        <a class="link-fx" href="#"><?=$dPartner['nom']?></a>
                      </td>
                      <td class="text-center" style="font-size: 12px;"><a target="_blank" href="<?=$dPartner['lien']?>"><?=$dPartner['lien']?></a></td>
                      <td class="text-center" style="font-size: 12px;"><?php echo date("j F Y",$dPartner['date']);?></td>
                      <td class="text-center" style="font-size: 12px;"><?=$dPartner['gif']?></td>
                      <td style="font-size: 12px;" class="text-center">
                          <form method="post" action="../inc/form/form.php">
                              <div class="btn-group btn-group-sm mr-2 mb-2" role="group">
                                  <button name="supp_partner" value="<?=$dPartner['id']?>" type="submit" class="btn btn-outline-danger"><i class="far fa-trash-alt"></i></button>
                              </div>
                          </form>
                      </td>
                  </tr>
                <?php }
                ?>

              </tbody>
            </table>
      </div>
  </div>
  <div class="block block-rounded block-fx-pop block-themed">
      <div class="block-header bg-gd-sublime">
          <h3 class="block-title">Add a partnership</h3>
      </div>
      <div class="block-content block-content-full">
        <form class="form-horizontal push-10-t" method="post" action="../inc/form/form.php">
          <div class="form-group">
              <label for="nom">Name</label>
              <input type="text" class="form-control" id="nom" name="nom">
          </div>
            <div class="form-group">
                <label for="description">Description</label>
                <input type="text" class="form-control" id="description" name="description">
            </div>
          <div class="form-group">
              <label for="lien">Link</label>
              <input type="url" class="form-control" id="lien" name="lien">
          </div>
            <div class="form-group">
                <label for="gif">GIF or Banner</label>
                <input type="url" class="form-control" id="gif" name="gif">
            </div>
          <div class="form-group">
              <button name="addPartner" class="btn btn-sm btn-primary" type="submit">Add</button>
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
