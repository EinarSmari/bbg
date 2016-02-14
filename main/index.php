<?php
	session_start();
	$name = $_SESSION['username'];

	include $_SERVER['DOCUMENT_ROOT'] . '/include/db_browsergame.inc.php';
	require $_SERVER['DOCUMENT_ROOT'] . '/browsergame/inc/logincheck.inc.php';

	
	require_once $_SERVER['DOCUMENT_ROOT'] . '/browsergame/functions/stats.function.php';
	
	$setHP = getStat('sethp',$userID);
	if($setHP == 0) {
		setStat('curhp',$userID,10);
		setStat('maxhp',$userID,10);
		setStat('sethp',$userID,1);
	}
	$attack = getStat('atk', $userID);
	$magic = getStat('mag', $userID);
	$defence = getStat('def', $userID);
	$gold = getStat('gc', $userID);
	$currentHP = getStat('curhp', $userID);
	$maximumHP = getStat('maxhp', $userID);
	
	require "main.html.php";