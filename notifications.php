<?php require 'inc/_global/config.php'; ?>
<?php require 'inc/backend/config.php'; ?>
<?php require 'inc/_global/views/head_start.php'; ?>
<?php require 'inc/_global/views/head_end.php'; ?>
<?php require 'inc/_global/views/page_start.php'; ?>


<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">List of all your notifications</h1>
            <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Personal space</li>
                    <li class="breadcrumb-item active" aria-current="page">Notifications</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<div class="content">
    <div class="block block-rounded block-bordered">
        <div class="block-content block-content-full">
            <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _es6/pages/be_tables_datatables.js -->
            <table class="table table-bordered table-striped table-vcenter js-dataTable-full">
                <thead>
                <tr>
                    <th class="text-center" style="width: 80px;">#</th>
                    <th class="d-none d-sm-table-cell" style="width: 15%;">Users</th>
                    <th>Message</th>
                    <th class="d-none d-sm-table-cell" style="width: 15%;">Read</th>
                    <th class="d-none d-sm-table-cell" style="width: 15%;">Date</th>
                </tr>
                </thead>
                <tbody>

                <?php
                $rNotif = $odb->prepare('SELECT * FROM notif INNER JOIN users ON notif.id_member = users.ID INNER JOIN allnotifications ON notif.id_notif = allnotifications.id WHERE username = ? ORDER BY notif.id DESC');
                $rNotif->execute(array($_SESSION['username']));
                foreach ($rNotif as $rNotif) {
                    if ($rNotif['view'] == 1) {
                        $view = "Yes";
                    }
                    elseif ($rNotif['view'] == 0) {
                        $view = "No";
                    }
                    ?>
                    <tr>
                        <td class="text-center"><?php echo $rNotif['id']; ?></td>
                        <td class="font-w600">
                            <?=$rNotif['username']?>
                        </td>
                        <td class="d-none d-sm-table-cell">
                            <i class="fa <?=$rNotif['icone']?>" style="color:<?=$rNotif['color']?>"></i>  <?=$rNotif['message']?>
                        </td>
                        <td>
                            <?=$view?>
                        </td>
                        <td>
                            <?php echo date('d-m-Y (H:i)', $rNotif['date']); ?>
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

<?php $dm->get_js('js/pages/be_tables_datatables.min.js'); ?>
<?php require 'inc/_global/views/page_end.php'; ?>
<?php require 'inc/_global/views/footer_start.php'; ?>
<?php require 'inc/_global/views/footer_end.php'; ?>
