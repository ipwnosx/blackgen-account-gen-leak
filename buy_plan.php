<?php
	require_once("inc/_global/config.php");
	ob_start();
	if(isset($_GET['id']) && Is_Numeric($_GET['id']) && $user -> LoggedIn()){
		$id = (int)$_GET['id'];
		$rowSQL = $odb -> prepare("SELECT * FROM `plans` WHERE `ID` = ?");
		$rowSQL -> execute(array($id));
		$row = $rowSQL -> fetch(PDO::FETCH_ASSOC);
		$query = array(
			'cmd' => '_pay',
			'reset' => '1',
			'ipn_url' => 'https://yourwebsite.com/ipn_plan.php', // YOUR IPN URL
			'merchant' => $coinpayments,
			'item_name' => $row['name'],
			'currency' => 'EUR',
			'amountf' => $row['price'],
			'quantity' => '1',
			'custom' => $id .'_'. $_SESSION['ID'],
			'allow_quantity' => "0",
			'want_shipping' => "0",
			'allow_extra' => "0"
		);
		$header = "https://www.coinpayments.net/index.php?". http_build_query($query);
		header('Location: ' . $header);
		exit;	} else{
		header('Location: home.php');
		exit;
	}?>
