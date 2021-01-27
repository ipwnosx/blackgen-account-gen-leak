<?php require '../inc/_global/config.php'; ?>
<?php require '../inc/dashboards/modern/config.php'; ?>
<?php require '../inc/_global/views/head_start.php'; ?>
<?php require '../inc/dashboards/modern/views/check.php'; ?>
<?php
if (isset($_POST['remplacer'])){
    $id = $_POST['remplacer'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $type = $_POST['type'];
    $username = $_POST['username'];
    $time = time();


    $updateOld = $odb->prepare('UPDATE report_log SET etat = 1 WHERE id_log = ?');
    $updateOld->execute(array($id));

    $updateAcc = $odb->prepare('INSERT INTO logs(email,password,type,username,date,visible,favori) VALUES(?,?,?,?,?,?,?)');
    $updateAcc->execute(array($email,$password,$type,$username,$time,0,0));

    $recupNotif = $odb->prepare('SELECT * FROM logs WHERE email = ? and password = ? and username = ?');
    $recupNotif->execute(array($email,$password,$username));
    $recupNotif = $recupNotif->fetch();

    $recupUser = $odb->prepare('SELECT ID FROM users WHERE username = ?');
    $recupUser->execute(array($username));
    $recupUser = $recupUser->fetch();
    $id_user = $recupUser['ID'];

    $addNotif = $odb->prepare('INSERT INTO allnotifications(message,icone,color,target,date) VALUES(?,?,?,?,?)');
    $addNotif->execute(array("Following your recent report an account has just been given to us : ".$recupNotif['id']."", "fa fa-check-circle","rgb(22, 200, 48)",$id_user,$time));

    $_SESSION['success_report'] = "The replacement has been done";
    header('Location: home.php');
}
if (isset($_POST['supprimer_remplacement'])){
    $id = $_POST['supprimer_remplacement'];
    $updateOld = $odb->prepare('UPDATE report_log SET etat = 2 WHERE id_log = ?');
    $updateOld->execute(array($id));
}
?>
<?php $dm->get_css('js/plugins/datatables/dataTables.bootstrap4.css'); ?>
<?php $dm->get_css('js/plugins/datatables/buttons-bs4/buttons.bootstrap4.min.css'); ?>
<?php $dm->get_css('js/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css'); ?>
<?php require '../inc/_global/views/head_end.php'; ?>
<?php require '../inc/_global/views/page_start.php'; ?>

<?php include 'bandeau.php'; ?>
<div class="content">
  <div class="block block-rounded block-fx-pop block-themed">
      <div class="block-header bg-gd-sublime">
          <h3 class="block-title">Account to replace</h3>
      </div>
      <div class="block-content block-content-full">
          <table class="table table-bordered table-striped table-vcenter js-dataTable-buttons">
              <thead>
              <tr>
                  <th class="text-center" style="width: 80px;">#</th>
                  <th class="d-none d-sm-table-cell" style="width: 30%;">Email</th>
                  <th class="d-none d-sm-table-cell" style="width: 30%;">Password</th>
                  <th class="d-none d-sm-table-cell" style="width: 15%;">Type</th>
                  <th style="width: 15%;">Date</th>
                  <th>Actions</th>
              </tr>
              </thead>
              <tbody>
              <?php
              $getReport = $odb->query('SELECT * FROM report_log LEFT JOIN logs ON report_log.id_log = logs.id WHERE etat = 0');
              foreach ($getReport as $report)
              { ?>
                  <tr>
                      <td class="text-center"><?php echo $report['id']; ?></td>
                      <td class="font-w600">
                          <?php echo $report['email'];?>
                      </td>
                      <td class="d-none d-sm-table-cell">
                          <em class="text-muted"><?php echo $report['password'];?></em>
                      </td>
                      <td class="d-none d-sm-table-cell">
                          <span class="badge badge-primary"><?php echo $report['type']; ?></span>
                      </td>
                      <td>
                          <em class="text-muted"><span style="display: none;"><?php echo date('Ymd', $report['date']); ?></span><?php echo date('d/m/Y', $report['date']); ?></em>
                      </td>
                      <td>
                          <form method="post">
                              <div class="btn-group btn-group-sm mr-2 mb-2" role="group" aria-label="Small Outline Secondary Second group">
                                  <button type="button" data-toggle="modal" data-target="#modal-block-slideup<?php echo $report['id']; ?>" class="btn btn-outline-info"><i class="fas fa-retweet"></i></button>
                                  <button type="submit" class="btn btn-outline-danger" name="supprimer_remplacement" value="<?php echo $report['id']; ?>"><i class="fas fa-trash"></i></button>
                              </div>
                          </form>
                      </td>
                  </tr>

                  <div class="modal fade" id="modal-block-slideup<?php echo $report['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="modal-block-slideup" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-slideup" role="document">
                          <div class="modal-content">
                              <div class="block block-themed block-transparent mb-0">
                                  <div class="block-header bg-primary-dark">
                                      <h3 class="block-title">Replace account n°<?php echo $report['id']; ?></h3>
                                      <div class="block-options">
                                          <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                              <i class="fa fa-fw fa-times"></i>
                                          </button>
                                      </div>
                                  </div>
                                  <form method="post">
                                      <div class="block-content">
                                          <h5>Type <span class="badge badge-primary"><?php echo $report['type']; ?></span></h5>
                                          <div class="row items-push">
                                              <div class="col-lg-12">
                                                  <div class="form-group">
                                                      <label for="val-username">Email</label>
                                                      <input type="text" class="form-control" id="email" name="email">
                                                  </div>
                                                  <div class="form-group">
                                                      <label for="val-email">Password</label>
                                                      <input type="text" class="form-control" id="password" name="password">
                                                  </div>
                                                  <input type="hidden" name="username" value="<?php echo $report['username']; ?>">
                                                  <input type="hidden" name="type" value="<?php echo $report['type']; ?>">
                                              </div>
                                          </div>
                                      </div>
                                      <div class="block-content block-content-full text-right bg-light">
                                          <button name="remplacer" value="<?php echo $report['id']; ?>" class="btn btn-sm btn-primary" type="submit">Replace</button>
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
