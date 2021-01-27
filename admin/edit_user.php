<?php require '../inc/_global/config.php'; ?>
<?php require '../inc/dashboards/modern/config.php'; ?>
<?php require '../inc/_global/views/head_start.php'; ?>
<?php require '../inc/dashboards/modern/views/check.php'; ?>
<?php
if (isset($_GET['id']) AND !empty($_GET['id'])) {
  $id = htmlspecialchars($_GET['id']);
  $getUser = $odb->prepare('SELECT * FROM users WHERE ID = ?');
  $getUser->execute(array($id));
  if($getUser->rowCount() == 1)
  {
    $getUser = $getUser->fetch();
    $getIP = $odb->prepare('SELECT `ip` FROM `loginlogs` WHERE `username` = ? ORDER BY date DESC LIMIT 1'); 
    $getIP->execute(array($getUser['username']));
    if($getIP->rowCount() == 1) {
        $getIP = $getIP->fetch();
        $latestIP = $getIP['ip'];
    }
  }
  else
  {
     header("Location: index.php");
  }
}
else {
  header('Location: index.php');
}

if (isset($_POST['update'])) {
    if ($user -> isAdmin($odb)) {
        if ($getUser['username'] != $_POST['username']) {
            if (ctype_alnum($_POST['username']) && strlen($_POST['username']) >= 4 && strlen($_POST['username']) <= 15) {
                $SQL = $odb -> prepare("UPDATE `users` SET `username` = :username WHERE `ID` = :id");
                $SQL -> execute(array(':username' => $_POST['username'], ':id' => $id));
                $update = true;
                $username = $_POST['username'];
            } else {
                $error = 'Le nom d\'utilisateur doit être composé de 4 à 15 caractères alphanumériques.';
            }
        }
        if (!empty($_POST['password'])) {
            $SQL = $odb -> prepare("UPDATE `users` SET `password` = :password WHERE `ID` = :id");
            $SQL -> execute(array(':password' => SHA1(md5($_POST['password'])), ':id' => $id));
            $update = true;
        }
        if ($getUser['email'] != $_POST['email']) {
            if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $SQL = $odb -> prepare("UPDATE `users` SET `email` = :email WHERE `ID` = :id");
                $SQL -> execute(array(':email' => $_POST['email'], ':id' => $id));
                $update = true;
                $email = $_POST['email'];
            } else {
                $error = 'L\'email n\'est pas valide';
            }
        }
        if ($getUser['rank'] != $_POST['rank']) {
            $SQL = $odb -> prepare("UPDATE `users` SET `rank` = :rank WHERE `ID` = :id");
            $SQL -> execute(array(':rank' => $_POST['rank'], ':id' => $id));
            $update = true;
            $updateMsg = "Le grade de l'utilisateur est passé de {$getUser['rank']} à {$_POST['rank']}";
            $rank = $_POST['rank'];
        }
        if ($getUser['expire'] != strtotime($_POST['expire'])) {
            $SQL = $odb -> prepare("UPDATE `users` SET `expire` = :expire WHERE `ID` = :id");
            $SQL -> execute(array(':expire' => strtotime($_POST['expire']), ':id' => $id));
            $update = true;
            $updateMsg = "La durée de l'abonnement est passé de {$getUser['expire']} à {$_POST['expire']}";
            $expire = strtotime($_POST['expire']);
        }
        if ($getUser['status'] != $_POST['status']) {
            $SQL = $odb -> prepare("UPDATE `users` SET `status` = :status WHERE `ID` = :id");
            $SQL -> execute(array(':status' => $_POST['status'], ':id' => $id));
            $status = $_POST['status'];
            $reason = $_POST['reason'];
            $SQLinsert = $odb -> prepare('INSERT INTO `bans` VALUES(:username, :reason)');
            $SQLinsert -> execute(array(':username' => $username, ':reason' => $reason));
            $update = true;
        }
    }
    if ($getUser['membership'] != $_POST['plan']) {
        if ($_POST['plan'] == 0) {
            if ($user -> isAdmin($odb)) {
                $SQL = $odb -> prepare("UPDATE `users` SET `expire` = '0', `membership` = '0' WHERE `ID` = :id");
                $SQL -> execute(array(':id' => $id));
                $update = true;
                $updateMsg = "The user's subscription has been deleted";
                $membership = $_POST['plan'];
            } else {
                $error = "You cannot delete subscriptions!";
            }
        } else {
                if ($user -> isAdmin($odb)) {
                    $getPlanInfo = $odb -> prepare("SELECT `unit`,`length`,`name` FROM `plans` WHERE `ID` = :plan");
                    $getPlanInfo -> execute(array(':plan' => $_POST['plan']));
                    $plan = $getPlanInfo -> fetch(PDO::FETCH_ASSOC);
                    $unit = $plan['unit'];
                    $length = $plan['length'];
                    $name = $plan['name'];
                    $newExpire = strtotime("+{$length} {$unit}");
                    $updateSQL = $odb -> prepare("UPDATE `users` SET `expire` = :expire, `membership` = :plan WHERE `id` = :id");
                    $updateSQL -> execute(array(':expire' => $newExpire, ':plan' => $_POST['plan'], ':id' => $id));
                    $update = true;
                    $updateMsg = "The user's subscription has been updated : {$name}";
                    $membership = $_POST['plan'];
                } else {
                    $error = "You don't have the right to give subscriptions!";
                }
              }
    }
    if ($update == true) {
        $notify = success('User updated');
        if (!empty($updateMsg)) {
            $actionSQL = $odb->prepare("INSERT INTO `actions` VALUES (NULL,?,?,?,?)");
            $actionSQL->execute(array($_SESSION['username'],$getUser['username'],$updateMsg,time()));
        }
        header('Location: users.php');
    } else {
        $notify = error('No changes have been made');
    }
    if (!empty($error)) {
        $notify = error($error);
    }
}
function selectedR($b, $a)
{
    if ($a == $b) {
        return 'selected="selected"';
    }
}
?>
<?php $dm->get_css('js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css'); ?>
<?php require '../inc/_global/views/head_end.php'; ?>
<?php require '../inc/_global/views/page_start.php'; ?>

<?php include 'bandeau.php'; ?>
<div class="content">
  <?php		if(isset($notify)){			echo '<div class="col-md-12">' . $notify . "</div>";		}		?>
  <form method="post">
        <div class="block block-rounded block-bordered">
            <div class="block-header block-header-default">
                <h3 class="block-title">Editer l'utilisateur <?=$getUser['username']?></h3>
                <div class="block-options">
                    <button type="submit" class="btn btn-sm btn-light" name="update">
                        <i class="fa fa-fw fa-check"></i> Mettre à jour
                    </button>
                </div>
            </div>
            <div class="block-content block-content-full">
                <div class="">
                    <div class="row items-push">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="val-username">Pseudo <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="val-username" name="username" value="<?=$getUser['username']?>">
                            </div>
                            <div class="form-group">
                                <label for="val-email">Email <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="val-email" name="email" value="<?=$getUser['email']?>">
                            </div>
                            <div class="form-group">
                                <label for="val-password">Nouveau mot de passe <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="val-password" name="password" placeholder="Laisser vide si aucun changement">
                            </div>
                            <div class="form-group">
                                <label for="val-skill">Grade <span class="text-danger">*</span></label>
                                <select class="form-control" id="val-skill" name="rank">
                                    <option value="1" <?php echo selectedR(1, $getUser['rank']); ?>>Administrateur</option>
                                    <option value="3" <?php echo selectedR(3, $getUser['rank']); ?>>Modérateur</option>
                                    <option value="2" <?php echo selectedR(2, $getUser['rank']); ?>>Support</option>
                                    <option value="0" <?php echo selectedR(0, $getUser['rank']); ?>>Membre</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="val-skill">Abonnement <span class="text-danger">*</span></label>
                                <select class="form-control" id="val-skill" name="plan">
                                  <option value="0" selected>Aucun abonnement</option>
                                    <?php
                                    $rAbo = $odb->query('SELECT * FROM plans');
                                    foreach ($rAbo as $rAbo) { ?>
                                          <option value="<?=$rAbo['ID']?>" <?php echo selectedR($rAbo['ID'], $getUser['membership']); ?>><?=$rAbo['name']?></option>
                                      <?php } ?>

                                </select>
                            </div>
                            <div class="form-group">
                                <label for="val-email">Expiration de l'abonnement le <span class="text-danger">*</span></label>
                                <input type="text" class="js-datepicker form-control" id="example-datepicker3" name="expire" data-week-start="1" data-autoclose="true" data-today-highlight="true" data-date-format="dd-mm-yyyy" value="<?php echo date("d-m-Y", $getUser['expire']); ?>">
                            </div>
                            <div class="form-group">
                                <label for="val-skill">Status <span class="text-danger">*</span></label>
                                <select class="form-control" id="val-skill" name="status">
                                  <option value="0" <?php echo selectedR(0, $getUser['status']); ?>>Actif</option>
                                  <option value="1" <?php echo selectedR(1, $getUser['status']); ?>>Banni</option>
                                  <option value="2" <?php echo selectedR(2, $getUser['status']); ?>>Averti</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="val-email">Raison du bannissement / avertissement <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="val-email" name="reason">
                            </div>
                        </div>
                        <div class="col-xl-12 invisible" data-toggle="appear" data-timeout="200">
                            <!-- Purchases -->
                            <div class="block block-rounded block-mode-loading-refresh">
                                <div class="block-header block-header-default">
                                    <h3 class="block-title">Historique d'achats</h3>
                                </div>
                                <div class="block-content">
                                    <table class="table table-striped table-hover table-borderless table-vcenter font-size-sm">
                                        <thead>
                                        <tr class="text-uppercase">
                                            <th class="font-w700">Abonnement</th>
                                            <th class="d-none d-sm-table-cell font-w700">Date</th>
                                            <th class="font-w700">Statut</th>
                                            <th class="d-none d-sm-table-cell font-w700 text-right" style="width: 120px;">Prix</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $get5lastpurchase = $odb->prepare('SELECT * FROM payments WHERE user = ?');
                                        $get5lastpurchase->execute(array($getUser['ID']));



                                        foreach ($get5lastpurchase as $last) {
                                            $rPlan = $odb->prepare('SELECT * FROM plans WHERE ID = ?');
                                            $rPlan->execute(array($last['plan']));
                                            $rPlan = $rPlan->fetch();
                                            $abo = "<span class='badge badge-danger' style='background:".$rPlan['color']."'>".$rPlan['name']."</span>";?>
                                            <tr>
                                                <td>
                                                    <span class="font-w600"><?=$abo?></span>
                                                </td>
                                                <td class="d-none d-sm-table-cell">
                                                    <span class="font-size-sm text-muted"><?php echo date("m-d-Y, h:i:s" ,$last['date']);	 ?></span>
                                                </td>
                                                <td>
                                                    <span class="font-w600 text-success">Terminé</span>
                                                </td>
                                                <td class="d-none d-sm-table-cell text-right">
                                                    <?=$last['paid']?> €
                                                </td>
                                            </tr>
                                        <?php }
                                        ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- END Purchases -->
                        </div>
                        <div class="row items-push">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Most Recent IP: <?= $latestIP ?></label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row items-push">
                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-primary" name="update">Mettre à jour</button>
                        </div>
                    </div>
                    <!-- END Submit -->
                </div>
            </div>
        </div>
    </form>
</div>

<?php require '../inc/_global/views/page_end.php'; ?>
<?php require '../inc/_global/views/footer_start.php'; ?>
<?php $dm->get_js('js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js'); ?>
<script>jQuery(function(){ Dashmix.helpers(['datepicker']); });</script>
<?php require '../inc/_global/views/footer_end.php'; ?>
