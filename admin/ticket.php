<?php require '../inc/_global/config.php'; ?>
<?php require '../inc/dashboards/modern/config.php'; ?>
<?php
if (isset($_GET['id']) AND !empty($_GET['id'])) {
  $id = htmlspecialchars($_GET['id']);
  $getTicket = $odb->prepare('SELECT * FROM tickets WHERE id = ?');
  $getTicket->execute(array($id));
  if($getTicket->rowCount() == 1)
  {
    $getTicket = $getTicket->fetch();
    $getGrade = $odb->prepare('SELECT username,membership,email FROM users WHERE username = ?');
    $getGrade->execute(array($getTicket['username']));
    $infoUser = $getGrade->fetch();
    $getGrade = $odb->prepare('SELECT * FROM plans WHERE ID = ?');
    $getGrade->execute(array($infoUser['membership']));
    $getGrade = $getGrade->fetch();
      if ($infoUser['membership'] != 0) {
        $badge =  "<span class='badge badge-pill badge-info'>".$getGrade['name']."</span>";
      }

  }
  else
  {
     header("Location: tickets.php");
  }
}
else {
  header('Location: tickets.php');
}
?>
<?php require '../inc/_global/views/head_start.php'; ?>
<?php require '../inc/dashboards/modern/views/check.php'; ?>

<?php $dm->get_css('js/plugins/summernote/summernote-bs4.css'); ?>

<?php require '../inc/_global/views/head_end.php'; ?>
<?php require '../inc/_global/views/page_start.php'; ?>

<!-- Page Content -->
<div class="row no-gutters flex-md-10-auto">
  <div class="col-md-12">
      <!-- Main Content -->

      <div class="content">
        <?php
        if (isset($_SESSION['error'])) {
            echo '<div class="animated fadeIn">'.error($_SESSION['error']).'</div>';
            unset($_SESSION['error']);
        }
        if (isset($_SESSION['success'])) {
            echo '<div class="animated fadeIn">'.success($_SESSION['success']).'</div>';
            unset($_SESSION['success']);
        }
        ?>
        <div class="block block-fx-pop">
            <div class="block-content block-content-sm block-content-full bg-body-light">
                <div class="media py-3">
                    <div class="mr-3 ml-2 overlay-container overlay-right">
                        <?php $dm->get_avatar(0, 'female', 48); ?>
                        <i class="far fa-circle text-white overlay-item font-size-sm bg-success rounded-circle"></i>
                    </div>
                    <div class="media-body">
                        <div class="row">
                            <div class="col-sm-7">
                                <a class="font-w600 link-fx" href="#"><?=$getTicket['username']?></a> <?php 	if (isset($badge)) {
                                		echo $badge;
                                	} ?>
                                <div class="font-size-sm text-muted"><?=$infoUser['email']?></div>
                            </div>
                            <div class="col-sm-5 d-sm-flex align-items-sm-center">
                                <div class="font-size-sm font-italic text-muted text-sm-right w-100 mt-2 mt-sm-0">
                                    <p class="mb-0"><?php echo date('d-m-Y (H:i)', $getTicket['date']); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="block-content" style="padding-bottom: 50px;">
                <?=htmlspecialchars_decode($getTicket['content'])?>
            </div>
        </div>
        <?php
        $getMessage = $odb->prepare('SELECT * FROM messages WHERE ticketid = ? ORDER BY date');
        $getMessage->execute(array($getTicket['id']));
        foreach ($getMessage as $message) {
          if ($message['sender'] == "Admin") {
            $info ="<a class='font-w600 link-fx'>".$message['username']."</a> <span class='badge badge-pill badge-success'>PERSONNEL</span>";
            $style = "<div style='background:#cce9a4 !important' class='block-content block-content-sm block-content-full bg-body-light'>";
          }
          elseif ($message['sender'] == "Client") {
            if (isset($badge)) {
              $info ="<a class='font-w600 link-fx'>".$message['username']."</a> $badge<div class='font-size-sm text-muted'>".$infoUser['email']."</div>";
            }
            else {
              $info ="<a class='font-w600 link-fx'>".$message['username']."</a><div class='font-size-sm text-muted'>".$infoUser['email']."</div>";
            }
            $style = "<div class='block-content block-content-sm block-content-full bg-body-light'>";
          }?>
          <div class="block block-fx-pop">
              <?=$style?>
                  <div class="media py-3">
                      <div class="mr-3 ml-2 overlay-container overlay-right">
                          <?php $dm->get_avatar(0, 'female', 48); ?>
                          <i class="far fa-circle text-white overlay-item font-size-sm bg-success rounded-circle"></i>
                      </div>
                      <div class="media-body">
                          <div class="row">
                              <div class="col-sm-7">
                                  <?=$info?>
                              </div>
                              <div class="col-sm-5 d-sm-flex align-items-sm-center">
                                  <div class="font-size-sm font-italic text-muted text-sm-right w-100 mt-2 mt-sm-0">
                                      <p class="mb-0"><?php echo date('d-m-Y (H:i)', $message['date']); ?></p>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="block-content" style="padding-bottom: 50px;">
                  <?=htmlspecialchars_decode($message['content'])?>
              </div>
          </div>
        <?php }
        if ($getTicket['status'] != "Closed") { ?>
          <div class="block block-fx-pop">
              <div class="block-content block-content-full">
                <form method="post" action="../inc/form/form.php">
                  <textarea class="js-summernote" data-height="400" name="message"></textarea>
                  <input type="hidden" name="id" value="<?=$id?>">
                  <button name="repondreticketadmin" type="submit" class="btn btn-hero-sm btn-hero-primary mt-2">Send</button>
                  <button name="fermerticketadmin" type="submit" class="btn btn-hero-sm btn-hero-danger mt-2">Close the ticket</button>
                </form>
              </div>
          </div>
        <?php } else { ?>
          <div class="alert alert-danger" role="alert">
              <p class="mb-0">This ticket is closed!</p>
          </div>
        <?php } ?>



          <!-- END Reply -->
      </div>
      <!-- END Main Content -->
  </div>
</div>
<!-- END Page Content -->

<?php require '../inc/_global/views/page_end.php'; ?>
<?php require '../inc/_global/views/footer_start.php'; ?>

<!-- Page JS Plugins -->
<?php $dm->get_js('js/plugins/summernote/summernote-bs4.min.js'); ?>

<!-- Page JS Helpers (Summernote plugin) -->
<script>jQuery(function(){ Dashmix.helpers('summernote'); });</script>

<?php require '../inc/_global/views/footer_end.php'; ?>
