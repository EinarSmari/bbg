<?php
 	session_start();
	$name = $_SESSION['username'];

	require $_SERVER['DOCUMENT_ROOT'] . '/include/db_browsergame.inc.php';
	require $_SERVER['DOCUMENT_ROOT'] . '/browsergame/functions/stats.function.php';
	require $_SERVER['DOCUMENT_ROOT'] . '/browsergame/inc/logincheck.inc.php';
	
	$gold = getStat('gc',$userID);
	if($_POST) {
		$amount = $_POST['amount'];	
		if($_POST['action'] == 'Deposit') {
			if($amount > $gold || $amount == '') {
				// the user input something weird - assume the maximum
				$amount = $gold;	
			}
			setStat('gc',$userID,getStat('gc',$userID) - $amount);
			setStat('bankgc',$userID,getStat('bankgc',$userID)+$amount);
			$deposited = $amount;
		} else {
			$bankGold = getStat('bankgc',$userID);
			if($amount > $bankGold || $amount == '') {
				// the user input something weird again - again, assume the maximum
				$amount = $bankGold;
			}
			setStat('gc',$userID,getStat('gc',$userID) + $amount);
			setStat('bankgc',$userID,getStat('bankgc',$userID)-$amount);
			$withdrawn = $amount;
		}
	}
	 
	$gold = getStat('gc',$userID);
	$inbank = getStat('bankgc',$userID);
	require 'bank.html.php'; 
?>