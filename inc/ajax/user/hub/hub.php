<?php
ob_start();
	require_once '../../../_global/config.php';

	if (!$user->LoggedIn() || !$user->notBanned($odb) || !$user->hasMembership($odb) || empty($_GET['type'])){		die();
        	}
          $type     = $_GET['type'];
	      $username = $_SESSION['username'];
	      if (isset($_GET['nb']) && !empty($_GET['nb'])){
              $nb = $_GET['nb'];
              $cStock = $odb->prepare('SELECT COUNT(*) as stock FROM accounts WHERE type = ?');
              $cStock->execute(array($type));
              $cStock = $cStock->fetch();
              if ($cStock['stock']/10 > $nb){
                for ($i = 0;$i < $nb;$i++){
                    $SQLCount = $odb -> prepare("SELECT * FROM `users` WHERE `username` = ?");
                    $SQLCount -> execute(array($username));
                    $membership = $SQLCount -> fetch(PDO::FETCH_BOTH)['membership'];
                    $SQLCount = $odb -> prepare("SELECT * FROM `plans` WHERE `ID` = ?");
                    $SQLCount -> execute(array($membership));
                    $show = $SQLCount -> fetch(PDO::FETCH_ASSOC);
                    $limit = $show['limit'];
                    $accounts = $show['accounts'];
                    // Lots
                    $SQLCheck = $odb -> prepare("SELECT COUNT(*) FROM `logs` WHERE `username` = ? AND `date` > ?");
                    $SQLCheck -> execute(array($username, strtotime(date('d-m-Y 00:00:00'))));
                    if($SQLCheck -> fetchColumn(0) >= $limit)
                    {
                        $recupLot = $odb->prepare('SELECT * FROM logs_loterie WHERE username = ? AND used = 0');
                        $recupLot->execute(array($username));
                        $rowcLot = $recupLot->rowCount();
                        if($rowcLot == 1)
                        {
                            $recupLot = $recupLot->fetch();
                            if ($recupLot['nb'] == 0) {
                                $sLot = $odb->prepare('UPDATE logs_loterie SET used = 1 WHERE id = ?');
                                $sLot->execute(array($recupLot['id']));
                                die(error('Trop de comptes générés aujourd\'hui à partir de votre compte.'));
                            } else {
                                $limit = $limit + $recupLot['max'];
                                $newnb = $recupLot['nb'] - 1;
                                $sLot = $odb->prepare('UPDATE logs_loterie SET nb = ? WHERE id = ?');
                                $sLot->execute(array($newnb, $recupLot['id']));
                            }
                        } else {
                            die(error('Trop de comptes générés aujourd\'hui à partir de votre compte.'));
                        }
                    }


                    $match = false;	$accounts_array = explode(',', $accounts);
                    foreach($accounts_array as $acc)
                    {
                        if($acc == $type)
                        {
                            $match = true;
                        }
                    }
                    if($match == false)
                    {
                        die(error('Votre abonnement ne vous permet pas de générer ce type de compte !'));
                    }
                    $SQLCount = $odb -> prepare("SELECT COUNT(*) FROM `accounts` WHERE `type` = ?");
                    $SQLCount -> execute(array($type));
                    if($SQLCount -> fetchColumn(0) == 0)
                    {
                        die(error('Plus aucun compte n\'est disponible'));
                    }
                    $SQLGen = $odb -> prepare("SELECT * FROM `accounts` WHERE `type` = ? ORDER BY RAND() LIMIT 1");
                    $SQLGen -> execute(array($type));
                    $info = $SQLGen -> fetch(PDO::FETCH_BOTH);

                    $SQLDEL = $odb -> prepare("DELETE FROM `accounts` WHERE `id` = ?");
                    $SQLDEL -> execute(array($info['id']));

                    $SQLog = $odb -> prepare("INSERT INTO `logs` VALUES (NULL, ?, ?, ?, ?, ?, ?, ?)");
                    $SQLog -> execute(array($info['email'], $info['password'], $type, $username, time(), 0, 0));

                }
                  die(success('Vous venez de générer '.$nb.' comptes !'));
              } else {
                  die(error('Le stock actuel ne permet pas ce nombre de générations !'));
              }
          } else {
              $SQLCount = $odb -> prepare("SELECT * FROM `users` WHERE `username` = ?");
              $SQLCount -> execute(array($username));
              $membership = $SQLCount -> fetch(PDO::FETCH_BOTH)['membership'];
              $SQLCount = $odb -> prepare("SELECT * FROM `plans` WHERE `ID` = ?");
              $SQLCount -> execute(array($membership));
              $show = $SQLCount -> fetch(PDO::FETCH_ASSOC);
              $limit = $show['limit'];
              $accounts = $show['accounts'];
              // Lots


              $SQLCheck = $odb -> prepare("SELECT COUNT(*) FROM `logs` WHERE `username` = ? AND `date` > ?");
              $SQLCheck -> execute(array($username, strtotime(date('d-m-Y 00:00:00'))));
              if($SQLCheck -> fetchColumn(0) >= $limit)
              {
                  $recupLot = $odb->prepare('SELECT * FROM logs_loterie WHERE username = ? AND used = 0 AND date > ?');
                  $recupLot->execute(array($username,strtotime(date('d-m-Y 00:00:00'))));
                  $rowcLot = $recupLot->rowCount();
                  if($rowcLot == 1)
                  {
                      $recupLot = $recupLot->fetch();
                      if ($recupLot['nb'] == 0) {
                          $sLot = $odb->prepare('UPDATE logs_loterie SET used = 1 WHERE id = ?');
                          $sLot->execute(array($recupLot['id']));
                          die(error('Trop de comptes générés aujourd\'hui à partir de votre compte.'));
                      } else {
                          $limit = $limit + $recupLot['max'];
                          $newnb = $recupLot['nb'] - 1;
                          $sLot = $odb->prepare('UPDATE logs_loterie SET nb = ? WHERE id = ?');
                          $sLot->execute(array($newnb, $recupLot['id']));
                      }
                  } else {
                      die(error('Trop de comptes générés aujourd\'hui à partir de votre compte.'));
                  }
              }


              $match = false;	$accounts_array = explode(',', $accounts);
              foreach($accounts_array as $acc)
              {
                  if($acc == $type)
                  {
                      $match = true;
                  }
              }
              if($match == false)
              {
                  die(error('Votre abonnement ne vous permet pas de générer ce type de compte !'));
              }
              $SQLCount = $odb -> prepare("SELECT COUNT(*) FROM `accounts` WHERE `type` = ?");
              $SQLCount -> execute(array($type));
              if($SQLCount -> fetchColumn(0) == 0)
              {
                  die(error('Plus aucun compte n\'est disponible'));
              }
              $SQLGen = $odb -> prepare("SELECT * FROM `accounts` WHERE `type` = ? ORDER BY RAND() LIMIT 1");
              $SQLGen -> execute(array($type));
              $info = $SQLGen -> fetch(PDO::FETCH_BOTH);

              $SQLDEL = $odb -> prepare("DELETE FROM `accounts` WHERE `id` = ?");
              $SQLDEL -> execute(array($info['id']));

              $SQLog = $odb -> prepare("INSERT INTO `logs` VALUES (NULL, ?, ?, ?, ?, ?, ?, ?)");
              $SQLog -> execute(array($info['email'], $info['password'], $type, $username, time(), 0, 0));
              die(success('You have just generated an account!'));
          }





  ?>
