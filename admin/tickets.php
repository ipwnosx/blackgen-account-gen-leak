<?php require '../inc/_global/config.php'; ?>
<?php require '../inc/dashboards/modern/config.php'; ?>
<?php require '../inc/_global/views/head_start.php'; ?>
<?php require '../inc/dashboards/modern/views/check.php'; ?>
<?php require '../inc/_global/views/head_end.php'; ?>
<?php require '../inc/_global/views/page_start.php'; ?>

<?php include 'bandeau.php'; ?>

<div class="row no-gutters flex-md-10-auto">
    <div class="col-md-12">
        <div class="content">
            <!-- Toggle Side Content -->
            <div class="d-md-none push">
                <!-- Class Toggle, functionality initialized in Helpers.coreToggleClass() -->
                <button type="button" class="btn btn-block btn-hero-primary" data-toggle="class-toggle" data-target="#side-content" data-class="d-none">
                    Menu des tickets
                </button>
            </div>
            <!-- END Toggle Side Content -->

            <!-- Side Content -->
            <div id="side-content" class="d-none d-md-block push">
                <?php
                  $select = $odb->prepare("SELECT * FROM `tickets` WHERE status != ? ORDER BY `id` DESC");
                  $select->execute(array("Closed"));
                  while($show = $select->fetch(PDO::FETCH_ASSOC))
                  {
                    $recupNbMessage = $odb->prepare("SELECT COUNT(ticketid) FROM messages WHERE ticketid = ?");
                    $recupNbMessage->execute(array($show['id']));
                    $recupNbMessage = $recupNbMessage->fetchColumn();
                    $recupNbMessage = $recupNbMessage+1;
                    if ($show['status'] == "Closed") {
                      $status = "<span class='badge badge-pill badge-danger'>Résolu</span>";
                    }
                    elseif ($show['status'] == "Waiting for user response") {
                      $status = "<span class='badge badge-pill badge-success'>Awaiting response from a member</span>";
                    }
                    elseif ($show['status'] == "Waiting for admin response") {
                      $status = "<span class='badge badge-pill badge-info'>Awaiting response from a staff member</span>";
                    }
                    ?>
                    <a class="list-group-item list-group-item-action" href="ticket.php?id=<?php echo $show['id']; ?>">
                        <span class="badge badge-pill badge-dark m-1 float-right"><?=$recupNbMessage?></span>
                        <p class="font-size-h6 font-w700 mb-0">
                            <?php echo $show['subject'];?> <?php  echo $status; ?>
                        </p>
                        <p class="font-size-sm text-muted mb-0">
                            <strong>Créer le <?php echo date('d-m-Y', $show['date']); ?>
                        </p>
                    </a>
                  <?php	}	?>

                <div class="list-group font-size-sm">

                </div>
                <!-- END Messages -->
            </div>
            <!-- END Side Content -->
        </div>
    </div>
</div>
<?php require '../inc/_global/views/page_end.php'; ?>
<?php require '../inc/_global/views/footer_start.php'; ?>
<?php require '../inc/_global/views/footer_end.php'; ?>
