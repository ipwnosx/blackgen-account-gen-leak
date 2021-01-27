<?php require 'inc/_global/config.php'; ?>
<?php require 'inc/backend/config.php'; ?>

<?php require 'inc/_global/views/head_start.php'; ?>

<?php $dm->get_css('js/plugins/datatables/dataTables.bootstrap4.css'); ?>
<?php $dm->get_css('js/plugins/datatables/buttons-bs4/buttons.bootstrap4.min.css'); ?>

<?php require 'inc/_global/views/head_end.php'; ?>
<?php if (isset($_POST['delete'])) {
    $delete = $_POST['delete'];
    $SQL = $odb -> prepare("SELECT * FROM `logs` WHERE `id` = ?");
    $SQL -> execute(array($delete));
    $verif = $SQL->fetch();
    if ($verif['username'] == $_SESSION['username']) {
        $SQL = $odb -> prepare("UPDATE `logs` SET `visible` = ? WHERE `id` = ?");
        $SQL -> execute(array(1,$delete));
    }
}

if (isset($_POST['favori'])) {
    $favori = $_POST['favori'];
    $SQL = $odb -> prepare("SELECT * FROM `logs` WHERE `id` = ?");
    $SQL -> execute(array($favori));
    $verif = $SQL->fetch();
    if ($verif['username'] == $_SESSION['username']) {
        $SQL = $odb -> prepare("UPDATE `logs` SET `favori` = ? WHERE `id` = ?");
        $SQL -> execute(array(1,$favori));
        echo "Success";
    }
}

if (isset($_POST['delfavori'])) {
    $delfavori = $_POST['delfavori'];
    $SQL = $odb -> prepare("SELECT * FROM `logs` WHERE `id` = ?");
    $SQL -> execute(array($delfavori));
    $verif = $SQL->fetch();
    if ($verif['username'] == $_SESSION['username']) {
        $SQL = $odb -> prepare("UPDATE `logs` SET `favori` = ? WHERE `id` = ?");
        $SQL -> execute(array(0,$delfavori));
    }
} ?>
<?php require 'inc/_global/views/page_start.php';


?>

<!-- Hero -->
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">My account history</h1>
            <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Generator</li>
                    <li class="breadcrumb-item active" aria-current="page">History</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<!-- END Hero -->

<!-- Page Content -->
<div class="content">
    <?php
    if (isset($_SESSION['error_report'])) {
        echo '<div class="animated fadeIn">'.error($_SESSION['error_report']).'</div>';
        unset($_SESSION['error_report']);
    }
    if (isset($_SESSION['success_report'])) {
        echo '<div class="animated fadeIn">'.success($_SESSION['success_report']).'</div>';
        unset($_SESSION['success_report']);
    }
    ?>
    <div id="resultat"></div>


    <?php
    $SQLSelect1 = $odb->query("SELECT * FROM `logs` WHERE `username`='{$_SESSION['username']}' AND visible = 0 AND favori = 1 ORDER BY date DESC");
    $test = $SQLSelect1->rowCount();
    if ($test < 1) { }
    else { ?>

        <div class="block block-rounded block-bordered">
            <div class="block-header block-header-default">
                <h3 class="block-title">Table of your favorite accounts</h3>
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
                    while ($show1 = $SQLSelect1->fetch(PDO::FETCH_ASSOC))
                    {
                        $email = $show1['email'];
                        $password = $show1['password'];
                        $type = $show1['type'];
                        $date = $show1['date'];
                        $idproduit = $show1['id'];

                        ?>
                        <tr>
                            <td class="text-center"><?php echo $idproduit; ?></td>
                            <td class="font-w600">
                                <?php echo $email;?>
                            </td>
                            <td class="d-none d-sm-table-cell">
                                <em class="text-muted"><?php echo $password;?></em>
                            </td>
                            <td class="d-none d-sm-table-cell">
                                <span class="badge badge-primary"><?php echo $type; ?></span>
                            </td>
                            <td>
                                <em class="text-muted"><span style="display: none;"><?php echo date('Ymd', $date); ?></span><?php echo date('d/m/Y', $date); ?></em>
                            </td>
                            <td>
                                <form method="post">
                                    <div class="btn-group btn-group-sm mr-2 mb-2" role="group" aria-label="Small Outline Secondary Second group">
                                        <button name="delfavori" value="<?=$idproduit?>" type="submit" class="btn btn-outline-info"><i class="far fa-window-close"></i></button>
                                        <button name="delete" value="<?=$idproduit?>" type="submit" class="btn btn-outline-danger"><i class="far fa-trash-alt"></i></button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php } ?>
    <div class="block block-rounded block-bordered">
        <div class="block-header block-header-default">
            <h3 class="block-title">Dynamic list of all your generations</h3>
            <div class="block-options">
                <form action="inc/form/form.php" method="post">
                    <button type="submit" name="vider_histo" class="btn btn-sm btn-outline-danger">Delete my history</button>
                </form>
            </div>
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
                $SQLSelect = $odb->prepare('SELECT * FROM `logs` LEFT JOIN report_log ON logs.id = report_log.id_log WHERE `username`= ? AND visible = 0 AND favori = 0 ORDER BY date DESC');
                $SQLSelect->execute(array($_SESSION['username']));
                foreach ($SQLSelect as $show)
                {
                    $type = $show['type'];
                    $date = $show['date'];
                    $idproduit = $show['id'];
                    if($show['etat'] != NULL){
                        if ($show['etat'] == 1)
                        {
                            $email = '<span class="badge badge-success">ACCOUNT REPLACE</span>';
                            $password = '<span class="badge badge-success">ACCOUNT REPLACE</span>';
                        } elseif ($show['etat'] == 2){
                            $email = $show['email'];
                            $password = $show['password'];
                        }
                        else{
                            $email = '<span class="badge badge-danger">ACCOUNT BEING VERIFIED</span>';
                            $password = '<span class="badge badge-danger">ACCOUNT BEING VERIFIED</span>';
                        }
                    }
                    else{
                        $email = $show['email'];
                        $password = $show['password'];
                    }

                    ?>
                    <tr>
                        <td class="text-center"><?php echo $idproduit; ?></td>
                        <td class="font-w600">
                            <?php echo $email;?>
                        </td>
                        <td class="d-none d-sm-table-cell">
                            <em class="text-muted"><?php echo $password;?></em>
                        </td>
                        <td class="d-none d-sm-table-cell">
                            <span class="badge badge-primary"><?php echo $type; ?></span>
                        </td>
                        <td>
                            <em class="text-muted"><span style="display: none;"><?php echo date('Ymd', $date); ?></span><?php echo date('d/m/Y', $date); ?></em>
                        </td>
                        <td>
                            <?php
                            if($show['etat'] == NULL)
                            { ?>
                                <form method="post">
                                    <div class="btn-group btn-group-sm mr-2 mb-2" role="group" aria-label="Small Outline Secondary Second group">
                                        <button name="favori" value="<?=$idproduit?>" type="submit" class="btn btn-outline-info"><i class="far fa-plus-square"></i></button>
                                        <a href="inc/form/form.php?report=<?=$idproduit?>" class="btn btn-outline-warning"><i class="fas fa-exclamation-triangle"></i></a>
                                        <button name="delete" value="<?=$idproduit?>" type="submit" class="btn btn-outline-danger"><i class="far fa-trash-alt"></i></button>
                                    </div>
                                </form>
                            <?php }
                            ?>

                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
<!-- END Page Content -->

<?php require 'inc/_global/views/page_end.php'; ?>
<?php require 'inc/_global/views/footer_start.php'; ?>

<!-- Page JS Plugins -->
<?php $dm->get_js('js/plugins/datatables/jquery.dataTables.min.js'); ?>
<?php $dm->get_js('js/plugins/datatables/dataTables.bootstrap4.min.js'); ?>
<?php $dm->get_js('js/plugins/datatables/buttons/dataTables.buttons.min.js'); ?>
<?php $dm->get_js('js/plugins/datatables/buttons/buttons.print.min.js'); ?>
<?php $dm->get_js('js/plugins/datatables/buttons/buttons.html5.min.js'); ?>
<?php $dm->get_js('js/plugins/datatables/buttons/buttons.flash.min.js'); ?>
<?php $dm->get_js('js/plugins/datatables/buttons/buttons.colVis.min.js'); ?>
<!-- Page JS Code -->
<?php
if (isset($_SESSION['report'])){
    echo $_SESSION['report'];
    echo "<script>jQuery('#modal-block-slideup').modal('show');</script>";
    unset($_SESSION['report']);
}
?>

<?php $dm->get_js('js/pages/be_tables_datatables.min.js'); ?>

<?php require 'inc/_global/views/footer_end.php'; ?>
