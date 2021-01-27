<?php require 'inc/_global/config.php'; ?>
<?php require 'inc/backend/config.php'; ?>
<?php
// Page specific configuration
$dm->l_m_content = '';
?>
<?php require 'inc/_global/views/head_start.php'; ?>

<!-- Page JS Plugins CSS -->
<?php $dm->get_css('js/plugins/summernote/summernote-bs4.css'); ?>

<?php require 'inc/_global/views/head_end.php'; ?>
<?php require 'inc/_global/views/page_start.php'; ?>

<!-- Page Content -->
<div class="row no-gutters flex-md-10-auto">
    <div class="col-md-12">
        <div class="content">
            <!-- Toggle Side Content -->
            <div class="d-md-none push">
                <!-- Class Toggle, functionality initialized in Helpers.coreToggleClass() -->
                <button type="button" class="btn btn-block btn-hero-primary" data-toggle="class-toggle" data-target="#side-content" data-class="d-none">
                    Ticket menu
                </button>
            </div>
            <!-- END Toggle Side Content -->

            <!-- Side Content -->
            <div id="side-content" class="d-none d-md-block push">
                <!-- New Message -->
                <a href="new_ticket.php">
                <button type="button" class="btn btn-block btn-hero-success mb-3">
                    <i class="fa fa-plus mr-1"></i> New ticket
                </button>
                </a>
                <?php
                  $select = $odb->prepare("SELECT * FROM `tickets` WHERE `username` = :uname ORDER BY `id` DESC");
                  $select->execute(array(':uname' => $_SESSION['username']));
                  while($show = $select->fetch(PDO::FETCH_ASSOC))
                  {
                    $recupNbMessage = $odb->prepare("SELECT COUNT(ticketid) FROM messages WHERE ticketid = ?");
                    $recupNbMessage->execute(array($show['id']));
                    $recupNbMessage = $recupNbMessage->fetchColumn();
                    $recupNbMessage = $recupNbMessage+1;
                    if ($show['status'] == "Closed") {
                      $status = "<span class='badge badge-pill badge-danger'>Resolved</span>";
                    }
                    elseif ($show['status'] == "Waiting for user response") {
                      $status = "<span class='badge badge-pill badge-success'>Waiting for your reply</span>";
                    }
                    elseif ($show['status'] == "Waiting for admin response") {
                      $status = "<span class='badge badge-pill badge-warning'>Being processed</span>";
                    }
                    ?>
                    <a class="list-group-item list-group-item-action" href="ticket.php?id=<?php echo $show['id']; ?>">
                        <span class="badge badge-pill badge-dark m-1 float-right"><?=$recupNbMessage?></span>
                        <p class="font-size-h6 font-w700 mb-0">
                            <?php echo $show['subject'];?> <?php  echo $status; ?>
                        </p>
                        <p class="font-size-sm text-muted mb-0">
                            <strong>Create the <?php echo date('d-m-Y', $show['date']); ?>
                        </p>
                    </a>
                  <?php	}	?>

                <!-- <div class="d-flex justify-content-between mb-2">
                    <div class="dropdown">
                        <button type="button" class="btn btn-sm btn-link font-w600 dropdown-toggle" id="inbox-msg-sort" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Sort by
                        </button>
                        <div class="dropdown-menu font-size-sm" aria-labelledby="inbox-msg-sort">
                            <a class="dropdown-item" href="javascript:void(0)">
                                <i class="fa fa-fw fa-sort-amount-down mr-1"></i> Newest
                            </a>
                            <a class="dropdown-item" href="javascript:void(0)">
                                <i class="fa fa-fw fa-sort-amount-up mr-1"></i> Oldest
                            </a>
                        </div>
                    </div>
                    <div class="dropdown">
                        <button type="button" class="btn btn-sm btn-link font-w600 dropdown-toggle" id="inbox-msg-filter" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Filter by
                        </button>
                        <div class="dropdown-menu dropdown-menu-right font-size-sm" aria-labelledby="inbox-msg-filter">
                            <a class="dropdown-item active" href="javascript:void(0)">
                                <i class="fa fa-fw fa-asterisk mr-1"></i> New
                            </a>
                            <a class="dropdown-item" href="javascript:void(0)">
                                <i class="fa fa-fw fa-archive mr-1"></i> Archived
                            </a>
                            <a class="dropdown-item" href="javascript:void(0)">
                                <i class="fa fa-fw fa-times-circle mr-1"></i> Deleted
                            </a>
                        </div>
                    </div>
                </div> -->
                <!-- END Sorting/Filtering -->

                <!-- Messages -->
                <div class="list-group font-size-sm">

                </div>
                <!-- END Messages -->
            </div>
            <!-- END Side Content -->
        </div>
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
