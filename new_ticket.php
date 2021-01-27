<?php require 'inc/_global/config.php';
?>
<?php require 'inc/backend/config.php'; ?>
<?php require 'inc/_global/views/head_start.php'; ?>
<?php
if (isset($_POST['envoyerticket'])) {
  $subject = htmlspecialchars($_POST['subject']);
  $content = htmlspecialchars($_POST['content']);

  if ($user->safeString($content)) {
    $erreur = 'Unauthorized character';
  }
  else {
    if (empty($subject) || empty($content)) {
       $erreur = 'All fields are not filled';
    }
      else {
        $SQLCount = $odb->query("SELECT COUNT(*) FROM `tickets` WHERE `username` = '{$_SESSION['username']}' AND `status` = 'Waiting for admin response'")->fetchColumn(0);
        if ($SQLCount > 2) {
            $erreur = 'You have too many open tickets. Please wait until you answer before opening a new one.';
        }
        else {
          $SQLinsert = $odb->prepare("INSERT INTO `tickets` VALUES(NULL, :subject, :content, :status, :username, UNIX_TIMESTAMP())");
          $SQLinsert->execute(array(
              ':subject' => $subject,
              ':content' => $content,
              ':status' => 'Waiting for admin response',
              ':username' => $_SESSION['username']
          ));
          $recupId = $odb->prepare("SELECT * FROM tickets WHERE subject = ?");
          $recupId->execute(array($subject));
          $recupId = $recupId->fetch();

          $_SESSION['success'] = "Your ticket has been successfully created!";
          header('Location: ticket.php?id='.$recupId['id']);
        }
      }
  }

  }
?>
<?php $dm->get_css('js/plugins/summernote/summernote-bs4.css'); ?>
<?php require 'inc/_global/views/head_end.php'; ?>
<?php require 'inc/_global/views/page_start.php'; ?>

<!-- Page Content -->
<div class="row no-gutters flex-md-10-auto">
  <div class="col-md-12">
      <!-- Main Content -->

      <div class="content">
        <?php
        if (isset($erreur)) {
            echo '<div class="animated fadeIn">'.error($erreur).'</div>';
            unset($erreur);
        }
        ?>
          <div class="block block-fx-pop">
              <div class="block-content block-content-full">
                <form method="post">


                  <div class="form-group row">
                      <div class="col-12">
                          <input type="text" class="form-control" placeholder="Subject" name="subject">
                      </div>
                  </div>
                  <textarea class="js-summernote" data-height="100" name="content" required></textarea>
                  <button type="submit" name="envoyerticket" class="btn btn-hero-sm btn-hero-primary mt-2">Send</button>
                </form>
              </div>
          </div>
          <!-- END Reply -->
      </div>
      <!-- END Main Content -->
  </div>
</div>
<!-- END Page Content -->

<?php require 'inc/_global/views/page_end.php'; ?>
<?php require 'inc/_global/views/footer_start.php'; ?>

<!-- Page JS Plugins -->
<?php $dm->get_js('js/plugins/summernote/summernote-bs4.min.js'); ?>

<!-- Page JS Helpers (Summernote plugin) -->
<script>jQuery(function(){ Dashmix.helpers('summernote'); });</script>

<?php require 'inc/_global/views/footer_end.php'; ?>
