<?php	ob_start();
require_once '../../../_global/config.php';

if (!($user->LoggedIn()) || !($user->notBanned($odb)) || !(isset($_SERVER['HTTP_REFERER'])))
{
  die();
}
if (!($user->hasMembership($odb)) && $testboots == 0)
{
  die();
}
$username = $_SESSION['username'];?>
<div class="block-header block-header-default">
    <h3 class="block-title">10 derniers lots</h3>
</div>
<table class="table table-borderless table-vcenter table-hover">
    <thead>
    <tr>
        <th class="text-center" style="width: 50px;">#</th>
        <th>Pseudo</th>
        <th>Lot</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $SQLSelect = $odb->query("SELECT * FROM `logs_loterie` INNER JOIN lots ON logs_loterie.lot = lots.id_lot ORDER BY logs_loterie.id DESC LIMIT 10");
    while ($show = $SQLSelect->fetch(PDO::FETCH_ASSOC))
    {
        $idLot = $show['id'];
        $username = $show['username'];
        $nom_lot = $show['nom'];
        echo '
											<tr class="table-active">
													<th class="text-center" scope="row">'.$idLot.'</th>
													<td class="font-w600">'.$username.'</td>
													<td class="font-w600">'.$nom_lot.'</td>
											</tr>';
    }?>
    </tbody>
</table>
