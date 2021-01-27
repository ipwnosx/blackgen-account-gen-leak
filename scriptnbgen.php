<?php
	require_once("inc/_global/config.php");
  $time = time();
  $periode = time() - 24*60*60;
  $recupNbGen = $odb->query("SELECT COUNT(*) FROM logs WHERE date < $time AND date > $periode");
  $recupNb = $recupNbGen->fetchColumn();

  $iStat = $odb->prepare('INSERT INTO stats(gen) VALUES(?)');
  $iStat->execute(array($recupNb));
?>
