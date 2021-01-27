<?php
ob_start();
require_once '../_global/config.php';
require_once '../_global/views/head_start.php';
require_once '../../vendor/autoload.php';

use RestCord\DiscordClient;
$client = new DiscordClient(['token' => 'NDgzMzY1NTQ3NTEwMzMzNDYx.DpUuBw.yEEr_kbbsMSsmxcJkbeX3-TYXIE']); // YOUR DISCORD TOKEN FOR BOT

if (isset($_POST['repondreticket'])) {
  $updatecontent = htmlspecialchars($_POST['message']);
  $id = htmlspecialchars($_POST['id']);
  $checkTicket = $odb->prepare("SELECT * FROM tickets WHERE id = ?");
  $checkTicket->execute(array($id));
  $checkTicket = $checkTicket->fetch();
  if ($checkTicket['username'] == $_SESSION['username']) {

  if (empty($updatecontent)) {
      $_SESSION['error'] = 'Thanks for entering an answer';
      header('Location: ../../ticket.php?id='.$id);
      exit;
  }
  else {
    if ($user->safeString($updatecontent)) {
        $_SESSION['error'] = 'Unauthorized character';
        header('Location: ../../ticket.php?id='.$id);
        exit;
    }
    else {
      $i= 0;
      $SQLGetMessages = $odb->query("SELECT * FROM `messages` WHERE `ticketid` = '$id' ORDER BY `messageid` DESC LIMIT 1");
      while ($getInfo = $SQLGetMessages->fetch(PDO::FETCH_ASSOC)) {
          if ($getInfo['sender'] == 'Client') {
              $i++;
          }
      }
      if ($i >= 2) {
          $_SESSION['error'] = 'Please wait for an admin to respond until you send a new message';
          header('Location: ../../ticket.php?id='.$id);
          exit;
      }
      $SQLinsert = $odb->prepare("INSERT INTO `messages` VALUES(NULL, :ticketid, :content, :sender, :username, UNIX_TIMESTAMP())");
      $SQLinsert->execute(array(
          ':sender' => 'Client',
          ':content' => $updatecontent,
          ':ticketid' => $id,
          ':username' => $_SESSION['username'],
      ));
      $SQLUpdate = $odb->prepare("UPDATE `tickets` SET `status` = :status WHERE `id` = :id");
      $SQLUpdate->execute(array(
          ':status' => 'Waiting for admin response',
          ':id' => $id
      ));
      $_SESSION['success'] = 'Thank you for your reply !';
      header('Location: ../../ticket.php?id='.$id);
      exit;
    }
  }
  }
  else {
    $_SESSION['error'] = 'An error has occurred !';
    header('Location: ../../ticket.php?id='.$id);
    exit;
  }
}

if (isset($_POST['repondreticketadmin'])) {
  $updatecontent = htmlspecialchars($_POST['message']);
  $id = htmlspecialchars($_POST['id']);

  if (empty($updatecontent)) {
      $_SESSION['error'] = 'Thanks for entering an answer';
      header('Location: ../../admin/ticket.php?id='.$id);
      exit;
  }
  else {
    if ($user->safeString($updatecontent)) {
        $_SESSION['error'] = 'Unauthorized character';
        header('Location: ../../admin/ticket.php?id='.$id);
        exit;
    }
    else {
      $i= 0;
      $SQLGetMessages = $odb->query("SELECT * FROM `messages` WHERE `ticketid` = '$id' ORDER BY `messageid` DESC LIMIT 1");
      while ($getInfo = $SQLGetMessages->fetch(PDO::FETCH_ASSOC)) {
          if ($getInfo['sender'] == 'Client') {
              $i++;
          }
      }
      if ($i >= 2) {
          $_SESSION['error'] = 'Please wait for an admin to respond until you send a new message';
          header('Location: ../../admin/ticket.php?id='.$id);
          exit;
      }

      $SQLinsert = $odb->prepare("INSERT INTO `messages` VALUES(NULL, :ticketid, :content, :sender, :username, UNIX_TIMESTAMP())");
      $SQLinsert->execute(array(
          ':sender' => 'Admin',
          ':content' => $updatecontent,
          ':ticketid' => $id,
          ':username' => $_SESSION['username'],
      ));

      $SQLUpdate = $odb->prepare("UPDATE `tickets` SET `status` = :status WHERE `id` = :id");
      $SQLUpdate->execute(array(
          ':status' => 'Waiting for user response',
          ':id' => $id
      ));
      $_SESSION['success'] = 'Thank you for your reply !';
      header('Location: ../../admin/ticket.php?id='.$id);
      exit;
    }
  }
}

if (isset($_POST['fermerticket'])) {
  $id = htmlspecialchars($_POST['id']);
  $checkTicket = $odb->prepare("SELECT * FROM tickets WHERE id = ?");
  $checkTicket->execute(array($id));
  $checkTicket = $checkTicket->fetch();
  if ($checkTicket['username'] == $_SESSION['username']) {
    $SQLupdate = $odb -> prepare("UPDATE `tickets` SET `status` = :status WHERE `id` = :id");
    $SQLupdate -> execute(array(':status' => 'Closed', ':id' => $id));
    $_SESSION['success'] = 'The ticket has been closed !';
    header('Location: ../../ticket.php?id='.$id);
    exit;
  }
  else {
    $_SESSION['error'] = 'An error has occurred !';
    header('Location: ../../ticket.php?id='.$id);
    exit;
  }

}

if (isset($_POST['fermerticketadmin'])) {
  $id = htmlspecialchars($_POST['id']);
    $SQLupdate = $odb -> prepare("UPDATE `tickets` SET `status` = :status WHERE `id` = :id");
    $SQLupdate -> execute(array(':status' => 'Closed', ':id' => $id));
    $_SESSION['success'] = 'The ticket has been closed!';
    header('Location: ../../admin/ticket.php?id='.$id);
    exit;

}

if (isset($_POST['modifmdp'])) {
  $ancien = SHA1(md5(htmlspecialchars($_POST['ancien'])));
  $password = SHA1(md5(htmlspecialchars($_POST['password'])));
  $password1 = SHA1(md5(htmlspecialchars($_POST['password1'])));
  $recupmdp = $odb->prepare('SELECT * FROM users WHERE id = ?');
  $recupmdp->execute(array($_SESSION['ID']));
  $checkrecupmdp = $recupmdp->rowcount();
  if ($checkrecupmdp == 1) {
    $recupmdp = $recupmdp->fetch();
    if ($recupmdp['password'] == $ancien) {
      if ($password == $password1) {
        $inmdp = $odb->prepare('UPDATE users SET password = ? WHERE ID = ?');
        $inmdp->execute(array($password,$_SESSION['ID']));
        header('Location: ../../index.php');
        exit;
      }
    }
  }
}

if (isset($_GET['report'])){
    $report = htmlspecialchars($_GET['report']);
    $recupLog = $odb->prepare('SELECT * FROM logs WHERE id = ?');
    $recupLog->execute(array($report));
    $recupLog = $recupLog->fetch();

    $compte = "".$recupLog['email'].":".$recupLog['password']."";
    $type = $recupLog['type'];
    $date = date('d-m-Y à h:i:s', $recupLog['date']);


    $_SESSION['report'] = '
<div class="modal fade" id="modal-block-slideup" tabindex="-1" role="dialog" aria-labelledby="modal-block-slideup" style="display: none; padding-right: 17px;">
<div class="modal-dialog modal-dialog-slideup" role="document">
<div class="modal-content">
<div class="block block-themed block-transparent mb-0">
<div class="block-header bg-primary-dark">
<h3 class="block-title">Report of an account</h3>
<div class="block-options">
<button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
<i class="fa fa-fw fa-times"></i>
</button>
</div>
</div>
<form class="form-horizontal push-10-t" method="post" action="inc/form/form.php">
    <div class="block-content">
        <div class="block-content block block-content">
            <div class="form-group">
                <div class="col-sm-12">
                    <div class="form-material">
                        <label for="compte">Account</label>
                        <input value="' . $compte . '" disabled class="form-control" type="text" id="compte" name="compte">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12">
                    <div class="form-material">
                        <label for="type">Type</label>
                        <input value="' . $type . '" disabled class="form-control" type="text" id="type" name="type">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12">
                    <div class="form-material">
                        <label for="dateg">Generation date</label>
                        <input value="' . $date . '" disabled class="form-control" type="text" id="dateg" name="dateg">
                    </div>
                </div>
            </div>
        </div>
    </div>
<div class="block-content block-content-full text-right bg-light">
<div class="col-sm-12"> 
<button name="report_confirm" value="' . $report . '" class="btn btn-sm btn-success" type="submit">Confirm and send the report</button> </div>
</div></form>

</div>
</div>
</div>
</div> ';
    header('Location: ../../generate.php');
    exit;
}

if (isset($_POST['report_confirm'])){
    $idReport = htmlspecialchars($_POST['report_confirm']);

    $verifReport = $odb->prepare('SELECT * FROM logs WHERE id = ?');
    $verifReport->execute(array($idReport));
    $rowcReport = $verifReport->rowCount();
    if($rowcReport == 1){
        $verifReport = $verifReport->fetch();
        if ($_SESSION['username'] == $verifReport['username']){

            $date = time();
            $addReport = $odb->prepare('INSERT INTO report_log(id_log,etat) VALUES(?,?)');
            $addReport->execute(array($verifReport['id'],0));

            $addNotif = $odb->prepare('INSERT INTO allnotifications(message,icone,color,target,date) VALUES(?,?,?,?,?)');
            $addNotif->execute(array("Your postponement has been taken into account replacement you will receive an account shortly", "fas fa-exclamation-triangle","#e04f1a",$_SESSION['ID'],$date));
            $_SESSION['success_report'] = "Your report has been made !";
            header('Location: ../../generate.php');
            exit;
        }
        else{
            $_SESSION['error_report'] = "An error has occurred !";
            header('Location: ../../generate.php');
            exit;
        }

    }
    else{
        $_SESSION['error_report'] = 'An error has occurred !';
        header('Location: ../../generate.php');
        exit;
    }
}

if (isset($_POST['vider_histo'])){

    $_SESSION['report'] = '
<div class="modal fade" id="modal-block-slideup" tabindex="-1" role="dialog" aria-labelledby="modal-block-slideup" style="display: none; padding-right: 17px;">
<div class="modal-dialog modal-dialog-slideup" role="document">
<div class="modal-content">
<div class="block block-themed block-transparent mb-0">
<div class="block-header bg-primary-dark">
<h3 class="block-title">Confirmation of suppression</h3>
<div class="block-options">
<button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
<i class="fa fa-fw fa-times"></i>
</button>
</div>
</div>
<form class="form-horizontal push-10-t" method="post" action="inc/form/form.php">
    <div class="block-content">
        <div class="block-content block block-content">
            <p>Are you sure you want to delete all of your build history ?</p>
            <small>No backtracking is possible.</small>
        </div>
    </div>
<div class="block-content block-content-full text-right bg-light">
<div class="col-sm-12"> 
<button name="vider_confirm" class="btn btn-sm btn-danger" type="submit">Remove</button> </div>
</div></form>

</div>
</div>
</div>
</div> ';
    header('Location: ../../generate.php');
    exit;
}

if (isset($_POST['vider_confirm'])) {
    $viderGen = $odb->prepare('DELETE FROM `logs` WHERE `username` = ?');
    $viderGen->execute(array($_SESSION['username']));

    $_SESSION['success_report'] = "Your history has been emptied !";
    header('Location: ../../generate.php');
    exit;
}

if (isset($_POST['vider_histo_free'])){

    $_SESSION['report'] = '
<div class="modal fade" id="modal-block-slideup" tabindex="-1" role="dialog" aria-labelledby="modal-block-slideup" style="display: none; padding-right: 17px;">
<div class="modal-dialog modal-dialog-slideup" role="document">
<div class="modal-content">
<div class="block block-themed block-transparent mb-0">
<div class="block-header bg-primary-dark">
<h3 class="block-title">Confirmation of suppression</h3>
<div class="block-options">
<button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
<i class="fa fa-fw fa-times"></i>
</button>
</div>
</div>
<form class="form-horizontal push-10-t" method="post" action="inc/form/form.php">
    <div class="block-content">
        <div class="block-content block block-content">
            <p>Are you sure you want to delete all of your build history?</p>
            <small>No backtracking is possible.</small>
        </div>
    </div>
<div class="block-content block-content-full text-right bg-light">
<div class="col-sm-12"> 
<button name="vider_confirm_free" class="btn btn-sm btn-danger" type="submit">Remove</button> </div>
</div></form>

</div>
</div>
</div>
</div> ';
    header('Location: ../../generate_free.php');
    exit;
}

if (isset($_POST['vider_confirm_free'])) {
    $viderGen = $odb->prepare('DELETE FROM `logs_free` WHERE `username` = ?');
    $viderGen->execute(array($_SESSION['username']));

    $_SESSION['success_report'] = "Your history has been emptied !";
    header('Location: ../../generate_free.php');
    exit;
}

if (isset($_GET['paiementpsc'])){
    $id = htmlspecialchars($_GET['id']);
    $recupPlan = $odb->prepare('SELECT * FROM plans WHERE ID = ?');
    $recupPlan->execute(array($id));
    $planInfo = $recupPlan->fetch();


    $_SESSION['achat'] = '
<div class="modal fade" id="modal-block-slideup" tabindex="-1" role="dialog" aria-labelledby="modal-block-slideup" style="display: none; padding-right: 17px;">
<div class="modal-dialog modal-dialog-slideup" role="document">
<div class="modal-content">
<div class="block block-themed block-transparent mb-0">
<div class="block-header bg-primary-dark">
<h3 class="block-title">Purchase grade ['.$planInfo['name'].'] par PSC</h3>
<div class="block-options">
<button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
<i class="fa fa-fw fa-times"></i>
</button>
</div>
</div>
<form class="form-horizontal push-10-t" method="post" action="inc/form/form.php">
    <div class="block-content">
        <div class="block-content block block-content">
            <p>Please enter below the PSC code of the value of the desired grade, in case of surplus please contact us on discord</p>
            <div class="form-group">
                <div class="col-sm-12">
                    <div class="form-material">
                        <label for="compte">PaySafeCard Code</label>
                        <input type="hidden" name="grade" value="'.$planInfo['name'].'">
                        <input class="form-control" type="text" id="codepsc" name="codepsc" placeholder="PaySafeCard Code '.$planInfo['price'].' $">
                    </div>
                </div>
            </div>
        </div>
    </div>
<div class="block-content block-content-full text-right bg-light">
<div class="col-sm-12"> 
<button name="confirm_achat" class="btn btn-sm btn-success" type="submit">Confirm my purchase</button> </div>
</div></form>

</div>
</div>
</div>
</div> ';
    header('Location: ../../shop.php');
    exit;
}

if (isset($_POST['confirm_achat'])) {
    $date = time();
    $grade = htmlspecialchars($_POST['grade']);
    $codepsc = htmlspecialchars($_POST['codepsc']);
    $nbCommande = random_int(1,99999);
    $id = $_SESSION['ID'];
    $addNotif = $odb->prepare('INSERT INTO allnotifications(message,icone,color,target,date) VALUES(?,?,?,?,?)');
    $addNotif->execute(array("Votre commande #$nbCommande à bien été enregistrée et sera traité au plus vite !", "fa-euro-sign","green","$id",$date));

    $addNotif = $odb->prepare('INSERT INTO allnotifications(message,icone,color,target,date) VALUES(?,?,?,?,?)');
    $addNotif->execute(array("Une commande #$nbCommande vient d'être passée pour un grade [$grade], code PSC d'achat : $codepsc | Membre #$id", "fa-euro-sign","green","2",$date));
    $_SESSION['success_report'] = "Votre commande #$nbCommande à bien été enregistrée et sera traité au plus vite !";

    $client->channel->createMessage(['channel.id' => 493009314773204992, 'content' => "Un paiement par PSC à été effectué <@324656218784268291>"]);

    header('Location: ../../generate.php');
    exit;
}

if (isset($_POST['vider_generateur'])){
    if ($_SESSION['ID'] == 2){
        $name = htmlspecialchars($_POST['vider_generateur']);
        $viderTable = $odb->prepare('DELETE FROM `accounts` WHERE type = ?');
        $viderTable->execute(array($name));
        $_SESSION['success_report'] = "La table $name à bien été vidée !";
        header('Location: ../../admin/home.php');
        exit;
    }
}

if (isset($_POST['vider_generateur_free'])){
    if ($_SESSION['ID'] == 2){
        $name = htmlspecialchars($_POST['vider_generateur_free']);
        $viderTable = $odb->prepare('DELETE FROM `accounts_free` WHERE type = ?');
        $viderTable->execute(array($name));
        $_SESSION['success_report'] = "La table $name à bien été vidée !";
        header('Location: ../../admin/home.php');
        exit;
    }
}

if (isset($_POST['addPartner'])){
    $nom = htmlspecialchars($_POST['nom']);
    $description = htmlspecialchars($_POST['description']);
    $lien = htmlspecialchars($_POST['lien']);
    $date = time();
    $gif = htmlspecialchars($_POST['gif']);

    $iPartner = $odb->prepare('INSERT INTO partner(nom,description,lien,date,gif) VALUES (?,?,?,?,?)');
    $iPartner->execute(array($nom,$description,$lien,$date,$gif));
    $_SESSION['success_report'] = "The partner has been added !";
    header('Location: ../../admin/partner.php');
    exit;

}

if (isset($_POST['supp_partner'])){
        $id = htmlspecialchars($_POST['supp_partner']);
        $suppPartner = $odb->prepare('DELETE FROM `partner` WHERE id = ?');
        $suppPartner->execute(array($id));
        $_SESSION['success_report'] = "The partner has been deleted !";
        header('Location: ../../admin/partner.php');
        exit;
}

if (isset($_GET['parrain'])){
    $id = htmlspecialchars($_GET['parrain']);
    $_SESSION['achat'] = '
<div class="modal fade" id="modal-block-slideup" tabindex="-1" role="dialog" aria-labelledby="modal-block-slideup" style="display: none; padding-right: 17px;">
<div class="modal-dialog modal-dialog-slideup" role="document">
<div class="modal-content">
<div class="block block-themed block-transparent mb-0">
<div class="block-header bg-primary-dark">
<h3 class="block-title">Would you like to be a sponsor ?</h3>
<div class="block-options">
<button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
<i class="fa fa-fw fa-times"></i>
</button>
</div>
</div>
<form class="form-horizontal push-10-t" method="post" action="inc/form/form.php">
    <div class="block-content">
        <div class="block-content block block-content">
            <div class="form-group">
                <div class="col-sm-12">
                    <div class="form-material">
                        <label for="compte">If yes, please enter the exact username in the box below (leave empty otherwise)</label>
                        <input type="hidden" name="grade" value="'.$id.'">
                        <input class="form-control" type="text" id="parrain" name="parrain" placeholder="Nickname of the member">
                    </div>
                </div>
            </div>
        </div>
    </div>
<div class="block-content block-content-full text-right bg-light">
<div class="col-sm-12"> 
<button name="confirm_parrain" class="btn btn-sm btn-success" type="submit">Confirm my purchase</button> </div>
</div></form>

</div>
</div>
</div>
</div> ';
    header('Location: ../../shop.php');
    exit;
}

if (isset($_POST['confirm_parrain'])){
    $id = htmlspecialchars($_POST['grade']);
    if (!empty($_POST['parrain'])){
        $parrain = htmlspecialchars($_POST['parrain']);
        if ($parrain == $_SESSION['username']){
            header('Location: ../../buy_plan.php?id='.$id);
            die;
        } else {
            $datecurrent = time();

            $removeOldParrain = $odb->prepare('DELETE FROM parrain WHERE pseudo_member = ? AND etat = 1');
            $removeOldParrain->execute(array($_SESSION['username']));

            $recupPrice = $odb->prepare('SELECT * FROM plans WHERE ID = ?');
            $recupPrice->execute(array($id));
            $recupPrice = $recupPrice->fetch();

            $insertParrainage = $odb->prepare('INSERT INTO parrain(pseudo_member,pseudo_parrain,plan,date,etat) VALUES(?,?,?,?,?)');
            $insertParrainage->execute(array($_SESSION['username'],$parrain,$recupPrice['price'],$datecurrent,1));
        }
        // Etat 1 : En cours de paiement
        // Etat 2 : Payé

    }
    header('Location: ../../buy_plan.php?id='.$id);
    exit;
}

if (isset($_POST['new_code'])){
    $limit = htmlspecialchars($_POST['limit']);
    $type = htmlspecialchars($_POST['type']);
    $name = htmlspecialchars($_POST['name']);
    // Type = 1 : Abo
    // Type = 2 : Générations
    if ($type == 1){
        $duree = htmlspecialchars($_POST['duree']);
        $plan = htmlspecialchars($_POST['plans']);
        $limit = $limit*3600*24;
        $date_c = time();
        $iCode = $odb->prepare('INSERT INTO code(type,name,plan,limit_gen,type_gen,used,date_c,date_u) VALUES(?,?,?,?,?,?,?,?)');
        $iCode->execute(array($type,$name,$plan,$limit,0,0,$date_c,0));
        $_SESSION['success_report'] = "Subscription code create";
        header('Location: ../../admin/code.php');
        exit;
    } elseif ($type == 2){

        $type_gen = htmlspecialchars($_POST['type_gen']);
        $date_c = time();

        $SQLCount = $odb -> prepare("SELECT COUNT(*) FROM `accounts` WHERE `type` = ?");
        $SQLCount -> execute(array($type_gen));
        $SQLCount = $SQLCount->fetch();
        if ($SQLCount['COUNT(*)'] < $limit){
            $_SESSION['success_report'] = "No more accounts available !";
            header('Location: ../../admin/code.php');
            exit;
        } else {
            $iCode = $odb->prepare('INSERT INTO code(type,name,plan,limit_gen,type_gen,used,date_c,date_u) VALUES(?,?,?,?,?,?,?,?)');
            $iCode->execute(array($type,$name,0,$limit,$type_gen,0,$date_c,0));

            $rCode = $odb->prepare('SELECT * FROM code WHERE name = ?');
            $rCode->execute(array($name));
            $rCode = $rCode->fetch();
            for ($i = 0;$i < $limit;$i++) {
                $SQLGen = $odb->prepare("SELECT * FROM `accounts` WHERE `type` = ? ORDER BY RAND() LIMIT 1");
                $SQLGen->execute(array($type_gen));
                $info = $SQLGen->fetch(PDO::FETCH_BOTH);

                $SQLDEL = $odb->prepare("DELETE FROM `accounts` WHERE `id` = ?");
                $SQLDEL->execute(array($info['id']));

                $SQLog = $odb->prepare("INSERT INTO `logs` VALUES (NULL, ?, ?, ?, ?, ?, ?, ?)");
                $SQLog->execute(array($info['email'], $info['password'], $type_gen, $rCode['id'], time(), 0, 0));
            }
            $_SESSION['success_report'] = "Generation code create";
            header('Location: ../../admin/code.php');
            exit;
        }
    }
}

if (isset($_POST['activer_code'])){
    $code = htmlspecialchars($_POST['code']);

    $rCode = $odb->prepare('SELECT * FROM code WHERE name = ? AND used = 0');
    $rCode->execute(array($code));
    $rowcCode = $rCode->rowCount();

    if ($rowcCode == 1){
        $rCode = $rCode->fetch();

        if ($rCode['type'] == 1){
            $date_u = time();
            $newExpire = $date_u+$rCode['limit'];
            $plan = $rCode['plan'];
            $updateSQL = $odb -> prepare("UPDATE `users` SET `expire` = :expire, `membership` = :plan WHERE `ID` = :id");
            $updateSQL -> execute(array(':expire' => $newExpire, ':plan' => (int)$plan, ':id' => $_SESSION['ID']));
            $periode = $rCode['limit_gen']/24/3600;
            $rGrade = $odb->prepare('SELECT * FROM plans WHERE ID = ?');
            $rGrade->execute(array($plan));
            $rGrade = $rGrade->fetch();
            $grade = $rGrade['name'];

            $updateCode = $odb->prepare('UPDATE code SET used = 1,date_u = ? WHERE id = ?');
            $updateCode->execute(array($date_u,$rCode['id']));

            $_SESSION['success'] = "You have activated the key: $code | Rank $grade Until $periode Days";
            header('Location: ../../code.php');
        } elseif ($rCode['type'] == 2){
            $date_u = time();
            $nbGen = $rCode['limit_gen'];
            $typgen = $rCode['type_gen'];
            $updateGen = $odb->prepare('UPDATE logs SET username = ? WHERE username = ?');
            $updateGen->execute(array($_SESSION['username'],$rCode['id']));

            $updateCode = $odb->prepare('UPDATE code SET used = 1,date_u = ? WHERE id = ?');
            $updateCode->execute(array($date_u,$rCode['id']));

            $_SESSION['success'] = "You have activated the key: $code | $nbGen generations of the generator $typgen";
            header('Location: ../../code.php');
        }
    } else {
        $_SESSION['error'] = "Wrong Key";
        header('Location: ../../code.php');
        exit;
    }

}

if (isset($_POST['supprimer_code'])){
    $id = htmlspecialchars($_POST['supprimer_code']);

    $supCode = $odb->prepare('DELETE FROM code WHERE id = ?');
    $supCode->execute(array($id));
    $_SESSION['success_report'] = "Code removed !";
    header('Location: ../../admin/code.php');
    exit;
}
