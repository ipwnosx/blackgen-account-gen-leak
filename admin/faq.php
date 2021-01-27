<?php require '../inc/_global/config.php'; ?>
<?php require '../inc/dashboards/modern/config.php'; ?>
<?php require '../inc/_global/views/head_start.php'; ?>
<?php require '../inc/dashboards/modern/views/check.php'; ?>
<?php
if (isset($_POST['addquestion'])){
    $question = $_POST['question'];
    $reponse = $_POST['reponse'];
		if (empty($reponse) || empty($reponse)){
			$notify = error('Please complete all fields');
		} else{
			$SQLinsert = $odb -> prepare("INSERT INTO `faq` VALUES(NULL, ?, ?)");
			$SQLinsert -> execute(array($question,$reponse));

			$notify = success('The new field has been added to the FAQ !');
		}
}
if (isset($_POST['removequestion'])){
      $id = $_POST['removequestion'];
			$SQLinsert = $odb -> prepare("DELETE FROM faq WHERE id = ?");
			$SQLinsert -> execute(array($id));
			$notify = success('The question / answer has been removed !');
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
          <h3 class="block-title">Manage F.A.Q questions</h3>
      </div>
      <div class="block-content block-content-full">
          <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _es6/pages/be_tables_datatables.js -->
          <table class="table js-dataTable-full">
                <tbody>
                <tr>
                  <th class="text-center" style="font-size: 12px;">Question</th>
                  <th class="text-center" style="font-size: 12px;">Answer</th>
                  <th></th>
                </tr>
                <?php
                $getFaq = $odb->query('SELECT * FROM faq');
                foreach ($getFaq as $getFaq) {
                  ?>
                  <tr>
                      <td class="text-center" style="font-size: 12px;"><?=$getFaq['question']?></td>
                      <td class="text-center" style="font-size: 12px;"><?=$getFaq['answer']?></td>
                      <td><form method="post">
                        <div class="btn-group btn-group-sm mr-2 mb-2" role="group">
                          <button name="removequestion" value="<?=$getFaq['id']?>" type="submit" class="btn btn-outline-danger"><i class="far fa-trash-alt"></i></button>
                        </div>
                      </form></td>
                  </tr>

                <?php }
                ?>

              </tbody>
            </table>
      </div>
  </div>
  <div class="block block-rounded block-fx-pop block-themed">
      <div class="block-header bg-gd-sublime">
          <h3 class="block-title">Add a question / answer</h3>
      </div>
      <div class="block-content block-content-full">
          <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _es6/pages/be_tables_datatables.js -->
          <form class="form-horizontal push-10-t" method="post">
            <div class="form-group">
                <label for="question">Question</label>
                <input type="text" class="form-control" id="question" name="question">
            </div>
            <div class="form-group">
                <label for="reponse">Answer</label>
                <textarea class="form-control" name="reponse" rows="8" cols="80"></textarea>
            </div>
            <div class="form-group">
                <button name="addquestion" value="do" class="btn btn-sm btn-primary" type="submit">Add</button>
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

<!-- Page JS Code -->
<?php $dm->get_js('js/pages/be_tables_datatables.min.js'); ?>
<script>jQuery(function(){ Dashmix.helpers(['colorpicker']); });</script>
<?php require '../inc/_global/views/footer_end.php'; ?>
