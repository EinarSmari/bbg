<?php
 	session_start();
	$name = $_SESSION['username'];

	require $_SERVER['DOCUMENT_ROOT'] . '/include/db_browsergame.inc.php';
	require $_SERVER['DOCUMENT_ROOT'] . '/browsergame/functions/stats.function.php';
	require $_SERVER['DOCUMENT_ROOT'] . '/browsergame/inc/logincheck.inc.php';

	$gold = getStat('gc',$userID);
	if($_POST) {
		$amount = $_POST['amount'];
		$gold = getStat('gc',$userID);
		$needed = getStat('maxhp',$userID) - getStat('curhp',$userID);
		if($amount > $needed || $amount == '') {
			$amount = $needed;	
		}
		if($amount > $gold) {
			$amount = $gold;	
		}
		setStat('gc',$userID,getStat('gc',$userID) - $amount);
		setStat('curhp',$userID,getStat('curhp',$userID) + $amount);
		$healed = $amount;
	}
	 
	$curhp = getStat('curhp',$userID);
	$maxhp = getStat('maxhp',$userID);
	$gold = getStat('gc',$userID);
	  
	require 'healer.html.php'; 
?>