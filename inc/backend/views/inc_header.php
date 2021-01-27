<?php
if (isset($_POST['clearnotif'])){

  $clearnotif = $odb->prepare('SELECT * FROM notif WHERE id_member =?');
  $clearnotif->execute(array($_SESSION['ID']));
  foreach ($clearnotif as $clearnotif) {
    $clear1 = $odb->prepare('UPDATE notif SET view = 1 WHERE id_notif = ? and id_member = ?');
    $clear1->execute(array($clearnotif['id_notif'],$_SESSION['ID']));
  }
}
?>

<header id="page-header">
    <div class="content-header">
        <div>
            <button type="button" class="btn btn-dual mr-1" data-toggle="layout" data-action="sidebar_toggle">
                <i class="fa fa-fw fa-bars"></i>
            </button>
        </div>
        <div>
            <div class="dropdown d-inline-block">
                <button type="button" class="btn btn-dual" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-fw fa-user d-sm-none"></i>
                    <span class="d-none d-sm-inline-block"><?=$_SESSION['username']?></span>
                    <i class="fa fa-fw fa-angle-down ml-1 d-none d-sm-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right p-0" aria-labelledby="page-header-user-dropdown">
                    <div class="bg-primary-darker rounded-top font-w600 text-white text-center p-3">
                       Panel
                    </div>
                    <div class="p-2">
                        <a class="dropdown-item" href="javascript:void(0)" data-toggle="layout" data-action="side_overlay_toggle">
                            <i class="far fa-fw fa-building mr-1"></i> Settings
                        </a>
                        <div role="separator" class="dropdown-divider"></div>
                        <a class="dropdown-item" href="logout.php">
                            <i class="far fa-fw fa-arrow-alt-circle-left mr-1"></i> Logout
                        </a>
                    </div>
                </div>
            </div>
            <?php
            $recupnbNotif = $odb->prepare('SELECT COUNT(*) FROM notif LEFT JOIN allnotifications ON notif.id_notif = allnotifications.id WHERE view = 0 AND id_member = ?');
            $recupnbNotif->execute(array($_SESSION['ID']));
            $recupnbNotif = $recupnbNotif->fetchColumn();
            ?>
            <div class="dropdown d-inline-block">
                <button type="button" class="btn btn-dual" id="page-header-notifications-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-fw fa-bell"></i>
                    <span class="badge badge-secondary badge-pill"><?=$recupnbNotif?></span>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0" aria-labelledby="page-header-notifications-dropdown">
                    <div class="bg-primary-darker rounded-top font-w600 text-white text-center p-3">
                       Notifications
                    </div>
                    <ul class="nav-items my-2">
                      <?php
                      $recupNotif = $odb->prepare('SELECT * FROM notif LEFT JOIN allnotifications ON notif.id_notif = allnotifications.id WHERE view = 0 AND id_member = ?');
                      $recupNotif->execute(array($_SESSION['ID']));
                      foreach ($recupNotif as $recupNotif) { ?>
                        <li>
                            <a class="text-dark media py-2" href="javascript:void(0)">
                                <div class="mx-3">
                                    <i class="fa fa-fw <?=$recupNotif['icone']?> text-success" style="color:<?=$recupNotif['color']?> !important"></i>
                                </div>
                                <div class="media-body font-size-sm pr-2">
                                    <div class="font-w600"><?=$recupNotif['message']?></div>
                                    <div class="text-muted font-italic"><?php echo date('d-m-Y (H:i)', $recupNotif['date']); ?></div>
                                </div>
                            </a>
                        </li>
                      <?php } ?>
                    </ul>
                    <form method="post">
                      <div class="p-2 border-top">
                          <button class="btn btn-light btn-block text-center" type="submit" name="clearnotif">
                              <i class="fa fa-fw fa-eye mr-1"></i> Mark as read
                          </button>
                      </div>
                    </form>
                </div>
            </div>
            <button type="button" class="btn btn-dual" data-toggle="layout" data-action="side_overlay_toggle">
                <i class="far fa-fw fa-list-alt"></i>
            </button>
        </div>
    </div>

    <div id="page-header-loader" class="overlay-header bg-primary-darker">
        <div class="content-header">
            <div class="w-100 text-center">
                <i class="fa fa-fw fa-2x fa-sun fa-spin text-white"></i>
            </div>
        </div>
    </div>
</header>
