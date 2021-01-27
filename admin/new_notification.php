<?php require '../inc/_global/config.php'; ?>
<?php require '../inc/dashboards/modern/config.php'; ?>
<?php require '../inc/_global/views/head_start.php'; ?>
<?php require '../inc/dashboards/modern/views/check.php'; ?>
<?php
if (isset($_POST['addnotif'])){
    $destinataire = $_POST['destinataire'];
    $message = $_POST['message'];
    $icone = "fa-check-circle";
    $color = $_POST['color'];
    $date = time()+2*3600;
			$SQLinsert = $odb -> prepare("INSERT INTO `allnotifications` VALUES(NULL, ?, ?, ?,?,?)");
			$SQLinsert -> execute(array($message,$icone,$color,$destinataire,$date));
      header('Location: notifications.php');
			$_SESSION['success'] = 'The notification has been added !';

}
?>
<?php $dm->get_css('js/plugins/datatables/dataTables.bootstrap4.css'); ?>
<?php $dm->get_css('js/plugins/datatables/buttons-bs4/buttons.bootstrap4.min.css'); ?>
<?php $dm->get_css('js/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css'); ?>
<?php $dm->get_css('js/plugins/select2/css/select2.min.css'); ?>

<?php require '../inc/_global/views/head_end.php'; ?>
<?php require '../inc/_global/views/page_start.php'; ?>

<?php include 'bandeau.php'; ?>
<div class="content">
  <div class="block block-rounded block-fx-pop block-themed">
      <div class="block-header bg-gd-sublime">
          <h3 class="block-title">Add a notification</h3>
      </div>
      <div class="block-content block-content-full">
          <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _es6/pages/be_tables_datatables.js -->
          <form class="form-horizontal push-10-t" method="post">

            <div class="form-group">
                <label for="destinataire">Recipient</label>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <select class="js-select2 form-control" id="destinataire" name="destinataire" style="width: 100%;" data-placeholder="Select a recipient">
                                <option value="all">everyone</option>
                                <?php
                                $SQLGetLogs = $odb->query("SELECT * FROM `users` ORDER BY `username` ASC");
                                while ($getInfo = $SQLGetLogs->fetch(PDO::FETCH_ASSOC)) {
                                    $name = $getInfo['username'];
                                    $id = $getInfo['ID'];
                                    echo '<option value="' . htmlentities($id) . '">' . htmlentities($name) . '</option></br>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="reponse">Message</label>
                <textarea class="form-control" name="message" rows="8" cols="80"></textarea>
            </div>

            <div class="form-group">
              <label for="example-colorpicker3">Color</label>
              <input type="text" class="js-colorpicker form-control" id="example-colorpicker3" data-format="rgba" name="color">
            </div>

            <div class="form-group">
                <button name="addnotif" value="do" class="btn btn-sm btn-primary" type="submit">Add</button>
            </div>
          </form>
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
<?php $dm->get_js('js/plugins/select2/js/select2.full.min.js'); ?>


<!-- Page JS Code -->
<?php $dm->get_js('js/pages/be_tables_datatables.min.js'); ?>
<script>jQuery(function(){ Dashmix.helpers(['datepicker', 'colorpicker', 'maxlength', 'select2', 'rangeslider', 'masked-inputs']); });</script>

<?php require '../inc/_global/views/footer_end.php'; ?>

