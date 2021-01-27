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
    <h3 class="block-title">Last 5 accounts generated</h3>
</div>
<table class="table table-borderless table-vcenter table-hover">
    <thead>
    <tr>
        <th class="text-center" style="width: 50px;">#</th>
        <th>Email</th>
        <th>Password</th>
        <th>Account type</th>
        <th>Date</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $SQLSelect = $odb->query("SELECT * FROM `logs_free` WHERE `username`='{$_SESSION['username']}' AND `visible` = 0 ORDER BY `id` DESC LIMIT 5");
    while ($show = $SQLSelect->fetch(PDO::FETCH_ASSOC))
    {
        $idlog = $show['id'];
        $email = $show['email'];
        $password = $show['password'];
        $type = $show['type'];
        $date = $show['date'];
        echo '
											<tr class="table-active">
													<th class="text-center" scope="row">'.$idlog.'</th>
													<td class="font-w600">'.$email.'</td>
													<td class="font-w600">'.$password.'</td>
													<td class="d-none d-sm-table-cell">
                            <span class="badge badge-primary">'.$type.'</span>
                        	</td>
													<td class="font-w600">'. date('d-m-Y', $date) .'</td>
													<td class="text-center"></td>
											</tr>';
    }?>
    </tbody>
</table>
